<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://getbootstrap.com/docs/5.3/examples/sign-in/sign-in.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">

    <title>Login - Sistema Cronos</title>
    <style>
        .body-bg {
            background-color: #23487b !important;
        }
    </style>

</head>

<body class="py-5 bg-body-tertiary body-bg">

    <div class="container">
        <div class="row">
            <div class="col-12">
                <main class="form-signin w-100 m-auto bg-white rounded-3">
                    <form method="post" action="/login">
                        <?php
                        if (isset($_GET["mensaje"])) {
                            $tipo = $_GET["tipo"] ?? "info";
                        ?>
                            <div class="alert alert-<?= $tipo ?> alert-dismissible fade show" role="alert">
                                <strong>Mensaje:</strong> <?= $_GET["mensaje"] ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="text-center">
                            <img class="mb-4 w-100" src="<?= base_url("images/logo.png"); ?>" alt="">
                            <h6 class="h6 mb-3 fw-normal ">Inicia sesión para continuar</h6>
                        </div>

                        <div class="form-floating">
                            <input type="text" class="form-control" id="txtUsuario" name="usuario" placeholder="Usuario" autocomplete="off">
                            <label for="txtUsuario">Usuario</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="txtClave" name="clave" placeholder="Contraseña" autocomplete="off">
                            <label for="txtClave">Contraseña</label>
                        </div>

                        <button id="btnLogin" class="btn btn-primary w-100 py-2" type="button" onclick="login()">
                            <img id="imgLogin" class="mb-1 d-none" src="http://www.leeparts.com/images/ajax-loader.gif" width="16" height="16" alt=""> Iniciar sesión
                        </button>
                        <div class="form-floating text-center mt-3">
                            <a class="text-muted" href="#">¿Olvidaste tu contraseña?</a>
                        </div>

                    </form>
                </main>
            </div>

        </div>
    </div>


    <footer class="footer mt-auto bg-light position-fixed bottom-0 w-100 text-center pt-3">
        <p class="text-decoration-none">Hecho con 💖 por <a class="text-muted" href="https://innite.net">Innite Solutions Perú</a></p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function login() {

            let usuario = $("#txtUsuario").val();
            let clave = $("#txtClave").val();

            $.ajax({
                method: "post",
                url: `<?= base_url("/api/usuario/login") ?>`,
                data: {
                    usuario: usuario,
                    clave: clave
                },
                beforeSend: () => {
                    $("#btnLogin").attr("disabled", "disabled");
                    $("#imgLogin").removeClass("d-none");
                },
                success: (data) => {
                    console.log(data);
                    location.href = "panel";
                },
                complete: (xhr) => {
                    $("#btnLogin").removeAttr("disabled");
                    $("#imgLogin").addClass("d-none");
                }

            });
        }
    </script>


</body>

</html>