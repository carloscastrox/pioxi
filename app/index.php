<?php
/* 
 * Validación de sesión de usuarios ok
 * Seguridad de la aplicación en el home
 * Menú modular para el home
 * Validar si el usuario ya ha iniciado sesión
 * Si la sesión existe, redirigir a la página de inicio
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
            $_SESSION['user'] = $row['email'];
            $_SESSION['id'] = $row['iduser'];
            header("Location: home");
            exit();
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
                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Correo:</label>
                        <input type="email" class="form-control" id="email" placeholder="Ingrese email" name="email"
                            required>
                    </div>
                    <div class="mb-3 password-wrapper">
                        <label for="pwd" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" id="password" placeholder="Ingrese contraseña"
                            name="pass" required>
                        <span class="input-group pt-2 toggle-button eye-icon" onclick="password_show_hide();">
                            <i class="bi bi-eye d-none" id="show_eye" style="font-size:20px"></i>
                            <i class="bi bi-eye-slash" id="hide_eye" style="font-size:20px"></i>
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
                        <div class="col-sm-6">
                            <a href="reguser">Registráte como usuario</a>
                        </div>
                        <div class="col-sm-6">
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