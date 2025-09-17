<div>
    <div id="flipbook" class="relative w-full h-[600px]"></div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const pageFlip = new St.PageFlip(
                document.getElementById("flipbook"),
                {
                    width: 400,  // ancho de página
                    height: 600, // alto de página
                    size: "stretch",
                    minWidth: 315,
                    maxWidth: 1000,
                    minHeight: 420,
                    maxHeight: 1350,
                    drawShadow: true,
                    flippingTime: 700,
                    usePortrait: true,
                    startPage: 0,
                    autoSize: true,
                    maxShadowOpacity: 0.5,
                    showCover: true,
                }
            );

            pageFlip.loadFromImages(@json($pages));
        });
    </script>
</div>