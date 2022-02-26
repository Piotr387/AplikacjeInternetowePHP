<?php
include_once 'PHPClass/Baza.php';
include_once 'PHPClass/UserManager.php';

class interfejsRoot {

    private $db;
    private $userId;

    public function __construct($db, $userId) {
        $this->db = $db;
        $this->userId = $userId;
    }

    function build() {
        ?>
        <header class="masthead p-3">
            <section class="page-section" id="intPanel">
                <div class="container">
                    <div class="row text-center">
                        <div class="col-md-2"><a class="navbar-brand" href="#page-top"><img src="assets/img/navbar-logo.svg" alt="..." /></a></div>
                        <div class="col-md-8"><h2 class="text-uppercase">PANEL ADMINISTRACYJNY</h2></div>
                        <div class="col-md-2">
                            <a class='nav-link btn btn-danger' href='logowanie.php?akcja=wyloguj'>
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
                if ($_GET["akcja"] == "usunKlient") {
                    $action = "usunKlient";
                } else if ($_GET["akcja"] == "applyForm") {
                    $this->apply();
                } else if ($_GET["akcja"] == "searchAdres") {
                    $this->menAdresow();
                } else if ($_GET["akcja"] == "searchKlient") {
                    $this->menKlientow();
                } else if ($_GET["akcja"] == "haslo") {
                    $this->zmienHaslo();
                }
            } else {
                $this->buildBody();
            }
            ?>
        </body>
        <?php
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
            $this->button("haslo", "ZMIEŃ HASŁO");
            $this->button("applyForm", "ZATWIERDŹ FORMULARZ");
            $this->button("searchKlient", "MENADŻER KLIENTÓW");
            $this->button("searchAdres", "MENADŻER ADRESÓW");
            ?>
        </div>
        <?php
    }

    function buildBody() {
//Po zalogowaniu
        ?>
        <section class="page-section" id="services">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Witaj w panelu administracyjnym</h2>
                    <h3 class="section-subheading text-muted">Połącz kilka usług w jedną ofertę !</h3>
                </div>
                <div class="row text-center">
                    <div class="col-md-4">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-globe fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="my-3">Internet światłowodowy</h4>
                        <p class="text-muted">Światłowód synchroniczny zapewnia ci jeszcze lepsze 
                            doznania z serfowania po internecie</p>
                    </div>
                    <div class="col-md-4">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-tv fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="my-3">IPTV</h4>
                        <p class="text-muted">Dzięki szybkiemu łączu bez problemu możesz oglądać telewizję 
                            jednocześnie surfując po internecie bez obaw o wolne łącze</p>
                    </div>
                    <div class="col-md-4">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-tools fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="my-3">Montaż światłowodu</h4>
                        <p class="text-muted">Nie masz podłączenia mieszkania za pomocą światłowodu ? Nie ma problemu skontaktuj się z nami!</p>
                    </div>
                </div>
            </div>
        </section><?php
    }

    function buildDanePracownika() {
        
    }

    function buildWyswietlAdresy() {
        
    }

    function apply() {
        ?>
        <section class="page-section" id="services">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">NOWE ZGŁOSZENIA</h2>
                    <h3 class="section-subheading text-muted">Wybierz sposród dostępnych</h3>
                </div>
                <?php
                $sql = "SELECT * FROM `daneformularza` WHERE `status` = 'W trakcie realizacji'";
                $result = $this->db->getMysqli()->query($sql);
                if ($result->num_rows > 0) {
                    ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NR ZAMÓWIENIA</th>
                                <th>NR IDK KLIENTA</th>
                                <th>STATUS</th>
                                <th>OPERACJE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_object()) {
                                    echo "<tr>";
                                    echo "<td>$i</td>";
                                    echo "<td>$row->nrzamowienia</td>";
                                    echo "<td>$row->daneklientow_idk</td>";
                                    echo "<td>$row->status</td>";
                                    echo "<td><i class='bi bi-check2 fa-2x .text-success'></i>  <i class='bi bi-x-lg fa-2x'></i></td>";
                                    echo "</tr>";
                                    $i += 1;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo "Brak formularzy do zatwierdzenia!";
                }
                ?>

            </div>
        </section>
        <?php
    }

    function menKlientow() {
        ?>
        <section class="page-section" id="services">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">WYSZUKAJ KLIENTA</h2>
                    <h3 class="section-subheading text-muted">Wprowadź IDK klienta:</h3>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>IDK</th>
                            <th>IMIĘ</th>
                            <th>NAZWISKO</th>
                            <th>PESEL</th>
                            <th>NR TELEFONU</th>
                            <th>EMAIL</th>
                            <th>OPERACJE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                    <form id="searchClient" name="searchClient" method="post">
                        <td><input id="IDK" name="idk" type="text" placeholder="IDK" class="form-control"/></td>
                        <td><input id="imie" name="imie" type="text" placeholder="IMIE" class="form-control"/></td>
                        <td><input id="nazwisko" name="nazwisko" type="text" placeholder="NAZWISKO" class="form-control"/></td>
                        <td><input id="pesel" name="pesel" type="text" placeholder="PESEL" class="form-control"/></td>
                        <td><input id="nrtel" name="nrtel" type="text" placeholder="NR TELEFONU" class="form-control"/></td>
                        <td><input id="email" name="email" type="text" placeholder="EMAIL" class="form-control"/></td>
                        <td>
                            <button class="btn btn-success text-uppercase" name="searchClient" value="searchClient" type="submit">
                                SZUKAJ
                            </button>
                        </td>
                        </tr>
                    </form>

                    </tbody>
                </table>
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Menadżer klientów</h2>
                    <h3 class="section-subheading text-muted">Dostępni klienci:</h3>
                </div>
                <?php
                $sql = "SELECT * FROM `daneklientow`";
                $result = $this->db->getMysqli()->query($sql);
                if ($result->num_rows > 0) {
                    ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>IDK</th>
                                <th>IMIĘ</th>
                                <th>NAZWISKO</th>
                                <th>PESEL</th>
                                <th>NR TELEFONU</th>
                                <th>EMAIL</th>
                                <th>DATA URODZENIA</th>
                                <th>OPERACJE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_object()) {
                                    echo "<tr>";
                                    echo "<td>$row->idk</td>";
                                    echo "<td>$row->imie</td>";
                                    echo "<td>$row->nazwisko</td>";
                                    echo "<td>$row->pesel</td>";
                                    echo "<td>$row->nrtelefonu</td>";
                                    echo "<td>$row->email</td>";
                                    echo "<td>$row->dataurodzenia</td>";
                                    ?>
                                <form id="deleteKlientForm" name="deleteKlientForm" method="post">
                                    <td>
                                        <button name="deleteKlientBtn" value="deleteKlientBtn" type="submit">
                                            <i class='bi bi-x-lg text-danger'></i>
                                            <input type="hidden" name="deleteKlient" value="<?php echo $row->idk; ?>">
                                        </button>
                                    </td>

                                </form>
                                <?php
                                echo "</tr>";
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo "Brak klientów do wyświetlenia!";
                }
                ?>

            </div>
        </section>
        <?php
    }

    function menAdresow() {
        ?>
        <section class="page-section" id="services">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Dodaj adres</h2>
                    <h3 class="section-subheading text-muted">Wprowadź dane adresu:</h3>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Miejscowość</th>
                            <th>Ulica</th>
                            <th>NUMER</th>
                            <th>KOD POCZTOWY</th>
                            <th>AKCJE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                    <form id="addAdresForm" name="addAdresForm" method="post">
                        <td>1</td>
                        <td><input id="msc" name="msc" type="text" placeholder="Miejscowosc" class="form-control" required/></td>
                        <td><input id="ul" name="ul" type="text" placeholder="Ulica" class="form-control" /></td>
                        <td><input id="nr" name="nr" type="text" placeholder="Numer" class="form-control" required/></td>
                        <td><input id="postcode" name="postcode" type="text" placeholder="Kod pocztowy" class="form-control" required/></td>
                        <td>
                            <button class="btn btn-success text-uppercase" name="addAdres" value="addAdres" type="submit">
                                <i class="fas fa-check"></i>
                                DODAJ
                            </button>
                        </td>
                    </form>
                    </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Menadżer adresów</h2>
                    <h3 class="section-subheading text-muted">Wybierz sposród dostępnych</h3>
                </div>
                <?php
                $sql = "SELECT * FROM `adresy`";
                $result = $this->db->getMysqli()->query($sql);
                if ($result->num_rows > 0) {
                    ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Miejscowość</th>
                                <th>Ulica</th>
                                <th>Numer</th>
                                <th>Kod pocztowy</th>
                                <th>IDK KLIENTA</th>
                                <th>AKCJE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_object()) {
                                    echo "<tr>";
                                    echo "<td>$row->id</td>";
                                    echo "<td>$row->miejscowosc</td>";
                                    echo "<td>$row->ulica</td>";
                                    echo "<td>$row->numer</td>";
                                    echo "<td>$row->kodpocztowy</td>";
                                    echo "<td>$row->daneklientow_idk</td>";
                                    if ($row->daneklientow_idk != "") {
                                        echo "<td></td>";
                                    } else {
                                        ?>
                                    <form id="addAdresForm" name="addAdresForm" method="post">
                                        <td>
                                            <button name="deleteAdres" value="deleteAdres" type="submit">
                                                <i class='bi bi-x-lg text-danger'></i>
                                                <input type="hidden" name="delete" value="<?php echo $row->id; ?>">
                                            </button>
                                        </td>

                                    </form>
                                    <?php
                                }
                                echo "</tr>";
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo "Brak adresów do wyswietlenia!";
                }
                ?>

            </div>
        </section>
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
            }, 4000);</script>
        <?php
    }

    function searchClients() {
        $idk = $_POST['idk'];
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $pesel = $_POST['pesel'];
        $nrtel = $_POST['nrtel'];
        $email = $_POST['email'];
        $sql = "SELECT * FROM `daneklientow` WHERE "
                . "`idk` = '$idk' OR "
                . "`imie` LIKE '$imie' OR "
                . "`nazwisko` LIKE '$nazwisko' OR "
                . "`pesel` LIKE '$pesel' OR "
                . "`nrtelefonu` = '$nrtel' OR "
                . "`email` LIKE '$email'; ";
        $result = $this->db->getMysqli()->query($sql);
        $ile = $result->num_rows;
        if ($ile > 0) {
            while ($row = $result->fetch_assoc()) {

                $userInterfejs = new interfejsUser($this->db, $row['users_id']);
                $userInterfejs->mojeDane();
                ?>
                <script type='text/javascript'>
                    var tekst = "<form id='deleteKlientForm' name='deleteKlientForm' method='post'>" +
                            "<button name='deleteKlientBtn' value='deleteKlientBtn' type='submit'>" +
                            "<i class='bi bi-x-lg text-danger'></i>" +
                            "<input type='hidden' name='deleteKlient' value='<?php echo $row['idk']; ?>'>" +
                            " Usuń klienta od IDK: <?php echo $row['idk']; ?>" +
                            "</button>" +
                            "</form>";
                    var div = document.getElementById('innerDeleteRoot');
                    div.innerHTML = tekst;
                </script>
                <?php
            }
        } else {
            echo "0 results";
        }
    }

}
