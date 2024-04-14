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
                        <i class="fa fa-user text-black-50" style="font-size: 15pt; margin-top: -4px; margin-right: 4px;"></i>
                        <h3>Usuarios</h3>
                    </div>
                </div>
                <div class="col-6 d-flex flex-row flex-wrap align-content-center justify-content-end">
                    <button id="btnNuevoEditar" onclick=" reset();" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa fa-plus"></i> Nuevo usuario</button>
                </div>
            </div>
        </div>


        <div class="card-body">
            <table id="tblUsuarios" class="table table-striped table-hover dt-responsive display wrap w-100">
                <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Ap. Paterno</th>
                        <th>Ap. Materno</th>
                        <th>DNI</th>
                        <th>Tipo</th>
                        <th>Usuario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $key => $usuario) : ?>
                        <tr>
                            <td><?= $usuario["nombre"] ?> </td>
                            <td><?= $usuario["apellido_paterno"] ?> </td>
                            <td><?= $usuario["apellido_materno"] ?> </td>
                            <td><?= $usuario["dni"] ?> </td>
                            <td><?= $usuario["tipo"] ?> </td>
                            <td><?= $usuario["usuario"] ?> </td>


                            <td>
                                <div class="btn-group">
                                    <button type="button" onclick="editar(<?= $usuario['id'] ?>);" class="btn btn-warning"><i class="fa fa-pen"></i></button>
                                    <button type="button" onclick="eliminar(<?= $usuario['id'] ?>);" class="btn btn-danger"><i class="fa fa-trash"></i></button>
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
                <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fa fa-person text-muted"></i> Nuevo Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="txtNombre">Nombres</label>
                        <input class="form-control" id="txtNombre" type="text" placeholder="Ej. Juan ">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="txtAp">Apellido Paterno</label>
                        <input class="form-control" id="txtAp" type="text" placeholder="Ej. Perez">
                    </div>
                    <div class="col-md-6">
                        <label for="txtAm">Apellido Materno</label>
                        <input class="form-control" id="txtAm" type="text" placeholder="Ej. García">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="txtDNI">DNI</label>
                        <input class="form-control" id="txtDNI" type="number" placeholder="Ej. 12345678">
                    </div>
                    <div class="col-md-6">
                        <label for="">Tipo de Usuario</label>
                        <select class="form-select" name="" id="cmbTipoUsuario">
                            <option value="">::: Seleccione tipo :::</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Tecnico">Tecnico</option>
                        </select>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="txtUsuario">Usuario</label>
                        <input class="form-control" id="txtUsuario" type="text" autocomplete="new-password" placeholder="Ej. juan.perez">
                    </div>
                    <div class="col-md-6">
                        <label for="txtClave">Clave</label>
                        <input class="form-control" id="txtClave" type="password" autocomplete="new-password" placeholder="Ej. Contraseña123">
                    </div>
                </div>
            </div>
            <div class=" modal-footer">
                <button type="button" class="btn btn-success" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

            </div>
        </div>
    </div>
</div>
<!-- Fin modal-->
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    let table;
    let usuarios;
    let usuario;
    $(document).ready(() => {
        table = new DataTable("#tblUsuarios", {
            language: {
                //   url: '//cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json',
            },
            responsive: true
        });
        cargarUsuarios();
        $("#btnGuardar").click(guardar);
    });

    function cargarUsuarios() {
        $.ajax({
            method: "get",
            url: "<?= base_url("/api/usuario/listar") ?>",
            beforeSend: () => {
                table.clear().draw();
            },
            success: (data) => {
                console.log(data);
                usuarios = data.lista;
                $.each(data.lista, (i, user) => {
                    table.row.add([
                        user.nombre,
                        user.apellido_paterno,
                        user.apellido_materno,
                        user.dni,
                        user.tipo,
                        user.usuario,
                        `
                        <div class="btn-group">
                            <button type="button" onclick="editar(${user.id});" class="btn btn-warning"><i class="fa fa-pen"></i></button>
                            <button type="button" onclick="eliminar(${user.id});" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </div> 
                        `
                    ]).draw();
                })
            },
            complete: () => table.responsive.recalc()
        });
    }

    function reset() {
        $("#txtNombre").val('');
        $("#txtAp").val('');
        $("#txtAm").val('');
        $("#txtDNI").val('');
        $("#cmbTipoUsuario").prop('selectedIndex', 0);
        $("#txtUsuario").val('');

        $("#txtUsuario").removeAttr("disabled");
        $("#txtClave").removeAttr("disabled");
        $("#txtClave").attr("placeholder", "Ej. MiClave123");

        usuario = null;
    }

    function editar(id) {
        usuario = usuarios.find(u => u.id == id);


        $("#txtNombre").val(usuario.nombre);
        $("#txtAp").val(usuario.apellido_paterno);
        $("#txtAm").val(usuario.apellido_materno);
        $("#txtDNI").val(usuario.dni);
        $("#cmbTipoUsuario").val(usuario.tipo);
        $("#txtUsuario").val(usuario.usuario);
        $("#txtClave").attr("placeholder", "(ve a Mi perfil)");
        $("#txtUsuario").attr("disabled", "disabled");
        $("#txtClave").attr("disabled", "disabled");

        $("#cmbTipoUsuario").prop('selectedIndex', ["", "Administrador", "Tecnico"].findIndex(val => val == usuario.tipo));
        $("#staticBackdrop").modal("show");
    }

    function guardar() {
        let nombre = $("#txtNombre").val();
        let apellido_paterno = $("#txtAp").val();
        let apellido_materno = $("#txtAm").val();
        let dni = $("#txtDNI").val();
        let tipo_usuario = $("#cmbTipoUsuario").val();
        let username = $("#txtUsuario").val();
        let clave = $("#txtClave").val();


        if (!nombre || !apellido_materno || !apellido_paterno || !dni || !tipo_usuario) {
            Swal.fire({
                icon: "warning",
                title: "Faltan datos",
                text: "Debe ingresar todos los datos"
            });
        } else {

            let data = {
                nombre: nombre,
                apellido_paterno: apellido_paterno,
                apellido_materno: apellido_materno,
                dni: dni,
                tipo: tipo_usuario
            };
            if (!usuario) {
                data.usuario = username;
                data.clave = clave;
            } else {
                data.id = usuario.id;
            }

            $.ajax({
                method: "POST",
                url: `<?= base_url("/api/usuario") ?>/${usuario?"editar":"nuevo"}`,
                data: data,
                beforeSend: () => {

                },
                success: (data) => {
                    if (data.id) {
                        Swal.fire({
                            icon: "success",
                            title: "Guardado con éxito",
                            text: `Se ${usuario?"editó":"guardó"} el usuario con éxito `
                        });
                        cargarUsuarios();
                        $("#staticBackdrop").modal("hide");
                    }
                }

            });
        }
    }

    function eliminar(id) {
        usuario = usuarios.find(u => u.id == id);

        Swal.fire({
            title: `¿Seguro que deseas eliminar este usuario?`,
            html: `
                <strong>Nombre: </strong>${usuario.nombre}<br>
                <strong>Ap. Paterno: </strong>${usuario.apellido_paterno}<br>
                <strong>Ap. Materno: </strong>${usuario.apellido_materno}<br>
                <strong>DNI: </strong>${usuario.dni}<br>
                <strong>Tipo: </strong>${usuario.tipo}<br>
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
                    url: "<?= base_url("/api/usuario/eliminar") ?>",
                    data: {
                        id: id
                    },
                    success: (data) => {
                        cargarUsuarios();
                        Swal.fire({
                            icon: "success",
                            title: "Éxito",
                            html: data.mensajes
                        });
                        $("#staticBackdrop").modal("hide");
                    }
                });
            }
        });
    }
</script>
<?= $this->endSection() ?>