<?= $this->extend('layout') ?>

<?= $this->section('header') ?>
<title>Equipos - Sistema Cronos</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-3 p-2">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-laptop text-black-50" style="font-size: 15pt; margin-top: -4px; margin-right: 4px;"></i>
                        <h3>Equipos</h3>
                    </div>
                </div>
                <div class="col-6 d-flex flex-row flex-wrap align-content-center justify-content-end">
                    <button id="btnNuevoEditar" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa fa-plus"></i> Nuevo equipo</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table id="tblEquipos" class="table table-striped table-hover dt-responsive display wrap">
                    <thead>
                        <tr>
                            <th>Datos de Cliente</th>
                            <th>Datos de Equipo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($equipos as $key => $equipo) : ?>
                            <tr>
                                <td>
                                    <strong>Nombres</strong> <?= $equipo["cliente"]["nombre"] ?> <?= $equipo["cliente"]["apellido_paterno"] ?> <?= $equipo["cliente"]["apellido_materno"] ?><br>
                                    <strong>Tipo Doc.</strong> <?= strtoupper($equipo["cliente"]["tipo_doi"]) ?><br>
                                    <strong>Núm. Doc.</strong> <?= $equipo["cliente"]["numero_doi"] ?><br>

                                </td>
                                <td>
                                    <strong>Marca: </strong><?= $equipo["marca"] ?><br>
                                    <strong>Modelo: </strong><?= $equipo["modelo"] ?><br>
                                    <strong>Código barras: </strong><?= $equipo["codigo_barras"] ?>
                                </td>

                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-primary" href="<?= base_url("/diagnostico") ?>/<?= $equipo['id'] ?>"><i class="fa fa-tools"></i></a>
                                        <button type="button" onclick="barcode('<?= $equipo['codigo_barras']; ?>','<?= $equipo['marca'] ?>','<?= $equipo['modelo'] ?>','<?= $equipo['serie'] ?>');" class="btn btn-info"><i class="fa fa-barcode"></i></button>
                                        <button type="button" onclick="editar(<?= $equipo['id'] ?>);" class="btn btn-warning"><i class="fa fa-pen"></i></button>
                                        <button type="button" onclick="eliminar(<?= $equipo['id'] ?>);" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!-- -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Nuevo Equipo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="txtClaveProp">Seleccione cliente</label>
                            <select class="" id="selectCliente">
                                <?php foreach ($clientes as $key => $cliente) : ?>
                                    <option value="<?= $cliente["id"] ?>"><?= $cliente["nombre"] ?> <?= $cliente["apellido_paterno"] ?> <?= $cliente["apellido_materno"] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label for="txtMarca">Marca</label>
                            <input class="form-control" id="txtMarca" onkeyup="checkColor(this);" type="text" placeholder="Dell">
                        </div>
                        <div class="col-md-4">
                            <label for="txtModelo">Modelo</label>
                            <input class="form-control" id="txtModelo" onkeyup="checkColor(this);" type="text" placeholder="Inspiron 3593">
                        </div>
                        <div class="col-md-4">
                            <label for="txtSerie">Serie</label>
                            <input class="form-control" id="txtSerie" onkeyup="checkColor(this);" type="text" placeholder="XY1ZAB2">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Fin modal-->

    <div class="modal fade" id="modalBarCode" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Código de barras</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="etiqueta" class="modal-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="col-7">
                                <div class="d-flex flex-column">

                                    <div class="border p-1">
                                        <strong>Innite Solutions Perú E.I.R.L.</strong><br class="p-0 m-0">
                                        <strong>RUC: 20611687746</strong>
                                        <p class="pb-0 mb-0 small"><i class="fa fa-globe"></i> www.innite.net | <i class="fa-brands fa-whatsapp"></i> 939702745 </p>
                                        <p class="pb-0 mb-0 small"><i class="fa fa-envelope"></i> servicios.digitales@innite.net</p>


                                    </div>

                                </div>
                            </div>

                            <div class="col-5">
                                <!-- 
                                    <div class="row">
                                    <div class="col-6">
                                        <p class="pb-0 mb-0"><strong>Marca: </strong><span id="lblMarca">marca</span></p>
                                        <p class="pb-0 mb-0"><strong>Modelo: </strong><span id="lblModelo">modelo</span></p>
                                        <p class="pb-0 mb-0"><strong>Serie: </strong><span id="lblSerie">serie</span></p>
                                    </div>
                                    <div class="col-6">
                                    </div>
                                </div>

                                -->
                                <img class="img-thumbnail mt-2" id="codigo" />
                            </div>

                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" onclick="imprimir();" disabled class="btn btn-success" id="btnImprimir"><i class="fa fa-print"></i> Imprimir</button>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

<script>
    let table;
    let img;
    let can;
    let equipos;
    let equipo;

    $(document).ready(() => {
        table = new DataTable("#tblEquipos", {
            /*  language: {
                  url: '//cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json',
              },*/
            searching: false
        });
        cargarEquipos();
        dselect(document.querySelector("#selectCliente"), {
            search: true,
            creatable: false,
            clearable: false
        });
        $(".dselect-wrapper .dropdown-menu").addClass("w-100 p-2");
        $(".dselect-wrapper .dropdown-menu input[type=text]").addClass("mb-2");
        $('#modalBarCode').on('shown.bs.modal', getScreenShot);
        $("#btnGuardar").click(guardar);
        $("#btnNuevoEditar").click(reset);
    });



    function checkColor(input) {
        if (input.value.length == 0) {
            $(input).addClass("border-danger");
        } else {
            $(input).removeClass("border-danger");
        }
    }

    function guardar() {
        let id_cliente = $("#selectCliente").val();
        let marca = $("#txtMarca").val();
        let modelo = $("#txtModelo").val();
        let serie = $("#txtSerie").val();

        if (!id_cliente || !marca || !modelo || !serie) {
            Swal.fire({
                icon: "warning",
                title: "Faltan datos",
                html: "Debe ingresar todos los datos del equipo."
            });
        } else {
            let data = {
                id_cliente: id_cliente,
                marca: marca,
                modelo: modelo,
                serie: serie
            };
            if (equipo) {
                data.id = equipo.id;
            }

            $.ajax({
                method: "POST",
                url: `<?= base_url("/api/equipo") ?>/${equipo?"editar":"nuevo"}`,
                data: data,
                beforeSend: () => {

                },
                success: (data) => {
                    if (data.id) {
                        $("#staticBackdrop").modal("hide");
                        Swal.fire({
                            icon: "success",
                            title: "Guardado con éxito",
                            text: "Se guardó el equipo con éxito."
                        });
                        cargarEquipos();
                    }
                }

            });

        }
    }

    function cargarEquipos() {
        $.ajax({
            method: "get",
            url: "<?= base_url("/api/equipo") ?>/listar",
            success: (data) => {
                equipos = data.lista;
                table.clear().draw();
                console.log(equipos);
                $.each(data.lista, function(index, equipo) {

                    table.row.add([
                        `
                        <strong>Nombres</strong> ${equipo.cliente.nombre} ${equipo.cliente.apellido_paterno} ${equipo.cliente.apellido_materno}<br>
                        <strong>Tipo Doc.</strong> ${equipo.cliente.tipo_doi}<br>
                        <strong>Núm. Doc.</strong> ${equipo.cliente.numero_doi}<br>
                      `,
                        `
                        <strong>Marca: </strong>${equipo.marca} <br>
                        <strong>Modelo: </strong>${equipo.modelo} <br>
                        <strong>Código barras: </strong> ${equipo.codigo_barras}
                      `,
                        `
                        <div class="btn-group">
                            <a class="btn btn-primary" href="<?= base_url("/diagnostico") ?>/${equipo.id}"><i class="fa fa-tools"></i></a>
                            <button type="button" onclick="barcode('${equipo.codigo_barras}','${equipo.marca}','${equipo.modelo}','${equipo.serie}');" class="btn btn-info"><i class="fa fa-barcode"></i></button>
                            <button type="button" onclick="editar('${equipo.id}');" class="btn btn-warning"><i class="fa fa-pen"></i></button>
                            <button type="button" onclick="eliminar('${equipo.id}');" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </div>
                        `
                    ]).draw();

                });

            },
            complete: () => {
                table.responsive.rebuild();
                table.responsive.recalc();
            }
        });
    }

    function barcode(code, marca, modelo, serie) {

        JsBarcode("#codigo", code);
        $("#lblMarca").text(marca);
        $("#lblModelo").text(modelo);
        $("#lblSerie").text(serie);
        $("#modalBarCode").modal("show");
    }

    function imprimir() {
        var dataUrl = can.toDataURL(); //attempt to save base64 string to server using this var  
        var windowContent = `
        <!DOCTYPE html>
        <html>
        <style>
            @page 
            {
                size:  455px 195px;   /* auto es el valor inicial */
                margin: 0mm;  /* afecta el margen en la configuración de impresión */
                padding:0mm;
            }
        </style>
        <body>
        <img src="${dataUrl}">
        </body>
        </html>`;
        var printWin = window.open('', '');
        printWin.document.open();
        printWin.document.write(windowContent);
        printWin.document.close();
        printWin.focus();
        printWin.print();
        setTimeout(() => {
            $("#modalBarCode").modal("hide");
            printWin.close();
        }, 200);
    }

    function getScreenShot() {
        let c = document.querySelector('#etiqueta');
        html2canvas(c).then((canvas) => {
            can = canvas;
            $("#btnImprimir").removeAttr("disabled");
        });
    }

    function eliminar(id) {
        equipo = equipos.find(e => e.id == id);

        Swal.fire({
            title: `¿Seguro que deseas eliminar el equipo de ${equipo.cliente.nombre} ${equipo.cliente.apellido_paterno} ${equipo.cliente.apellido_materno}?`,
            html: `
                <p>Revise los datos antes de continuar: </p>
                <strong>Marca: </strong> ${equipo.marca} <br>
                <strong>Modelo: </strong> ${equipo.modelo}<br>
                <strong>Serie: </strong> ${equipo.serie}<br><br>
                <strong class="text-danger">Se borrarán también todos los diagnósticos.</strong>
            `,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Eliminar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "post",
                    url: "<?= base_url("/api/equipo/eliminar") ?>",
                    data: {
                        id: id
                    },
                    success: (data) => {
                        cargarEquipos();
                        Swal.fire({
                            icon: "success",
                            title: "Éxito",
                            html: data.mensajes[0]
                        });
                        $("#staticBackdrop").modal("hide");
                    }
                });
            }
        });
    }

    function reset() {
        $("#txtMarca").val("");
        $("#txtModelo").val("");
        $("#txtSerie").val("");
        equipo = null;
    }

    function editar(id) {
        equipo = equipos.find(e => e.id == id);
        $("#txtMarca").val(equipo.marca);
        $("#txtModelo").val(equipo.modelo);
        $("#txtSerie").val(equipo.serie);

        dselect(document.querySelector("#selectCliente"), {
            search: true,
            creatable: false,
            clearable: false
        });
        $("#selectCliente option[value='" + equipo.id_cliente + "']").prop("selected", true);
        dselect(document.querySelector("#selectCliente"));
        $("#staticBackdropLabel").text(`Editar equipo ${equipo.marca} ${equipo.modelo}`);
        $("#staticBackdrop").modal("show");
    }
</script>
<?= $this->endSection() ?>