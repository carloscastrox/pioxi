<?php
include "conn.php";
session_start();

// verifica la sesión que se está iniciando
if (isset($_SESSION['user']) && isset($_SESSION['id']) && isset($_SESSION['rol']) ) {
    $search = $conn->prepare("SELECT * FROM user WHERE email = ? AND iduser = ? AND rol = ?");
    $search->bindParam(1, $_SESSION['user']);
    $search->bindParam(2, $_SESSION['id']);
    $search->bindParam(3, $_SESSION['rol']);
    $search->execute();
    $data = $search->fetch(PDO::FETCH_ASSOC);

    if (is_array($data)) {

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
            <header>
                <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">
                            <img src="../assets/img/logo.png" alt="Avatar Logo" style="width: 40px" class="" />
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapsibleNavbar" aria-label="Boton de menú">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="collapsibleNavbar">
                            <ul class="navbar-nav me-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="home">Inicio</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="?page=pubs">Publicaciones</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#team">Integrantes</a>
                                </li>
                            </ul>
                            <div class="d-flex">
                                <a href="?page=perfil" class="btn btn-danger">Mi Perfil</a>
                                <a href="./logout" class="btn btn-primary">Salir</a>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
            <main>
                <?php
                //Controlador de modulos o subpáginas
                $page = isset($_GET['page']) ? strtolower($_GET['page']) : 'home';
                require_once './' . $page . '.php';

                if ($page == 'home') {
                    require_once 'init.php';
                    }
                ?>
            </main>
            <?php
        }
    } else {
    // Si no hay sesión iniciada, redirigir a la página de inicio de sesión
    header("location: ./");
    }
?>
    <!--Complements JS-->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>