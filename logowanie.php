<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>FiBoWoRlD</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
        <link href="css/custom.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <header class="text-dark masthead">
            <div class="oferta-modal" id="logowanie">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="modal-body">
                                        <?php
                                        include_once 'PHPClass/Baza.php';
                                        include_once 'PHPClass/UserManager.php';
                                        include_once 'PHPClass/interfejsRoot.php';
                                        include_once 'PHPClass/interfejsUser.php';
                                        $db = new Baza("localhost", "root", "", "projektphp");
                                        $um = new UserManager();
                                        if (filter_input(INPUT_GET, "akcja") == "wyloguj") {
                                            $um->logout($db);
                                            if (isset($_COOKIE[session_name()])) {
                                                setcookie(session_name(), '', time() - 42000, '/');
                                            }
                                            $_SESSION = [];
                                            if (session_status() === PHP_SESSION_ACTIVE)
                                                session_destroy();
                                            header("location:index.php");
                                        }
                                        //kliknięto przycisk submit z name = zaloguj
                                        if ((filter_input(INPUT_POST, "Zaloguj")) || (filter_input(INPUT_POST, "changePass"))) {
                                            if (session_status() == PHP_SESSION_NONE) {
                                                session_start();
                                            }
                                            if (filter_input(INPUT_POST, "changePass")) {
                                                //do poprawki
                                                $userId = unserialize($_SESSION['id']);
                                                $um->zmienHaslo($db, $userId);
                                            } else {
                                                $userId = $um->login($db);
                                            }
                                            //sprawdź parametry logowania
                                            $_SESSION['form'] = serialize($um);
                                            if ($userId > 0) {
                                                if (filter_input(INPUT_POST, "changePass")) {
                                                    $um->zmienHaslo($db, $userId);
                                                }
                                                $firstLog = $um->getUserFirstLogin($db, $userId);
                                                if ($firstLog != 0) {
                                                    header("location:zalogowany.php");
                                                } else {
                                                    //tutaj przypadek zmiany hasla wygeneruj nowy formularz z UserManager
                                                    echo "<h2 class='text-uppercase'>Pierwsze logowanie:</h2><br/>";
                                                    echo "<h3 class='text-uppercase'>Wymagana zmiana hasła:</h3><br/>";
                                                    $um->buildPasswordChange("logowanie.php");
                                                    if (session_status() == PHP_SESSION_NONE) {
                                                        session_start();
                                                    }
                                                    $_SESSION['id'] = serialize($userId);
                                                }
                                            } else {
                                                echo '<h4 style="color: orange">Błędna nazwa użytkownika lub hasło!</h4>';
                                                $um->loginForm(); //Pokaż formularz logowania
                                            }
                                        } else {
                                            //pierwsze uruchomienie skryptu logowania
                                            $um->loginForm();
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </body>
</html>
