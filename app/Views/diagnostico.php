<?= $this->extend('layout') ?>

<?= $this->section('header') ?>
<title>Equipos - Sistema Cronos</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-3 p-2">
    <div class="card">

        <div class="card-header">
            <h3><?= $equipo["marca"] ?> <?= $equipo["modelo"] ?> | Serie <?= $equipo["serie"] ?></h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Cliente</h4>
                    <div class="col-12">
                        <label for="">Nombres</label>
                        <input class="form-control" type="text" value="<?= $equipo["cliente"]["nombre"] ?> <?= $equipo["cliente"]["apellido_paterno"] ?> <?= $equipo["cliente"]["apellido_materno"] ?>" readonly>
                    </div>
                    <div class="col-12">
                        <label for=""><?= strtoupper($equipo["cliente"]["tipo_doi"]) ?></label>
                        <input class="form-control" type="text" value="<?= $equipo["cliente"]["numero_doi"] ?> " readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4>Equipo</h4>
                    <div class="col-12">
                        <label for="">Marca</label>
                        <input class="form-control" type="text" value="<?= $equipo["marca"] ?>" readonly>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Modelo</label>
                            <input class="form-control" type="text" value="<?= $equipo["modelo"] ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="">Serie</label>
                            <input class="form-control" type="text" value="<?= $equipo["serie"] ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="d-flex justify-content-between align-items-md-baseline">
                    <h4>Diagnósticos</h4>
                    <button class="btn btn-success" id="btnNuevoDiagnostico" data-bs-toggle="modal" data-bs-target="#modalDiagnostico"><i class="fa fa-plus"></i> Registrar diagnóstico</button>
                </div>

                <div class="col-12">
                    <table id="tblDiagnosticos" class="table table-striped table-hover dt-responsive display wrap">
                        <thead>
                            <tr>
                                <th>Diagnóstico</th>
                                <th>Fecha/Hora</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($equipo["diagnosticos"] as $key => $diagnostico) : ?>
                                <tr>
                                    <td><?= $diagnostico["diagnostico"] ?> </td>
                                    <td><?= $diagnostico["fecha_hora"] ?> </td>
                                    <td><?= $diagnostico["precio"] ?> </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" onclick="editar(<?= $diagnostico['id'] ?>);" class="btn btn-warning"><i class="fa fa-pen"></i></button>
                                            <button type="button" onclick="eliminar(<?= $diagnostico['id'] ?>);" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


</div>
<div class="modal fade" id="modalDiagnostico" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Registro de diagnóstico</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label for="txtFecha">Precio</label>
                        <input class="form-control" id="txtPrecio" type="number" placeholder="99.80">
                    </div>
                    <div class="col-12">
                        <label for="txtFecha">Diagnóstico</label>
                        <textarea class="form-control" name="" id="txtDiagnostico" cols="30" rows="3" placeholder="Se realizó..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="guardar();" class="btn btn-success" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
    let table;
    let diag = null;
    let diagnosticos;
    $("#tblDiagnosticos").ready(() => {
        table = new DataTable("#tblDiagnosticos", {
            searching: false,
            "order": [[1, 'desc']]
        });
        cargarDiagnosticos();
        $("#btnNuevoDiagnostico").click(reset);
    });


    function cargarDiagnosticos() {
        $.ajax({
            method: "get",
            url: "<?= base_url("api/diagnostico/listar") . "/" . $equipo["id"] ?>",
            beforeSend: () => {

            },
            success: (data) => {
                console.log(data);
                table.clear().draw();
                diagnosticos = data.lista;
                $.each(data.lista, (i, diag) => {
                    table.row.add([
                        diag.diagnostico,
                        diag.fecha_hora,
                        Number(diag.precio).toFixed(2),
                        `
                        <td>
                            <div class="btn-group">
                                <button type="button" onclick="editar(${diag.id});" class="btn btn-warning"><i class="fa fa-pen"></i></button>
                                <button type="button" onclick="eliminar(${diag.id});" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                        `

                    ]).draw();
                });
            },
            complete: (xhr, status) => {
                table.responsive.rebuild();
                table.responsive.recalc();
                table.columns.adjust().draw();
            }
        });
    }

    function eliminar(id) {
        Swal.fire({
            title: `¿Seguro que deseas eliminar este diagnóstico?`,
            html: `Esta acción no se puede deshacer.`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Eliminar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "post",
                    url: "<?= base_url("/api/diagnostico/eliminar") ?>",
                    data: {
                        id: id
                    },
                    success: (data) => {
                        cargarDiagnosticos();
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

    function guardar() {
        let precio = $("#txtPrecio").val();
        let diagnostico = $("#txtDiagnostico").val();

        if (!precio || !diagnostico) {
            Swal.fire({
                icon: "warning",
                title: "Debe ingresar todos los datos del diagnóstico."
            });
        } else {

            let data = {
                precio: precio,
                diagnostico: diagnostico,
                id_equipo: '<?= $equipo["id"] ?>'
            };
            if (diag != null) {
                data.id = diag.id;
            }

            $.ajax({
                method: "POST",
                url: `<?= base_url("/api/diagnostico"); ?>/${diag?"editar":"guardar"}`,
                data: data,
                beforeSend: () => {

                },
                success: (data) => {
                    if (data.id) {
                        $("#modalDiagnostico").modal("hide");
                        cargarDiagnosticos();
                        Swal.fire({
                            icon: "success",
                            title: "Se guardó el diagnóstico."
                        });
                    }
                }
            });
        }
    }

    function reset() {
        $("#txtPrecio").val("");
        $("#txtDiagnostico").val("");
        $("#staticBackdropLabel").text("Registro de diagnóstico");
        diag = null;
    }

    function editar(id) {
        diag = diagnosticos.find(d => d.id == id);
        $("#txtPrecio").val(diag.precio);
        $("#txtDiagnostico").val(diag.diagnostico);
        $("#modalDiagnostico").modal("show");
        $("#staticBackdropLabel").text("Edición de diagnóstico");
    }
</script>

<?= $this->endSection() ?>