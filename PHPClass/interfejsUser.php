<?php

class interfejsUser {

    private $db;
    private $userId;
    private $daneObj;

    public function __construct($db, $userId) {
        $this->db = $db;
        $this->userId = $userId;
        $sql = "SELECT A.id, A.username, A.datarejestracji,
                    B.idk, B.imie, B.nazwisko, B.pesel, B.nrtelefonu, B.email, B.dataurodzenia,
                    C.miejscowosc, C.ulica, C.numer, C.kodpocztowy,
                    D.nrzamowienia, D.status,
                    E.nrumowy, E.datazawarcia, E.dlugoscumowy,
                    F.idinternet AS 'idinternet', F.nazwa AS 'nazwaInternet' , F.cena AS 'cenainternet' , F.predkosc AS 'predkoscInternet',
                    G.idtv, G.nazwa AS 'nazwaTV', G.cena AS 'cenaTV' , G.ilekanalow
                    FROM `users` AS A
                    INNER JOIN `daneklientow` AS B ON A.username = B.idk
                    INNER JOIN `adresy` AS C ON B.idk = C.daneklientow_idk
                    INNER JOIN `daneformularza` AS D ON B.idk = D.daneklientow_idk
                    INNER JOIN `umowa` AS E ON B.idk = E.daneklientow_idk
                    INNER JOIN `internet` AS F ON E.internet_idinternet = F.idinternet
                    INNER JOIN `tv` AS G ON E.tv_idtv = G.idtv
                    WHERE A.id = $this->userId";
        $this->daneObj = $this->db->returnObject($sql);
    }

    function build() {
        ?>
        <header class="masthead p-0">
            <section class="page-section" id="intPanel">
                <div class="container">
                    <div class="row text-center">
                        <div class="col-md-2"><a class="navbar-brand" href="#page-top"><img src="assets/img/navbar-logo.svg" alt="..." /></a></div>
                        <div class="col-md-8"><h2 class="text-uppercase">PANEL UŻYTKOWNIKA</h2></div>
                        <div class="col-md-2">
                            <a class='text-white nav-link btn btn-danger' href='logowanie.php?akcja=wyloguj'>
                                <i class="bi bi-box-arrow-left"></i>
                                Wyloguj
                            </a>
                        </div>
                    </div>
                    <?php
                    $this->buttons();
                    ?>
                </div>
            </section>
        </header>
        <body>
            <?php
            if (isset($_GET["akcja"])) {
                if ($_GET["akcja"] == "dane") {
                    $this->mojeDane();
                } else if ($_GET["akcja"] == "umowy") {
                    $this->umowy();
                } else if ($_GET["akcja"] == "platnosci") {
                    $this->platnosci();
                } else if ($_GET["akcja"] == "haslo") {
                    $this->zmienHaslo();
                }
            } else {
                $this->mojeDane();
            }
        }

        function button($akcja, $tekst) {
            ?>
            <div class="col-md-3">
                <a class='text-white nav-link btn btn-warning' data-bs-toggle='' href='zalogowany.php?akcja=<?php echo $akcja ?>'>
                    <?php
                    echo $tekst
                    ?>
                </a>
            </div>

            <?php
        }

        function buttons() {
            ?>
            <div class="row mt-5 text-center">
                <?php
                $this->button("dane", "MOJE DANE");
                $this->button("umowy", "UMOWY");
                $this->button("platnosci", "PŁATNOŚCI");
                $this->button("haslo", "ZMIEŃ HASŁO");
                ?>
            </div>
            <?php
        }

        function zmienHaslo() {
            $um = new UserManager();
            ?>
            <section class="page-section" id="services">
                <div class="container text-center col-lg-3">
                    <?php
                    echo "<h2 class='text-uppercase'>Zmiana hasła:</h2><br/>";
                    $um->buildPasswordChange("zalogowany.php?akcja=haslo");
                    ?>
                </div>
            </section>
            <?php
        }

        function executeZmienHaslo() {
            $um = new UserManager();
            $um->zmienHaslo($this->db, $this->userId);
        }

        function showModal() {
            ?>
            <script type='text/javascript'>
                $(document).ready(function () {
                    $('#alert').modal('show');
                });
                setTimeout(function () {
                    $('#alert').modal('hide')
                }, 4000);
            </script>
            <?php
        }

        function mojeDane() {
            $dane = $this->daneObj;
            ?>
            <section class='page-section' id='services'>
                <div class='container'>
                    <h3>Identyfikator klienta: <?php echo $dane->idk ?> </h3>
                    <fieldsset class="border form-control">
                        <legend class="w-auto">Dane klienta: </legend>
                        <div class="row my-3">
                            <div class="col-sm">
                                <h5>Imię i Nazwisko:</h5>
                                <div class='form-control'><?php echo "$dane->imie $dane->nazwisko"; ?></div>
                            </div>
                            <div class="col-sm">
                                <h5>Pesel: </h5>
                                <div class='form-control'><?php echo "$dane->pesel"; ?></div>
                            </div>
                            <div class="col-sm">
                                <h5>Data urodzenia: </h5>
                                <div class='form-control'><?php echo "$dane->dataurodzenia"; ?></div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-sm">
                                <h5>Miejscowosc:</h5>
                                <div class='form-control'><?php echo "$dane->miejscowosc"; ?></div>
                            </div>
                            <div class="col-sm">
                                <h5>Ulica: </h5>
                                <div class='form-control'><?php echo "$dane->ulica"; ?></div>
                            </div>
                            <div class="col-sm">
                                <h5>Numer: </h5>
                                <div class='form-control'><?php echo "$dane->numer"; ?></div>
                            </div>
                        </div>
                        <div class="row text-center my-3">
                            <div class="col-sm">
                                <form id="updateEmail" name="updateEmail" method="post">
                                    <h5>Nr telefonu:</h5>
                                    <input type="text" id="tel" name="tel" placeholder="Podaj nr telefonu" value="<?php echo "$dane->nrtelefonu"; ?>" class="form-control"
                                           required="required"/>
                                    <button class="btn btn-success text-uppercase" name="updateTel" value="updateTel" type="submit">
                                        <i class="fas fa-check"></i>
                                        ZMIEŃ NR TELEFONU
                                    </button>
                                </form>
                            </div>
                            <div class="col-sm ">
                                <form id="updateEmail" name="updateEmail" method="post">
                                    <h5>E-mail: </h5>
                                    <input type="email" id="email" name="email" placeholder="Podaj e-mail" value="<?php echo "$dane->email"; ?>" class="form-control"
                                           required="required"/>
                                    <button class="btn btn-success text-uppercase" name="updateEmail" value="updateEmail" type="submit">
                                        <i class="fas fa-check"></i>
                                        ZMIEŃ ADRES E-MAIL
                                    </button>
                                </form>
                            </div>
                        </div>  
                        <div class="row text-center my-3" id="innerDeleteRoot">
                        </div>
                    </fieldsset>

                    <div class='row align-items-stretch mb-3'>
                    </div>
                </div>
            </section>
            <?php
        }

        function umowy() {
            ?>
            <div class='container form-control'>
                <legend class="w-auto">Nr umowy: <b><?php echo $this->daneObj->nrumowy ?></b></legend>
                <h5>Długość trwania umowy: <?php echo $this->daneObj->dlugoscumowy ?> miesięcy</h5>
                <h5>Umowa na adres: <?php echo $this->daneObj->miejscowosc . " " . $this->daneObj->ulica . " " . $this->daneObj->numer ?> </h5>
                <div class="row text-center">
                    <div class='w-50'><i class="bi bi-router  fa-10x"></i><br><h2>Internet</h2>
                        <h5>ID OFERTY: <?php echo $this->daneObj->idinternet ?></h5>
                        <h5>Nazwa usługi: <?php echo $this->daneObj->nazwaInternet ?></h5>
                        <h5>Cena usługi: <?php echo $this->daneObj->cenainternet ?></h5>
                        <h5>Predkość internetu: <?php echo $this->daneObj->predkoscInternet ?></h5>
                    </div>
                    <div class='w-50'><i class="bi bi-tv  fa-10x"></i><br><h2>Telewizja</h2>
                        <h5>ID OFERTY: <?php echo $this->daneObj->idtv ?></h5>
                        <h5>Nazwa usługi: <?php echo $this->daneObj->nazwaTV ?></h5>
                        <h5>Cena usługi: <?php echo $this->daneObj->cenaTV ?></h5>
                        <h5>Ilość kanałów: <?php echo $this->daneObj->ilekanalow ?></h5>
                    </div>
                </div>
            </div>
            <?php
        }

        function platnosci() {
            ?>
            <div class = 'container form-control text-center'>
                <h5>W trakcie budowy</h5>
                <div class="fa-5x">
                    <i class="fas fa-cog fa-spin"></i>
                </div>
            </div>
            <?php
        }

        function updateTelMail() {
            $sql = "SELECT B.idk FROM `users` AS A
            INNER JOIN `daneklientow` AS B ON A.username = B.idk
            WHERE A.id = $this->userId;";
            $query = $this->db->returnObject($sql);
            $idk = $query->idk;
            if (isset($_POST['updateTel'])) {
                $tel = $_POST['tel'];
                $sqlTel = "UPDATE `daneklientow` SET `nrtelefonu` = '$tel' WHERE `daneklientow`.`idk` = $idk; ";
                $result = $this->db->getMysqli()->query($sqlTel);
                if ($result == true) {
                    ?>
                    <h2 class="text-uppercase">Pomyślnie zmieniono nr tel!</h2><br/>
                    <?php
                } else {
                    ?>
                    <h2 class="text-uppercase">UPS coś poszło nie tak</h2><br/>
                    <?php
                }
            } else {
                $args =[
                    'email' => FILTER_SANITIZE_EMAIL
                ];
                $dane = filter_input_array(INPUT_POST, $args);
                $mail = $dane['email'];
                $sqlEmail = "UPDATE `daneklientow` SET `email` = '$mail' WHERE `daneklientow`.`idk` = $idk; ";
                $result = $this->db->getMysqli()->query($sqlEmail);
                if ($result == true) {
                    ?>
                    <h2 class="text-uppercase">Pomyślnie zmieniono email</h2><br/>
                    <?php
                } else {
                    ?>
                    <h2 class="text-uppercase">UPS coś poszło nie tak</h2><br/>
                    <?php
                }
            }
        }

    }
    