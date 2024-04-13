<?= $this->extend('layout') ?>

<?= $this->section('header') ?>
<title>Equipos - Sistema Cronos</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-3 p-2">
    <div class="card">
        <div class="card-header">
            <?php
            if (is_null($equipo)) :
            ?>
                <h3>Equipo no encontrado.</h3>
            <?php else :  ?>

                <h3>Código encontrado: <?= $equipo["codigo_barras"] ?></h3>
            <?php endif; ?>
        </div>

        <div class="card-body">
            <?php
            if (is_null($equipo)) :
            ?>
                <h3>No se encontró el equipo.</h3>
            <?php else :  ?>
                <div class="row mb-2">
                    <div class="col-md-6 mt-2 mb-2">
                        <h4>Datos de Cliente</h4>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Nombres</label>
                                <input class="form-control" type="text" readonly value="<?= $equipo["cliente"]["nombre"] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Apellido Paterno</label>
                                <input class="form-control" type="text" readonly value="<?= $equipo["cliente"]["apellido_paterno"] ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="">Apellido Materno</label>
                                <input class="form-control" type="text" readonly value="<?= $equipo["cliente"]["apellido_materno"] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Tipo Doc.</label>
                                <input class="form-control" type="text" readonly value="<?= strtoupper($equipo["cliente"]["tipo_doi"]) ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="">Núm. Doc</label>
                                <input class="form-control" type="text" readonly value="<?= $equipo["cliente"]["numero_doi"] ?>">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 mt-2 mb-2">
                        <h4>Datos de equipo</h4>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="">Marca</label>
                                <input class="form-control" type="text" readonly value="<?= $equipo["marca"] ?>">
                            </div>
                            <div class="col-sm-12">
                                <label for="">Modelo</label>
                                <input class="form-control" type="text" readonly value="<?= $equipo["modelo"] ?>">
                            </div>
                            <div class="col-sm-12">
                                <label for="">Serie</label>
                                <input class="form-control" type="text" readonly value="<?= $equipo["serie"] ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <h4>Diagnósticos</h4>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="tblDiagnosticos" class="table table-striped table-hover dt-responsive display wrap">
                            <thead>
                                <tr>
                                    <th>Diagnóstico</th>
                                    <th>Fecha/Hora</th>
                                    <th>Precio</th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>



            <?php endif; ?>
        </div>
    </div>


</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $("#tblDiagnosticos").ready(() => {
        table = new DataTable("#tblDiagnosticos", {
            searching: false,
            "order": [
                [1, 'desc']
            ]
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
                        Number(diag.precio).toFixed(2)


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
</script>
<?= $this->endSection() ?>