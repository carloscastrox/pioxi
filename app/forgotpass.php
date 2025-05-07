<?php
session_start();
include 'conn.php';

if (isset($_POST['btnrescue'])) {

    $email = $_POST['email'];
    $fpass = $conn->prepare('SELECT * FROM user WHERE email = ? LIMIT 1');
    $fpass->bindParam(1, $email);
    $fpass->execute();
    $row = $fpass->fetch(PDO::FETCH_ASSOC);

    if ($fpass->rowCount() == 1) {
        $id = base64_encode($row['iduser']);
        $token = md5(uniqid(rand()));

        $uptoken = $conn->prepare('UPDATE user SET token = ? WHERE email = ?');
        $uptoken->bindParam(1, $token);
        $uptoken->bindParam(2, $email);
        $uptoken->execute();

        $subject = '=?UTF-8?B?' . base64_encode("Restablecer Contraseña") . "=?=";
        $message = "<p>Hola " . $row['fname'] . ", ya puedes restablecer la contraseña</p><br>";
        $message .= "<p>Por favor, haz click en el siguiente enlace para restablecer tu contraseña:</p>";
        $message .= "<a href='http://localhost/11_25/pioxi/app/resetpass?id=$id&token=$token'>Restablecer</a>";

        include 'config.mailer.php';
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
                <div class="text-center">
                    <img src="../assets/img/logo.png" alt="Logo" width="72" height="72">
                    <h1 class="display-6">Recuperar Contraseña</h1>
                </div>
                <!--Alerts-->
                <?php if (isset($msg)) { ?>
                    <div class="alert alert-<?php echo $msg[1]; ?> fade show" role="alert">
                        <strong>Alerta!</strong> <?php echo $msg[0]; ?>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-warning" role="alert">
                        Se enviara un link a su correo para restablecer su contraseña.
                    </div>
                <?php } ?>
                <!--Alerts-->
                <form action="" method="post" enctype="application/x-www-form-urlencoded">
                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Correo:</label>
                        <input type="email" class="form-control" id="email" placeholder="Ingrese email" name="email"
                            required>
                    </div>
                    <div class="d-grid gap-2 mb-4">
                        <button type="submit" class="btn btn-primary btn-block" name="btnrescue">Restablecer</button>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <a href="reguser">Registráte</a>
                        </div>
                        <div class="col-sm-6">
                            <a href="./">Iniciar Sesión</a>
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
</body>

</html>