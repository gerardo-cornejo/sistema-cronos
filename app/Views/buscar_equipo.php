<?= $this->extend('layout') ?>

<?= $this->section('header') ?>
<title>Equipos - Sistema Cronos</title>
<style>
    #contenedor video {
        max-width: 100%;
        width: 100%;
    }

    canvas {
        max-width: 100%;
    }

    canvas.drawingBuffer {
        position: absolute;
        /*top: 135px;*/
        left: 0;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-3 p-2">
    <div class="card">
        <div class="card-header">
            <h4>Búsqueda por Código de Barras</h4>
        </div>

        <div class="card-body">

            <div id="contenedor" class="w-100">

            </div>

        </div>
    </div>



</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://unpkg.com/quagga@0.12.1/dist/quagga.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const $resultados = document.querySelector("#resultado");
        Quagga.init({
            inputStream: {
                constraints: {
                    width: 1920,
                    height: 1080,
                },
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#contenedor'), // Pasar el elemento del DOM
            },
            decoder: {
                readers: ["ean_reader", "code_128_reader"]
            },
            locator: {
                patchSize: "large",
                halfSample: false,
            },
            numOfWorkers: 2,
            canvas: {
                willReadFrequently: true // Configurar willReadFrequently en true
            }
        }, function(err) {
            if (err) {
                console.log(err);
                return
            }
            console.log("Iniciado correctamente");
            Quagga.start();
        });

        Quagga.onDetected((data) => {

            $(document).ready(() => {
                location.href = "<?= base_url("equipos/buscar") ?>/" + data.codeResult.code;
            });

        });

        Quagga.onProcessed(function(result) {
            var drawingCtx = Quagga.canvas.ctx.overlay,
                drawingCanvas = Quagga.canvas.dom.overlay;

            if (result) {
                if (result.boxes) {
                    drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
                    result.boxes.filter(function(box) {
                        return box !== result.box;
                    }).forEach(function(box) {
                        Quagga.ImageDebug.drawPath(box, {
                            x: 0,
                            y: 1
                        }, drawingCtx, {
                            color: "green",
                            lineWidth: 2
                        });
                    });
                }

                if (result.box) {
                    Quagga.ImageDebug.drawPath(result.box, {
                        x: 0,
                        y: 1
                    }, drawingCtx, {
                        color: "#00F",
                        lineWidth: 2
                    });
                }

                if (result.codeResult && result.codeResult.code) {
                    Quagga.ImageDebug.drawPath(result.line, {
                        x: 'x',
                        y: 'y'
                    }, drawingCtx, {
                        color: 'red',
                        lineWidth: 3
                    });
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>