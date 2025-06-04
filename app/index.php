<?php
/* 
SESIONES
 * Validación de sesión de usuarios ok
 * Seguridad de la aplicación en el home ok
 * 
 MENU MODULAR
 * Menú modular para el home ok
 * Validar si el usuario ya ha iniciado sesión ok
 * Si la sesión existe, redirigir a la página de inicio ok

 ROLES
* Validar a los usuarios por roles ok
* Direccionar a los usuarios a la página de home según su rol (homea, homec, homev, etc) ok
* crear en la base de datos el campo rol y asignar el rol a cada usuario ok

PERFIL 
* Crear perfil de usuarios de acuerdo a su rol (Incluyendo imagen de perfil) OK
* Formatear campo date en php OK
* Actualizar los datos del perfil de usuario PENDIENTE

CRUD 
* Crear tabla Utilizando librerias datatables.net(inicializar, Responsive, language) OK
* Activar Botones de exportación a Excel y PDF
* Imprimir datos en una tabla dinamica OK
* Insertar datos a la tabla dinamica PENDIENTE
* Eliminar datos de la tabla dinamica OK
* Editar datos de la tabla dinamica PENDIENTE

Consultas INNER JOIN

 */
include "conn.php";
session_start();

if (isset($_POST['btnlogin'])) {
    $login = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $login->bindParam(1, $_POST['email']);
    $login->execute();
    $row = $login->fetch(PDO::FETCH_ASSOC);

    if (is_array($row)) {
        if (password_verify($_POST['pass'], $row['pass'])) {
            switch ($row['rol']) {
                case 'admin':
                    $_SESSION['user'] = $row['email'];
                    $_SESSION['id'] = $row['iduser'];
                    $_SESSION['rol'] = $row['rol'];
                    header("Location: home");
                    break;

                case 'user':
                    $_SESSION['user'] = $row['email'];
                    $_SESSION['id'] = $row['iduser'];
                    $_SESSION['rol'] = $row['rol'];
                    header("Location: homeu");
                    break;

                default:
                    header("Location: ./");
                    break;
            }
        } else {
            $msg = array("Contraseña incorrecta", "warning");
        }
    } else {
        $msg = array("El correo no existe", "danger");
    }
}
?>
<!DOCTYPE html>
<html lang="es-CO" data-bs-theme="dark" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pio XI</title>
    <!--Logo Favicon-->
    <link rel="shortcut icon" href="../assets/img/logo.png" type="image/x-icon">

    <!--SEO Tags-->
    <meta name="author" content="Pio XI">
    <meta name="description" content="Aplicativo web Bootstrap">
    <meta name="keywords" content="SENA, sena, Sena, Aplicativo, APLICATIVO, aplicativo">

    <!--Optimization Tags-->
    <meta name="theme-color" content="#000000">
    <meta name="MobileOptimized" content="width">
    <meta name="HandlhledFriendly" content="true">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-traslucent">

    <!--Bootstrap 5.3 Styles and complements-->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/me.styles.css">
    <!--styles Icons Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <main class="form-signin m-auto pt-5 mt-4">
        <div class="card">
            <div class="card-body">

                <!--Section alerts-->
                <?php if (isset($msg)) { ?>
                    <div class="alert alert-<?php echo $msg[1] ?> alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>Alerta!</strong> <?php echo $msg[0] ?>.
                    </div>
                <?php } ?>
                <!--Section alerts-->

                <div class="text-center">
                    <img src="../assets/img/logo.png" alt="Logo" width="72" height="72">
                    <h1 class="display-6">Inicio de Sesión</h1>
                </div>
                <form action="" method="post" enctype="application/x-www-form-urlencoded">
                    <div class="input-group mb-3 mt-3">
                        <label for="email" class="input-group-text">Correo:</label>
                        <input type="email" class="form-control" id="email" placeholder="Ingrese su correo" name="email"
                            required>
                    </div>

                    <div class="input-group mb-3 password-wrapper">
                        <label for="pwd" class="input-group-text">Contraseña:</label>
                        <input type="password" class="form-control" id="password" placeholder="Ingrese su contraseña"
                            name="pass" required>
                        <span class="input-group-text pt-2 toggle-button eye-icon" onclick="password_show_hide();">
                            <i class="bi bi-eye d-none" id="show_eye"></i>
                            <i class="bi bi-eye-slash" id="hide_eye"></i>
                        </span>
                    </div>
                    <div class="form-check mb-3">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="remember"> Recuerdame
                        </label>
                    </div>
                    <div class="d-grid gap-2 mb-4">
                        <button type="submit" class="btn btn-primary btn-block" name="btnlogin">Ingresar</button>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <a href="reguser">Registráte</a>
                        </div>
                        <div class="col-sm-8 text-end">
                            <a href="forgotpass">¿Olvidaste la contraseña?</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer bg-dark">
                <p class="text-center text-light pt-1" title="CACJX">Carlos Andres Castro - &copy;Copyright 2025</p>
            </div>
        </div>
    </main>
    <!--Complements JS-->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <!--Script visualización password-->
    <script src="../assets/js/password.viewer.js"></script>
</body>

</html>