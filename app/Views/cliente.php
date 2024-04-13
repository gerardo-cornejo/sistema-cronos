<?= $this->extend('layout') ?>

<?= $this->section('header') ?>
<title>Clientes - Sistema Cronos</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-3 p-2">
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <div class="col-6">
                    <h3>Clientes</h3>
                </div>
                <div class="col-6 d-flex flex-row flex-wrap align-content-center justify-content-end">
                    <button id="btnNuevoEditar" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa fa-plus"></i> Nuevo cliente</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tblEquipos" class="table table-striped table-hover dt-responsive display wrap w-100">
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>Ap. Paterno</th>
                            <th>Ap. Materno</th>
                            <th>Doc. Ident.</th>
                            <th>Num. Doc.</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $key => $cliente) : ?>
                            <tr>
                                <td><?= $cliente["nombre"] ?></td>
                                <td><?= $cliente["apellido_paterno"] ?></td>
                                <td><?= $cliente["apellido_materno"] ?></td>
                                <td class="text-uppercase"><?= $cliente["tipo_doi"] ?></td>
                                <td><?= $cliente["numero_doi"] ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" onclick="editar(<?= $cliente['id']; ?>);" class="btn btn-warning"><i class="fa fa-pen"></i></button>
                                        <button type="button" onclick="eliminar(<?= $cliente['id']; ?>);" class="btn btn-danger"><i class="fa fa-trash"></i></button>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fa fa-person text-muted"></i> Nuevo cliente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mt-1">
                        <div class="col-md-12">
                            <label for="txtNombres">Nombres completos</label>
                            <input type="text" id="txtNombres" class="form-control" onkeyup="checkColor(this);" placeholder="Ej. Luis Felipe">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="txtApPat">Apellido Paterno</label>
                            <input class="form-control" id="txtApPat" onkeyup="checkColor(this);" type="text" placeholder="Ej. Juárez">
                        </div>
                        <div class="col-md-6">
                            <label for="txtApMat">Apellido Materno</label>
                            <input class="form-control" id="txtApMat" onkeyup="checkColor(this);" type="text" placeholder="Ej. Cáceres">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="cmbTipoDoi">Tipo de Documento</label>
                            <select class="form-select" onchange="checkColor(this);" name="" id="cmbTipoDoi">
                                <option value="">::: Tipo de Documento :::</option>
                                <option value="dni">DNI</option>
                                <option value="ruc">RUC</option>
                                <option value="pasaporte">Pasaporte</option>
                                <option value="ce">CE</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="txtNumDoi">Num. Documento</label>
                            <input class="form-control" id="txtNumDoi" onkeyup="checkColor(this);" type="number" placeholder="Ej. 77665544">
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

    <!-- -->
    <div class="modal fade" id="modalVer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fa fa-person text-muted"></i> Datos de Cliente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mt-1">
                        <div class="col-md-12">
                            <label for="txtNombres">Nombres completos</label>
                            <input type="text" id="txtNombres" class="form-control" onkeyup="checkColor(this);" placeholder="Ej. Luis Felipe">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="txtApPat">Apellido Paterno</label>
                            <input class="form-control" id="txtApPat" onkeyup="checkColor(this);" type="text" placeholder="Ej. Juárez">
                        </div>
                        <div class="col-md-6">
                            <label for="txtApMat">Apellido Materno</label>
                            <input class="form-control" id="txtApMat" onkeyup="checkColor(this);" type="text" placeholder="Ej. Cáceres">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="cmbTipoDoi">Tipo de Documento</label>
                            <select class="form-select" onchange="checkColor(this);" name="" id="cmbTipoDoi">
                                <option value="">::: Tipo de Documento :::</option>
                                <option value="dni">DNI</option>
                                <option value="ruc">RUC</option>
                                <option value="pasaporte">Pasaporte</option>
                                <option value="ce">CE</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="txtNumDoi">Num. Documento</label>
                            <input class="form-control" id="txtNumDoi" onkeyup="checkColor(this);" type="number" placeholder="Ej. 77665544">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    let table;
    let clientes;
    let cliente;
    $(document).ready(() => {
        table = new DataTable("#tblEquipos", {
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json',
            },
        });
        cargarClientes();
        $("#btnGuardar").click(guardar);
        $("#cmbTipoDoi").change(() => {
            let tipo_doi = document.getElementById("cmbTipoDoi").value;
            $("#txtNumDoi").attr("type", (tipo_doi == "ruc" || tipo_doi == "dni") ? "number" : "text");
            $("#txtNumDoi").attr("placeholder", (tipo_doi == "ruc" || tipo_doi == "dni") ? "Ej. 77665544" : "Ej. AB123456X");
        });
        $("#btnNuevoEditar").click(reset)
    });


    function checkColor(input) {
        if (input.value.length == 0) {
            $(input).addClass("border-danger");
        } else {
            $(input).removeClass("border-danger");
        }
    }

    function reset() {
        cliente = null;
        $("#txtNombres").val("");
        $("#txtApPat").val("");
        $("#txtApMat").val("");
        document.getElementById("cmbTipoDoi").selectedIndex = 0;
        $("#txtNumDoi").val("");
        $("#staticBackdropLabel").html(`<i class="fa fa-pen"></i> Nuevo cliente`);
    }

    function guardar() {
        let nombres = $("#txtNombres").val();
        let apellido_paterno = $("#txtApPat").val();
        let apellido_materno = $("#txtApMat").val();
        let tipo_doi = document.getElementById("cmbTipoDoi").value;
        let num_doi = $("#txtNumDoi").val();

        if (!nombres || !apellido_materno || !apellido_paterno || !num_doi) {
            Swal.fire({
                icon: "warning",
                title: "Faltan datos",
                html: "Debe ingresar todos los datos del formulario."
            });
            return;
        }
        if (!tipo_doi) {
            Swal.fire({
                icon: "warning",
                title: "Faltan datos",
                html: "Seleccione el tipo de documento."
            });
            return;
        }
        let datos = {
            nombre: nombres,
            apellido_paterno: apellido_paterno,
            apellido_materno: apellido_materno,
            tipo_doi: tipo_doi,
            numero_doi: num_doi
        };

        if (cliente != null) {
            datos.id = cliente.id;
        }

        $.ajax({
            method: "POST",
            url: `<?= base_url("/api/cliente") ?>/${cliente==null?"nuevo":"editar"}`,
            data: datos,
            success: (data) => {
                if (data.id) {
                    cargarClientes();
                    Swal.fire({
                        icon: "success",
                        title: "Éxito",
                        html: "Se guardó el cliente con éxito."
                    });
                    $("#staticBackdrop").modal("hide");
                }
            }

        });

    }

    function eliminar(id) {
        cliente = clientes.find(cliente => cliente.id == id);

        Swal.fire({
            title: `¿Seguro que deseas eliminar a ${cliente.nombre} ${cliente.apellido_paterno} ${cliente.apellido_materno}?`,
            html: "Se eliminará toda la información relacionada al cliente (equipos y diagnósticos).<br> Esto no se puede deshacer.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Eliminar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "post",
                    url: "<?= base_url("/api/cliente/eliminar") ?>",
                    data: {
                        id: id
                    },
                    success: (data) => {
                        cargarClientes();
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

    function cargarClientes() {
        $.ajax({
            method: "get",
            url: "<?= base_url("/api/cliente") ?>/listar",
            success: (data) => {
                clientes = data.lista;
                table.clear().draw();
                $.each(data.lista, function(index, cliente) {
                    table.row.add([
                        cliente.nombre,
                        cliente.apellido_paterno,
                        cliente.apellido_materno,
                        `<span class="text-uppercase">${cliente.tipo_doi}</span>`,
                        cliente.numero_doi,
                        `
                        <td>
                            <div class="btn-group">
                                <button type="button" onclick="editar(${cliente.id});" class="btn btn-warning"><i class="fa fa-pen"></i></button>
                                <button type="button" onclick="eliminar(${cliente.id});" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
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

    function editar(id) {
        let valuesCombo = ['::: Tipo de Documento :::', "dni", "ruc", "pasaporte", "ce"];
        cliente = clientes.find(cliente => cliente.id == id);
        $("#txtNombres").val(cliente.nombre);
        $("#txtApPat").val(cliente.apellido_paterno);
        $("#txtApMat").val(cliente.apellido_materno);
        $("#cmbTipoDoi").prop('selectedIndex', valuesCombo.findIndex(val => val == cliente.tipo_doi));
        $("#txtNumDoi").val(cliente.numero_doi);
        $("#staticBackdropLabel").html(`<i class="fa fa-pen"></i> Editar ${cliente.nombre} ${cliente.apellido_paterno} ${cliente.apellido_materno}`);
        $("#staticBackdrop").modal("show");
    }
</script>
<?= $this->endSection() ?>