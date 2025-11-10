<div>
  <style>
  :root{
    --viewer-width: 1200px;
    --viewer-height: 750px;
  }

  /* viewport externo para controlar overflow al hacer zoom (ahora con scroll) */
  .flipbook-viewport {
    width: var(--viewer-width);
    height: var(--viewer-height);
    margin: 0 auto;
    overflow: auto; /* <-- permite scroll cuando el contenido es mayor */
    box-sizing: border-box;
    position: relative;
    background: #efefef;
  }

  /* contenedor cuyo tamaño real será modificado para zoom */
  #flipbook-container {
    /* inicialmente ocupa 100% del viewport, pero su tamaño en px se ajusta por JS */
    width: 100%;
    height: 100%;
    background: linear-gradient(#ffffff, #fbfbfb);
    padding: 12px;
    box-sizing: border-box;
    perspective: 2400px;
    transform-origin: top left; /* ya no usamos transform para zoom, pero lo dejamos */
    position: relative;
  }

  /* Página (cada página ocupa la mitad del ancho del contenedor en modo spread) */
  .page {
    background: white;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    overflow: hidden;
    position: relative;
    transform-style: preserve-3d;
    transition: box-shadow 220ms ease;
    width: 100%;
    height: 100%;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px;
  }

  /* Wrapper para la vista de dos páginas */
  .spread {
    width: 100%;
    height: 100%;
    display: flex;
    gap: 8px;
    align-items: stretch;
    justify-content: center;
    box-sizing: border-box;
    padding: 12px;
    background: transparent;
  }
  .spread .page {
    width: calc((100% - 8px) / 2); /* cada página ocupa la mitad menos gap */
    height: 100%;
  }

  .page canvas {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: contain;
    background: #fff;
    backface-visibility: hidden;
  }

  .page.cover { border-radius: 2px; background: linear-gradient(180deg,#f7f9fb,#eaf0f7); }
  .page.cover::after { content:""; position:absolute; top:0; bottom:0; left:50%; width:10px; transform:translateX(-50%); background:linear-gradient(90deg, rgba(0,0,0,0.06), rgba(255,255,255,0.03)); pointer-events:none; }

  /* controls */
  .controls { text-align:center; margin-bottom:10px; display:flex; align-items:center; justify-content:center; gap:8px; flex-wrap:wrap; }
  .controls .btn { margin: 0 6px; }

  #pageIndicator { font-weight:500; color:#333; display:inline-block; margin:0 8px; }

  /* selector de modo */
  .view-mode { margin-left: 6px; padding:6px 8px; border-radius:4px; border:1px solid #ddd; background:white; }

  /* efecto hoja (clone) */
  .flip-clone { position:absolute; top:0; left:0; transform-origin:left center; transform-style:preserve-3d; backface-visibility:hidden; z-index:9999; box-shadow:0 20px 60px rgba(0,0,0,0.25); overflow:hidden; border-radius:2px; pointer-events:none; background:white; }
  .flip-clone.right-origin { transform-origin: right center; }
  .flip-clone .face { position:absolute; inset:0; backface-visibility:hidden; }
  .flip-clone .face.back { transform:rotateY(180deg); background: linear-gradient(180deg,#f8f8f8,#efefef); }
  .flipping { transition: transform 600ms cubic-bezier(.2,.9,.3,1), box-shadow 600ms; }

  .flip-shadow { position:absolute; top:0; bottom:0; width:18%; right:-6%; pointer-events:none; background: linear-gradient(90deg, rgba(0,0,0,0.22), rgba(0,0,0,0)); filter:blur(8px); opacity:0; transition: opacity 300ms; z-index:9998; }
  .flip-shadow.active { opacity:1; }

  @media (max-width:900px){ .flipbook-viewport{ width:100%; height:650px; } .spread .page { width: calc((100% - 8px)/2); } }

  /* evitar scroll horizontal general */
  body { overflow-x: hidden; }
  </style>

  <div class="controls">
    <div style="display:flex; gap:6px; align-items:center;">
      <button class="btn btn-sm btn-secondary" id="zoomOutBtn">-</button>
      <button class="btn btn-sm btn-secondary" id="zoomInBtn">+</button>
      <button class="btn btn-sm btn-secondary" id="fitBtn">Ajustar</button>
    </div>

    <div style="display:flex; gap:8px; align-items:center;">
      <label for="viewModeSelect">Ver:</label>
      <select id="viewModeSelect" class="view-mode" title="Ver 1 o 2 hojas">
        <option value="2" selected>2 hojas</option>
        <option value="1">1 hoja</option>
      </select>
    </div>

    <div style="display:flex; gap:8px; align-items:center;">
      <button class="btn btn-sm btn-primary" id="prevBtn">Anterior</button>
      <span id="pageIndicator">Cargando...</span>
      <button class="btn btn-sm btn-primary" id="nextBtn">Siguiente</button>
    </div>
  </div>

  <div class="flipbook-viewport" id="flipbook-viewport">
    <div id="flipbook-container"></div>
  </div>

  <script>
  document.addEventListener('livewire:load', async () => {
    const fileId = @json($fileId);
    const initialRender = @json($initialRender ?? 4); // carga 4 páginas inicialmente (2 spreads)
    const batchSize = @json($batchSize ?? 4);
    const pdfUrl = @json(route('pdf.download', ['fileId' => $fileId]));
    const viewport = document.getElementById('flipbook-viewport');
    const container = document.getElementById('flipbook-container');
    const pageIndicator = document.getElementById('pageIndicator');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const zoomInBtn = document.getElementById('zoomInBtn');
    const zoomOutBtn = document.getElementById('zoomOutBtn');
    const fitBtn = document.getElementById('fitBtn');
    const viewModeSelect = document.getElementById('viewModeSelect');

    console.log('PDF URL:', pdfUrl);

    // --- Zoom state (ahora ajustamos tamaño real del contenedor para permitir scroll) ---
    let zoomLevel = 1;
    const zoomStep = 0.1;
    const maxZoom = 3.0;
    const minZoom = 0.5;

    // Guardamos las dimensiones base del contenedor (en px) para multiplicar por zoom
    let baseContainerWidth = null;
    let baseContainerHeight = null;

    function updateBaseContainerSize() {
      // El tamaño base que queremos que represente 100% (sin zoom)
      const vpRect = viewport.getBoundingClientRect();
      // reservamos el padding interior que usa #flipbook-container (12px both sides)
      const paddingX = 24; // left+right
      const paddingY = 24; // top+bottom
      baseContainerWidth = Math.max(vpRect.width - 0, 300); // al menos 300
      baseContainerHeight = Math.max(vpRect.height - 0, 200);
      // inicialmente dejamos el container en el tamaño base (100%)
      container.style.width = baseContainerWidth + 'px';
      container.style.height = baseContainerHeight + 'px';
    }

    // Aplica el zoom modificando width/height reales del contenedor (genera scroll en viewport)
    async function applyZoom() {
      // calcular nuevo tamaño en px
      const w = Math.round(baseContainerWidth * zoomLevel);
      const h = Math.round(baseContainerHeight * zoomLevel);
      container.style.width = w + 'px';
      container.style.height = h + 'px';
      // nos aseguramos de que el contenido interno (pages) se ajuste proporcionalmente vía CSS 100%
      // re-renderizar canvases para nitidez con nueva escala/size
      try { await rerenderLoadedPages(); } catch(e){ console.warn('rerender error', e); }
      // actualizar PageFlip si aplica
      if (pageFlip && typeof pageFlip.update === 'function') {
        try { pageFlip.update(); } catch (e) { console.warn(e); }
      }
    }

    // Fit (restablece zoom a 1 y centra el viewport)
    function fitToViewer(){
      zoomLevel = 1;
      applyZoom().then(()=> {
        // opcional: centrar scroll
        viewport.scrollTop = 0;
        viewport.scrollLeft = 0;
      }).catch(()=>{});
    }

    // Viewer mode: 1 o 2 páginas
    let pagesPerView = parseInt(viewModeSelect.value, 10) || 2;
    viewModeSelect.addEventListener('change', () => {
      pagesPerView = parseInt(viewModeSelect.value, 10) || 2;
      if (!usingFallback) {
        try { if (pageFlip && typeof pageFlip.update === 'function') pageFlip.update(); } catch(e){ console.warn(e); }
      }
      if (usingFallback) {
        if (pagesPerView === 2) {
          fallbackIndex = Math.max(0, Math.floor(fallbackIndex / 2) * 2);
          showFallbackPagePair(fallbackIndex);
        } else {
          showFallbackSingle(fallbackIndex);
        }
      }
    });

    // Inicializar PageFlip
    let pageFlip = null;
    try {
      // inicializamos base container size antes de crear PageFlip
      updateBaseContainerSize();
      pageFlip = new St.PageFlip(container, {
        width: baseContainerWidth,
        height: baseContainerHeight,
        size: "fixed",
        usePortrait: true,
        maxShadowOpacity: 0.7,
      });
      console.log('St.PageFlip inicializado', pageFlip);
    } catch (e) {
      console.warn('No se pudo iniciar St.PageFlip:', e);
      pageFlip = null;
    }

    // Cargar PDF
    let pdf;
    try {
      const loadingTask = pdfjsLib.getDocument({ url: pdfUrl, withCredentials: true });
      pdf = await loadingTask.promise;
      console.log('PDF cargado. Páginas:', pdf.numPages);
    } catch (err) {
      console.error('Error cargando PDF:', err);
      pageIndicator.innerText = 'Error al cargar el PDF (ver consola).';
      container.innerHTML = `<a href="${pdfUrl}" target="_blank">Abrir PDF en nueva pestaña</a>`;
      return;
    }

    const numPages = pdf.numPages;
    let loadedUpTo = 0;
    const renderedPages = [];
    const renderedPageNumbers = [];

    function getTargetPageWidth() {
      // el target se basa en el tamaño actual del container (sin zoom)
      // usamos baseContainerWidth para calcular las proporciones internas
      if (pagesPerView === 2) {
        return Math.max((baseContainerWidth - 24) / 2, 300);
      } else {
        return Math.max(baseContainerWidth - 24, 300);
      }
    }
    function getTargetPageHeight() {
      return Math.max(baseContainerHeight - 24, 200);
    }

    async function renderPagesElements(count) {
      const pages = [];
      for (let i = 0; i < count; i++) {
        loadedUpTo++;
        if (loadedUpTo > numPages) break;

        const pageNum = loadedUpTo;
        const page = await pdf.getPage(pageNum);
        const baseViewport = page.getViewport({ scale: 1 });

        const targetW = getTargetPageWidth();
        const targetH = getTargetPageHeight();
        const pixelRatio = window.devicePixelRatio || 1;
        const scaleW = (targetW * pixelRatio) / baseViewport.width;
        const scaleH = (targetH * pixelRatio) / baseViewport.height;
        const finalScale = Math.max(Math.min(scaleW, scaleH), 1);

        const viewportPdf = page.getViewport({ scale: finalScale });

        const canvas = document.createElement('canvas');
        canvas.width = Math.floor(viewportPdf.width);
        canvas.height = Math.floor(viewportPdf.height);
        canvas.style.width = '100%';
        canvas.style.height = '100%';
        canvas.style.display = 'block';
        canvas.style.background = '#fff';

        try {
          const renderContext = { canvasContext: canvas.getContext('2d'), viewport: viewportPdf };
          await page.render(renderContext).promise;
        } catch (e) {
          console.error('Error renderizando página', pageNum, e);
        }

        const wrapper = document.createElement('div');
        wrapper.className = 'page';
        wrapper.dataset.page = String(pageNum);
        wrapper.style.width = '100%';
        wrapper.style.height = '100%';
        wrapper.style.boxSizing = 'border-box';
        wrapper.style.padding = '8px';
        wrapper.appendChild(canvas);

        pages.push(wrapper);
        renderedPages.push(wrapper);
        renderedPageNumbers.push(pageNum);
      }
      return pages;
    }

    // Re-renderiza todos los canvases ya cargados (útil en resize/zoom)
    async function rerenderLoadedPages() {
      if (!pdf) return;
      for (let i = 0; i < renderedPages.length; i++) {
        const pageNum = renderedPageNumbers[i];
        const wrapper = renderedPages[i];
        if (!wrapper) continue;
        try {
          const page = await pdf.getPage(pageNum);
          const baseViewport = page.getViewport({ scale: 1 });
          const targetW = getTargetPageWidth();
          const targetH = getTargetPageHeight();
          const pixelRatio = window.devicePixelRatio || 1;
          const scaleW = (targetW * pixelRatio) / baseViewport.width;
          const scaleH = (targetH * pixelRatio) / baseViewport.height;
          const finalScale = Math.max(Math.min(scaleW, scaleH), 1);
          const viewportPdf = page.getViewport({ scale: finalScale });

          const newCanvas = document.createElement('canvas');
          newCanvas.width = Math.floor(viewportPdf.width);
          newCanvas.height = Math.floor(viewportPdf.height);
          newCanvas.style.width = '100%';
          newCanvas.style.height = '100%';
          newCanvas.style.display = 'block';
          newCanvas.style.background = '#fff';

          try {
            const renderContext = { canvasContext: newCanvas.getContext('2d'), viewport: viewportPdf };
            await page.render(renderContext).promise;
            const old = wrapper.querySelector('canvas');
            if (old) old.replaceWith(newCanvas);
            else wrapper.appendChild(newCanvas);
          } catch (e) {
            console.warn('Error re-render canvas page', pageNum, e);
          }
        } catch (e) {
          console.warn('Error recuperando página para re-render', pageNum, e);
        }
      }
    }

    async function appendToFlip(pages) {
      if (!pages || pages.length === 0) return false;
      if (!pageFlip) return false;

      if (typeof pageFlip.appendPages === 'function') {
        try {
          pageFlip.appendPages(pages);
          try { pageFlip.update(); } catch(e){}
          return true;
        } catch (e) { console.warn('appendPages falló:', e); }
      }
      if (typeof pageFlip.loadFromHTML === 'function') {
        try {
          pageFlip.loadFromHTML(pages, true);
          try { pageFlip.update(); } catch(e){}
          return true;
        } catch (e) { console.warn('loadFromHTML(array, true) falló:', e); }
      }
      try {
        const existing = Array.from(container.querySelectorAll('.page'));
        const all = existing.concat(pages);
        pageFlip.loadFromHTML(all);
        try { pageFlip.update(); } catch(e){}
        return true;
      } catch (e) {
        console.warn('loadFromHTML(all) falló:', e);
      }
      return false;
    }

    // ----- FALLBACK: dos páginas lado a lado (spread) y single view -----
    let fallbackIndex = 0; // índice 0-based para la página izquierda de la pareja
    const FLIP_DURATION_MS = 600;

    function showFallbackPagePair(indexPairStart) {
      container.innerHTML = '';
      const spread = document.createElement('div');
      spread.className = 'spread';

      const left = renderedPages[indexPairStart] ?? null;
      const right = renderedPages[indexPairStart + 1] ?? null;

      if (left) {
        left.style.width = 'calc((100% - 8px) / 2)';
        left.style.height = '100%';
        spread.appendChild(left);
      } else {
        const ph = document.createElement('div'); ph.style.width = 'calc((100% - 8px) / 2)'; ph.style.height = '100%'; spread.appendChild(ph);
      }

      if (right) {
        right.style.width = 'calc((100% - 8px) / 2)';
        right.style.height = '100%';
        spread.appendChild(right);
      } else {
        const ph = document.createElement('div'); ph.style.width = 'calc((100% - 8px) / 2)'; ph.style.height = '100%'; spread.appendChild(ph);
      }

      container.appendChild(spread);
      updateIndicatorFallback(indexPairStart);
    }

    function showFallbackSingle(index) {
      container.innerHTML = '';
      const area = document.createElement('div');
      area.style.width = '100%';
      area.style.height = '100%';
      area.style.display = 'flex';
      area.style.justifyContent = 'center';
      area.style.alignItems = 'center';
      area.style.position = 'relative';
      area.style.background = '#f6f6f6';

      const pageNode = renderedPages[index] ?? null;
      if (pageNode) {
        pageNode.style.width = '100%';
        pageNode.style.height = '100%';
        area.appendChild(pageNode);
      } else {
        const ph = document.createElement('div'); ph.style.width = '100%'; ph.style.height = '100%'; area.appendChild(ph);
      }

      container.appendChild(area);
      updateIndicatorFallback(index);
    }

    function updateIndicatorFallback(startIdxZero) {
      const leftNum = startIdxZero + 1;
      if (pagesPerView === 2) {
        const rightNum = Math.min(startIdxZero + 2, numPages);
        pageIndicator.innerText = `Página ${leftNum}–${rightNum} de ${numPages}`;
      } else {
        pageIndicator.innerText = `Página ${leftNum} de ${numPages}`;
      }
    }

    // animación flip para pair: clona y gira la hoja que se pliega
    function animateFallbackFlip(direction = 'next') {
      const pairStart = fallbackIndex;
      const left = renderedPages[pairStart] ?? null;
      const right = renderedPages[pairStart + 1] ?? null;

      let source = (direction === 'next') ? right : left;
      if (!source) {
        if (direction === 'next') {
          fallbackIndex = Math.min(fallbackIndex + 2, Math.max(0, renderedPages.length - (renderedPages.length % 2 === 0 ? 2 : 1)));
        } else {
          fallbackIndex = Math.max(0, fallbackIndex - 2);
        }
        if (pagesPerView === 2) showFallbackPagePair(fallbackIndex); else showFallbackSingle(fallbackIndex);
        return Promise.resolve();
      }

      const rect = source.getBoundingClientRect();
      const containerRect = container.getBoundingClientRect();
      const clone = document.createElement('div');
      clone.className = 'flip-clone';
      if (direction === 'next') clone.classList.add('right-origin');

      const relativeLeft = rect.left - containerRect.left;
      clone.style.width = rect.width + 'px';
      clone.style.height = rect.height + 'px';
      clone.style.left = relativeLeft + 'px';
      clone.style.top = (rect.top - containerRect.top) + 'px';
      clone.style.transform = 'rotateY(0deg)';
      clone.style.transformOrigin = (direction === 'next') ? 'right center' : 'left center';

      const front = document.createElement('div'); front.className = 'face front';
      const canvas = source.querySelector('canvas');
      if (canvas) {
        const canvasClone = document.createElement('canvas');
        canvasClone.width = canvas.width;
        canvasClone.height = canvas.height;
        canvasClone.style.width = '100%';
        canvasClone.style.height = '100%';
        const ctx = canvasClone.getContext('2d');
        try { ctx.drawImage(canvas, 0, 0); front.appendChild(canvasClone); }
        catch (e) { front.appendChild(canvas.cloneNode(true)); }
      } else { front.innerHTML = source.innerHTML; }
      const back = document.createElement('div'); back.className = 'face back'; back.innerHTML = '';

      clone.appendChild(front); clone.appendChild(back);

      const shadow = document.createElement('div'); shadow.className = 'flip-shadow';
      container.appendChild(shadow); container.appendChild(clone);
      clone.getBoundingClientRect();
      clone.classList.add('flipping'); shadow.classList.add('active');

      const targetDeg = (direction === 'next') ? -180 : 180;
      clone.style.transform = `rotateY(${targetDeg}deg)`;
      shadow.style.right = (direction === 'next') ? (containerRect.width - (relativeLeft + rect.width) - rect.width * 0.06) + 'px' : (-containerRect.width + relativeLeft + rect.width * 0.06) + 'px';
      shadow.style.opacity = '1';

      return new Promise((resolve) => {
        setTimeout(() => {
          try { clone.remove(); } catch(e){}
          try { shadow.remove(); } catch(e){}
          if (direction === 'next') fallbackIndex = Math.min(fallbackIndex + 2, Math.max(0, renderedPages.length - (renderedPages.length % 2 === 0 ? 2 : 1)));
          else fallbackIndex = Math.max(0, fallbackIndex - 2);
          if (pagesPerView === 2) showFallbackPagePair(fallbackIndex); else showFallbackSingle(fallbackIndex);
          resolve();
        }, FLIP_DURATION_MS + 60);
      });
    }

    // ----- Carga inicial -----
    const firstPages = await renderPagesElements(initialRender);
    let injected = await appendToFlip(firstPages);
    let usingFallback = !injected;

    if (usingFallback) {
      console.warn('Usando fallback paginado porque PageFlip no aceptó las páginas.');
      if (pagesPerView === 2) showFallbackPagePair(0);
      else showFallbackSingle(0);
    } else {
      try { if (pageFlip && typeof pageFlip.update === 'function') pageFlip.update(); } catch(e){}
      updateIndicator();
    }

    // Botones
    prevBtn.addEventListener('click', async () => {
      if (!usingFallback && pageFlip) {
        try { pageFlip.flipPrev(); } catch(e){ console.warn(e); }
        updateIndicator();
        return;
      }
      if (pagesPerView === 2) await animateFallbackFlip('prev');
      else {
        fallbackIndex = Math.max(0, fallbackIndex - 1);
        if (renderedPages[fallbackIndex]) showFallbackSingle(fallbackIndex);
      }
    });

    nextBtn.addEventListener('click', async () => {
      if (!usingFallback && pageFlip) {
        try { pageFlip.flipNext(); } catch(e){ console.warn(e); }
        updateIndicator();
        try {
          const currentIdx = (typeof pageFlip.getCurrentPageIndex === 'function') ? pageFlip.getCurrentPageIndex() : 0;
          if (loadedUpTo < numPages && loadedUpTo - currentIdx < 6) {
            const more = await renderPagesElements(batchSize);
            await appendToFlip(more);
          }
        } catch(e){ console.warn(e); }
        return;
      }

      if (pagesPerView === 2) {
        const needIndex = fallbackIndex + 2 + 1;
        if (needIndex >= renderedPages.length && loadedUpTo < numPages) {
          const toLoad = Math.min(numPages - loadedUpTo, batchSize);
          await renderPagesElements(toLoad);
        }
        await animateFallbackFlip('next');
      } else {
        const needIndex = fallbackIndex + 1;
        if (needIndex >= renderedPages.length && loadedUpTo < numPages) {
          const toLoad = Math.min(numPages - loadedUpTo, batchSize);
          await renderPagesElements(toLoad);
        }
        fallbackIndex = Math.min(fallbackIndex + 1, Math.max(0, renderedPages.length - 1));
        showFallbackSingle(fallbackIndex);
      }
    });

    // Zoom buttons
    zoomInBtn.addEventListener('click', async () => {
      zoomLevel = Math.min(maxZoom, +(zoomLevel + zoomStep).toFixed(2));
      await applyZoom();
    });
    zoomOutBtn.addEventListener('click', async () => {
      zoomLevel = Math.max(minZoom, +(zoomLevel - zoomStep).toFixed(2));
      await applyZoom();
    });
    fitBtn.addEventListener('click', () => { fitToViewer(); });

    // indicador para PageFlip
    function updateIndicator() {
      try {
        if (!pageFlip) return;
        const current = (typeof pageFlip.getCurrentPageIndex === 'function') ? pageFlip.getCurrentPageIndex() : 0;
        const pageNum = Math.min(current + 1, numPages);
        const nextNum = Math.min(pageNum + 1, numPages);
        pageIndicator.innerText = `Página ${pageNum}–${nextNum} de ${numPages}`;
      } catch (e) {
        pageIndicator.innerText = `1–2 de ${numPages}`;
      }
    }

    // Resize: actualizar tamaños base, re-renderizar canvases y actualizar PageFlip
    let resizeTimer = null;
    function onResize() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(async () => {
        // recalcular base size
        updateBaseContainerSize();
        // aplicar zoom actual (modifica container size en px)
        await applyZoom();
        // actualizar pageFlip
        if (pageFlip && typeof pageFlip.update === 'function') {
          try { pageFlip.update(); } catch(e){ console.warn(e); }
        }
        // re-mostrar fallback para reajustar layout
        if (usingFallback) {
          if (pagesPerView === 2) showFallbackPagePair(fallbackIndex);
          else showFallbackSingle(fallbackIndex);
        }
      }, 250);
    }
    window.addEventListener('resize', onResize);

    // Exponer rerender manual por si lo necesitas
    window.__rerenderFlipbook = async () => { await rerenderLoadedPages(); console.log('Re-render completado'); };

    // aplicar tamaño base y zoom inicial
    updateBaseContainerSize();
    await applyZoom();

    console.log('Final init: usingFallback=', usingFallback, 'loadedUpTo=', loadedUpTo, 'renderedPages=', renderedPages.length);
  });
  </script>

  <!-- PDF.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.9.179/pdf.min.js"></script>
  <script> if (pdfjsLib) pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.9.179/pdf.worker.min.js'; </script>

  <!-- StPageFlip -->
  <link rel="stylesheet" href="https://unpkg.com/stpageflip/dist/page-flip.min.css" />
  <script src="https://unpkg.com/stpageflip/dist/page-flip.min.js"></script>
</div>