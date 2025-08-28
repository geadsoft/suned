<div>
    <div id="flipbook" class="w-full h-screen"></div>

    {{-- Librerías necesarias --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.13.216/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/turn.js/4.1.0/turn.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const fileId = @json($fileId);
            const url = `https://drive.google.com/uc?export=download&id=${fileId}`;

            alert(url)

            pdfjsLib.getDocument(url).promise.then(function (pdf) {
                let pagesPromises = [];
                
                for (let i = 1; i <= pdf.numPages; i++) {
                    pagesPromises.push(pdf.getPage(i).then(function (page) {
                        let viewport = page.getViewport({ scale: 1.2 });
                        let canvas = document.createElement("canvas");
                        let context = canvas.getContext("2d");
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        return page.render({ canvasContext: context, viewport: viewport }).promise.then(() => {
                            return canvas;
                        });
                    }));
                }

                Promise.all(pagesPromises).then(function (canvases) {
                    let flipbook = document.getElementById("flipbook");
                    canvases.forEach(canvas => {
                        let pageDiv = document.createElement("div");
                        pageDiv.appendChild(canvas);
                        flipbook.appendChild(pageDiv);
                    });

                    $("#flipbook").turn({
                        width: 900,
                        height: 600,
                        autoCenter: true,
                        elevation: 50,
                        gradients: true
                    });
                });
            });
        });
    </script>
</div>