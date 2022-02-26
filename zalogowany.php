<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
        </style> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
        <link href="css/custom.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <?php
        include_once 'PHPClass/Baza.php';
        include_once 'PHPClass/UserManager.php';
        include_once 'PHPClass/interfejsRoot.php';
        include_once 'PHPClass/interfejsUser.php';
        include_once 'PHPClass/phpAdres.php';
        $db = new Baza("localhost", "root", "", "projektphp");
        session_start();
        $sesionID = session_id();
        if (isset($_SESSION['form'])) {
            $um = unserialize($_SESSION['form']);
            $checkId = $um->getLoggedInUser($db, $sesionID);
            if ($checkId != -1) {
                $status = $um->getUserStatus($db, $checkId);
                if ($status == 2) {
                    $interfejs = new interfejsRoot($db, $checkId);
                } elseif ($status == 1) {
                    $interfejs = new interfejsUser($db, $checkId);
                } else {
                    echo '<h4 style="color: orange">Błąd w pobraniu uprawnień!</h4>';
                    echo "<a class='nav-link btn btn-danger' data-bs-toggle='modal' href='logowanie.php?akcja=wyloguj'><i class='bi bi-box-arrow-left'></i>Wyloguj</a>";
                }
            } else {
                header("location:logowanie.php");
            }
        } else {
            header("location:logowanie.php");
        }
        ?>
        <!-- MODAL KOMUNIKATY -->
        <div class="oferta-modal modal fade" id="alert" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <!-- Project details-->
                                    <?php
                                    if (isset($_POST["addAdres"])) {
                                        $msc = $_POST['msc'];
                                        $ul = $_POST['ul'];
                                        $nr = $_POST['nr'];
                                        $postcode = $_POST['postcode'];
                                        $select = "SELECT * FROM `adresy` WHERE `miejscowosc` LIKE '$msc' AND `ulica` LIKE '$ul' AND `numer` LIKE '$nr' AND `kodpocztowy` LIKE '$postcode'";
                                        $adres = new phpAdres();
                                        $idadres = $adres->getId($db, $select);
                                        if ($idadres == -1) {
                                            $sql = "INSERT INTO `adresy` (`miejscowosc`,`ulica`,`numer`,`kodpocztowy`) VALUES ('$msc','$ul',$nr,'$postcode');";
                                            $result = $db->insert($sql);
                                            unset($_POST);
                                            $_POST['addedAdres'] = $result;
                                            $_POST['duplikat'] = false;
                                        } else {
                                            unset($_POST);
                                            $_POST['addedAdres'] = false;
                                            $_POST['duplikat'] = true;
                                        }
                                    }
                                    if (isset($_POST['addedAdres'])) {
                                        if ($_POST['addedAdres'] == true) {
                                            ?>
                                            <h2 class="text-uppercase">Pomyślnie dodano adres!</h2><br/>
                                            <?php
                                        } else {
                                            if ($_POST['duplikat'] == true) {
                                                ?>
                                                <h2 class="text-uppercase">W naszej bazie istnieje juz taki adres!</h2><br/>
                                                <?php
                                            } else {
                                                ?>
                                                <h2 class="text-uppercase">UPS coś poszło nie tak</h2><br/>
                                                <?php
                                            }
                                        }
                                        $interfejs->showModal();
                                    }
                                    if (isset($_POST['deleteAdres'])) {
                                        $id = $_POST['delete'];
                                        $sql = "DELETE FROM `adresy` WHERE `id` = $id";
                                        $result = $db->delete($sql);
                                        if ($result == true) {
                                            ?>
                                            <h2 class="text-uppercase">Pomyślnie usunięto adres!</h2><br/>
                                            <?php
                                        } else {
                                            ?>
                                            <h2 class="text-uppercase">UPS coś poszło nie tak</h2><br/>
                                            <?php
                                        }
                                        $interfejs->showModal();
                                    }
                                    if (isset($_POST['deleteKlient'])) {
                                        $idk = $_POST['deleteKlient'];
                                        $findidk = "SELECT `idk` FROM `daneklientow` WHERE `idk` = $idk";
                                        $r1 = $db->returnObject($findidk);
                                        if ($r1 != false) {
                                            $sql1 = "UPDATE `adresy` SET `zgloszenie` = '0', `daneklientow_idk` = NULL WHERE `daneklientow_idk` = $idk;";
                                            $sql2 = "DELETE FROM `daneformularza` WHERE `daneklientow_idk` = $idk;";
                                            $sql3 = "DELETE FROM `umowa` WHERE `daneklientow_idk` = $idk;";
                                            $findidUser = "SELECT `id` FROM `users` WHERE `username` = $idk";
                                            $userId = $db->returnObject($findidUser);
                                            $userIdValue = $userId->id;
                                            $findLoggedIn = "SELECT `userid` FROM `logged_in_users` WHERE `userid` = $userIdValue";
                                            if ($result = $db->getMysqli()->query($findLoggedIn)) {
                                                if ($result->num_rows > 0){
                                                    $deleteLoggedIn = "DELETE FROM `logged_in_users` WHERE `userid` = $userIdValue";
                                                    $db->delete($deleteLoggedIn);
                                                }
                                            }
                                            $sql4 = "DELETE FROM `users` WHERE `username` = $idk;";
                                            $sql5 = "DELETE FROM `daneklientow` WHERE `idk` = $idk;";
                                            $db->delete($sql1);
                                            $db->delete($sql2);
                                            $db->delete($sql3);
                                            $wynik = $db->delete($sql5);
                                            $db->delete($sql4);
                                            if ($wynik == true) {
                                                echo "Pomyślnie usunięto dane klienta o identyfikatorze $idk";
                                            } else {
                                                $db->getMysqli()->sqlstate;
                                            }
                                        } else {
                                            echo "Nie znaleziono takiego użytkownika!";
                                        }
                                        $interfejs->showModal();
                                    }
                                    if (isset($_POST['changePass'])) {
                                        $interfejs->executeZmienHaslo();
                                        $interfejs->showModal();
                                    }
                                    if (isset($_POST['searchClient'])) {
                                        $interfejs->searchClients();
                                        ?>
                                        <script type='text/javascript'>
                                            $(document).ready(function () {
                                                $('#alert').modal('show');
                                            });
                                        </script>
                                        <?php
                                    }
                                    if (isset($_POST['updateTel']) || isset($_POST['updateEmail'])) {
                                        $interfejs->updateTelMail();
                                        ?>
                                        <script type='text/javascript'>
                                            $(document).ready(function () {
                                                $('#alert').modal('show');
                                            });
                                        </script>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $interfejs->build();
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>
