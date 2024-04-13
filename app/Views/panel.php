<?= $this->extend('layout') ?>

<?= $this->section('header') ?>
<title>Equipos - Sistema Cronos</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-3 p-2">
    <div class="card">

        <?php

        use Config\Services;

        $service = Services::session();
        $usuario = $service->get("usuario");
        ?>


        <div class="card-body">
            <h3> Hola, <?= $usuario["nombre"] ?>!</h3>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-6 mt-2 mb-2">
                            <div class="card bg-transparent border-0">
                                <div class="card-body py-0">
                                    <div class="row text-white">
                                        <div class="col-lg-3 bg-success bg-opacity-75 py-3 text-center d-inline-flex flex-column justify-content-around">
                                            <i class="fa-solid fa-laptop fa-2x"></i>
                                        </div>
                                        <div class="col-lg-9 bg-success py-3">Equipos<br><span class="font-size-xx-large"><?= $num_equipos ?></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 mt-2 mb-2">
                            <div class="card bg-transparent border-0">
                                <div class="card-body py-0">
                                    <div class="row text-white">
                                        <div class="col-lg-3 bg-secondary bg-opacity-75 py-3 text-center d-inline-flex flex-column justify-content-around">
                                            <i class="fa fa-user fa-2x"></i>

                                        </div>
                                        <div class="col-lg-9 bg-secondary py-3">Clientes<br><span class="font-size-xx-large"><?= $num_clientes ?></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-6 mt-2 mb-2">
                            <div class="card bg-transparent border-0">
                                <div class="card-body py-0">
                                    <div class="row text-white">
                                        <div class="col-lg-3 bg-warning bg-opacity-75 py-3 text-center d-inline-flex flex-column justify-content-around">

                                            <i class="fa-solid fa-screwdriver-wrench fa-2x"></i>
                                        </div>
                                        <div class="col-lg-9 bg-warning py-3">Diagnósticos<br><span class="font-size-xx-large"><?= $num_diagnosticos ?></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 mt-2 mb-2 ">
                            <div class="card bg-transparent border-0">
                                <div class="card-body py-0">
                                    <div class="row text-white">
                                        <div class="col-lg-3 bg-primary bg-opacity-75 py-3 text-center d-inline-flex flex-column justify-content-around">
                                            <i class="fa fa-user-doctor fa-2x"></i>
                                        </div>
                                        <div class="col-lg-9 bg-primary py-3">Técnicos<br><span class="font-size-xx-large"><?= $num_usuarios ?></span></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->endSection() ?>