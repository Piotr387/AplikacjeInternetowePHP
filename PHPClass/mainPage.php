<?php

class mainPage {

    function build() {
        ?>
        <?php
        include_once 'PHPClass/Baza.php';
        include_once 'PHPClass/UserManager.php';
        include_once 'PHPClass/phpAdres.php';
        include_once 'PHPClass/sendForm.php';
        $db = new Baza("localhost", "root", "", "projektphp");
        ?>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#page-top"><img src="assets/img/navbar-logo.svg" alt="..." /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0 text-center">
                        <li class="nav-item"><a class="nav-link" href="#services">Nasze<br>usługi</a></li>
                        <li class="nav-item"><a class="nav-link" href="#oferta">Oferta</a></li>
                        <li class="nav-item"><a class="nav-link" href="#howItWorks">Jak<br>działamy?</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Sprawdź<br>zasięg</a></li>
                        <li class="nav-item"><a class="nav-link" href="#kontakt">Kontakt</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-success" data-bs-toggle="modal" onclick="location.href = 'logowanie.php'">Logowanie</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Nawigacja - baner -->
        <header class="masthead">
            <div class="container">
                <div class="masthead-subheading">Witaj w FiBoWoRlD</div>
                <div class="masthead-heading text-uppercase">Połącz się ze światem razem z nami</div>
                <a class="btn btn-primary btn-xl text-uppercase" href="#services">Dowiedz się więcej</a>
            </div>
        </header>
        <!-- Nasze usługi -->
        <section class="page-section" id="services">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Nasze usługi</h2>
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
        </section>
        <!-- oferta Grid-->
        <section class="page-section bg-light" id="oferta">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Oferta</h2>
                    <h3 class="section-subheading text-muted">Poznaj szczegóły naszej oferty</h3>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <!-- oferta item 1-->
                        <div class="oferta-item">
                            <a class="oferta-link" data-bs-toggle="modal" href="#ofertaModal1">
                                <div class="oferta-hover">
                                    <div class="oferta-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <img class="img-fluid" src="assets/img/oferta/1.jpg" alt="..." />
                            </a>
                            <div class="oferta-caption">
                                <div class="oferta-caption-heading">Internet Światłowodowy</div>
                                <div class="oferta-caption-subheading text-muted">Dostosuj prędkość do siebie</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <!-- oferta item 2-->
                        <div class="oferta-item">
                            <a class="oferta-link" data-bs-toggle="modal" href="#ofertaModal2">
                                <div class="oferta-hover">
                                    <div class="oferta-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <img class="img-fluid" src="assets/img/oferta/2.jpg" alt="..." />
                            </a>
                            <div class="oferta-caption">
                                <div class="oferta-caption-heading">Telewizja IPTV</div>
                                <div class="oferta-caption-subheading text-muted">Szeroka gama kanałów</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <!-- oferta item 3-->
                        <div class="oferta-item">
                            <a class="oferta-link" data-bs-toggle="modal" href="#ofertaModal3">
                                <div class="oferta-hover">
                                    <div class="oferta-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <img class="img-fluid" src="assets/img/oferta/3.jpg" alt="..." />
                            </a>
                            <div class="oferta-caption">
                                <div class="oferta-caption-heading">Montaż światłowodu</div>
                                <div class="oferta-caption-subheading text-muted">Nie jesteś podłączony ? Nic nie szkodzi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About-->
        <section class="page-section" id="howItWorks">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Jak działamy?</h2>
                    <h3 class="section-subheading text-muted">Tylko 3 kroki dzieli nas od bycia razem w sieci</h3>
                </div>
                <ul class="timeline">
                    <li>
                        <div class="timeline-image"><i class="fas fa-plug fa-stack-2x fa-3x"></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>Krok 1:</h4>
                                <h4 class="subheading">Sprawdź podłączenie</h4>
                            </div>
                            <div class="timeline-body"><p class="text-muted">Sprawdź czy nasza oferta obejmuje twoje miejsce zamieszkania. 
                                    Jeśli tak to przejdz dalej jeśli nie uzbrój się w cierpliwość nasza firma wciąż poszerza zasięgi</p></div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-image"><i class="fas fa-cart-arrow-down fa-stack-2x fa-3x" ></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>Krok 2:</h4>
                                <h4 class="subheading">Zamów ofertę</h4>
                            </div>
                            <div class="timeline-body"><p class="text-muted">Złóż zamówienie a wkrótce nasz konsultant skontaktuje się z tobą w celu ustalenia dalszych szczegółów</p></div>
                        </div>
                    </li>
                    <li>
                        <div class="timeline-image"><i class="fas fa-wrench fa-stack-2x fa-3x"></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>Krok 3:</h4>
                                <h4 class="subheading">Montaż</h4>
                            </div>
                            <div class="timeline-body"><p class="text-muted">Nasz technik przyjdzie na umówiony termin, i podłączy Ciebie do naszej sieci a 
                                    później skonfigure wszystko za ciebie a ty zacznij swobodnie surfować po internecie!</p></div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-image">
                            <i class="fas fa-handshake fa-stack-2x fa-3x"></i>
                        </div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>Gotowe!</h4>
                                <h4 class="subheading">To wszystko</h4>
                            </div>
                            <div class="timeline-body"><p class="text-muted">Dołączyłeś do zadowolonej społeczności FiBeWoRlD</p></div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        <!-- Contact-->
        <section class="page-section" id="contact">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Sprawdź zasięg</h2>
                    <h3 class="section-subheading text-muted">Wprowadź swoje dane adresowe</h3>
                </div>
                <form id="contactForm" name="contactForm" method="post" action="#contactForm">
                    <div class="row align-items-stretch mb-3">
                        <div class="form-group col-md-4" >
                            <input class="form-control" name="miejscowosc" type="text" placeholder="Miejscowosc" required="required" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group col-md-4">
                            <input class="form-control" name="ulica" type="text" placeholder="Ulica"/>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group col-md-4">
                            <input class="form-control" name="number" type="text" placeholder="Numer Budynku" required="required" />
                            <p class="help-block text-danger"></p>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary btn-xl text-uppercase" id="sendMessageButton" 
                                    value="sendMessageButton" name="sendMessageButton"
                                    type="submit">Sprawdź</button>
                        </div>
                        <div id="goToCalculator" class="text-center">
                            <?php
                            if (filter_input(INPUT_POST, "sendMessageButton")) {
                                $kontaktKomunikat = new phpAdres();
                                $args = ['miejscowosc' => FILTER_SANITIZE_ADD_SLASHES,
                                    'ulica' => FILTER_SANITIZE_ADD_SLASHES,
                                    'number' => FILTER_SANITIZE_ADD_SLASHES
                                ];
                                $daneAdres = filter_input_array(INPUT_POST, $args);
                                $kontaktKomunikat->check($db, $daneAdres);
                                $_SESSION['daneAdres'] = serialize($daneAdres);
                            }
                            if (filter_input(INPUT_POST, "sendForm")) {
                                sendForm::sendToServer($db);
                            }
                            ?>
                        </div>
                </form>
            </div>
        </section>
        <!-- Kontakt-->
        <section class="page-section bg-light" id="kontakt">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Kontakt</h2>
                    <h3 class="section-subheading text-muted">Masz pytania ? Zadzwoń lub nas odwiedź</h3>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="assets/img/team/1.jpg" alt="..." />
                            <h4>Piotr Piwoński</h4>
                            <p class="text-muted">Lead Designer</p>
                            <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-linkedin-in"></i></a>
                            <p class="large text-muted">Telefon:</p>
                            <p class="large text-muted">+48 XXX-XXX-XXX</p>
                            <p class="large text-muted">E-mail:</p>
                            <p class="large text-muted">kontakt@fiboworld.pl</p>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <h3 class="section-heading text-uppercase">Nasz salon:</h3>
                        <div id="map" style="width: 100%; height:30rem;"></div>
                        <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUWiHsVFw2wj-bVv0uLIdAdUyR1r5crk4&callback=initMap&libraries=&v=weekly" ></script>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 mx-auto text-center"><p class="large text-muted">Zapraszamy do współpracy!</p></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="footer py-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 text-lg-start">
                        Copyright &copy; PP
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                    </div>
                    <div class="col-lg-6 text-lg-end">
                        <a class="link-dark text-decoration-none me-3" href="#!">Polityka Prywatności</a>
                        <a class="link-dark text-decoration-none" href="#!">Warunki korzystania</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- oferta Modals-->
        <!-- oferta item 1 modal popup-->
        <div class="oferta-modal modal fade" id="ofertaModal1" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body table table-striped table-hover">
                                    <!-- Project details-->
                                    <h2 class="text-uppercase">Internet światłowodowy</h2>
                                    <p class="item-intro text-muted">Poczuj prawdziwą prędkosć</p>
                                    <img class="img-fluid d-block mx-auto" src="assets/img/oferta/1.jpg" alt="..." />
                                    <div class="row justify-content-center">
                                        <div class="col-auto">
                                            <p id="ofertaModal1DIV">
                                                <?php
                                                $sql = "SELECT * FROM `internet` WHERE `czyWofercie` = '1' ORDER BY `internet`.`idinternet` ASC";
                                                echo $db->select($sql, ["idinternet", "nazwa", "cena", "predkosc"]);
                                                ?>
                                            </p> 
                                            <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                                <i class="fas fa-times me-1"></i>
                                                Zamknij
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- oferta item 2 modal popup-->
        <div class="oferta-modal modal fade" id="ofertaModal2" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body table table-striped table-hover">
                                    <!-- Project details-->
                                    <h2 class="text-uppercase">Telewizja Internetowa</h2>
                                    <p class="item-intro text-muted">Twoje ulubione programy pod ręką</p>
                                    <img class="img-fluid d-block mx-auto" src="assets/img/oferta/2.jpg" alt="..." />
                                    <p id="ofertaModal2DIV">
                                        <?php
                                        $sql = "SELECT * FROM `tv` WHERE `czyWofercie` = '1' ORDER BY `tv`.`idtv` ASC";
                                        echo $db->select($sql, ["idtv", "nazwa", "cena", "ilekanalow"]);
                                        ?>
                                    </p>
                                    <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                        <i class="fas fa-times me-1"></i>
                                        Zamknij
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- oferta item 3 modal popup-->
        <div class="oferta-modal modal fade" id="ofertaModal3" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <!-- Project details-->
                                    <h2 class="text-uppercase">Montaż światłowodu</h2>
                                    <p class="item-intro text-muted">Dołącz do grona podłączonych do swiatlowodu</p>
                                    <img class="img-fluid d-block mx-auto" src="assets/img/oferta/3.jpg" alt="..." />
                                    <p>Na ten moment nie posiadamy uniwersalnego cennika, każdą ofertę rozpatrujmy indywidualnie na potrzeby klienta</p>
                                    <p id="ofertaModal3DIV">Jeśli chcesz podłączenia światłowodowego w swoim w domu skontatkkuj się z nami telefonicznie w celu ustalenia spotkania osobistego.</p>
                                    <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                        <i class="fas fa-times me-1"></i>
                                        Zamknij
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Formularz -->
        <div class="oferta-modal modal fade" id="formularz" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal" id="clearModifyX"><img src="assets/img/close-icon.svg" alt="Close modal" /></div>
                    <div class="container">
                        <?php
                        if (filter_input(INPUT_POST, "sendMessageButton")) {
                            $dane = unserialize($_SESSION['daneAdres']);
                            $kontaktKomunikat->generateForm($db, $dane);
                        }
                        if (filter_input(INPUT_POST, "modyfikuj")) {
                            var_dump($_SESSION['nrZam']);
                            $daneZamowienie = unserialize($_SESSION['nrZam']);
                            modyfikuj::build($db, $daneZamowienie);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

}
