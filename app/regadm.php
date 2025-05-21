<?php
include_once 'conn.php';

if (isset($_POST['btn-reg']) && !empty($_POST)) {
    $insert = $conn->prepare('INSERT INTO user(fname, lname, email, pass, rol) VALUES(?,?,?,?,?)');
    $insert->bindParam(1, $_POST['fname']);
    $insert->bindParam(2, $_POST['lname']);
    $insert->bindParam(3, $_POST['email']);
    $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
    $insert->bindParam(4, $pass);
    $rol = "admin";
    $insert->bindParam(5, $rol);

    /* Validation Data */
    $search = $conn->prepare('SELECT * FROM user WHERE email=:email');
    $search->execute(array(":email" => $_POST['email']));
    $search->fetch(PDO::FETCH_ASSOC);

    if ($search->rowCount() > 0) {
        $msg = array("Disculpa, el email ya existe", "danger");
        }

    /* Validation Data */
     elseif ($insert->execute()) {
        $msg = array("Usuario creado", "success");
        } else {
        $msg = array("Usuario no creado", "danger");
        }
    }

/* recuperación de contraseña de usuarios */
?>

<!DOCTYPE html>
<html lang="es-CO" data-bs-theme="" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pio XI</title>

    <!--Favicon-->
    <link rel="shortcut icon" href="../assets/img/logosena.png" type="image/x-icon">

    <!--SEO Tags-->
    <meta name="author" content="Pio XI">
    <meta name="description" content="Aplicativo web Bootstrap">
    <meta name="keywords" content="SENA, sena, Sena">

    <!--Optimization Tags-->
    <meta name="theme-color" content="#000000">
    <meta name="MobileOptimized" content="width">
    <meta name="HandlhledFriendly" content="true">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-traslucent">

    <!--Styles and complements Bootstrap 5.3-->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/me.styles.css">
    <!--styles Icons Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-login">
    <main class="form-signin m-auto pt-5 mt-4">
        <div class="card" style="background-color:rgba(255, 255, 255, 0.1);">
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
                    <h1 class="display-6">Registro de Administrador</h1>
                </div>
                <form action="" method="post" enctype="application/x-www-form-urlencoded">

                    <!--<div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person-lines-fill"></i>
                        </span>
                        <input type="text" class="form-control" id="fname" placeholder="Ingrese sus nombres"
                            name="fname" required>
                    </div>-->

                    <div class="mb-3 mt-3">
                        <label for="fname" class="form-label">Nombres:</label>
                        <input type="text" class="form-control" id="fname" placeholder="Ingrese sus nombres"
                            name="fname" required>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="lname" class="form-label">Apellidos:</label>
                        <input type="text" class="form-control" id="lname" placeholder="Ingrese sus apellidos"
                            name="lname" required>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Correo:</label>
                        <input type="email" class="form-control" id="email" placeholder="Ingrese su email" name="email"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label">Contraseña:</label>

                        <div class="input-group">
                            <input class="form-control" type="password" name="pass" id="password"
                                placeholder="Ingrese su contraseña" required>
                            <span class="input-group-text" onclick="pass_show_hide();">
                                <i class="bi bi-eye-fill d-none" id="showeye" style="font-size: 20px;"></i>
                                <i class="bi bi-eye-slash-fill" id="hideeye" style="font-size: 20px;"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-check mb-3 clearfix">
                        <label class="form-check-label float-end">
                            <a href="./">Iniciar Sesión</a>
                        </label>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary" type="submit" name="btn-reg">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!--Complements JS-->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <!--Script visualización password-->
    <script src="../assets/js/password.viewer.js"></script>
</body>

</html>