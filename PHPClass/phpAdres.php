<?php

class phpAdres {

    private $miejscowosc = "";
    private $ulica = "";
    private $numer = 0;

    function check($db, $dane) {
        $this->miejscowosc = $dane['miejscowosc'];
        $this->ulica = $dane['ulica'];
        $this->number = $dane['number'];
        $sql = "SELECT * FROM `adresy` WHERE `miejscowosc` = '$this->miejscowosc' AND `ulica` = '$this->ulica' AND `numer` = $this->number ";
        $id = $this->getId($db, $sql);
        if ($id != -1) {
            $sql2 = "SELECT * FROM `adresy` WHERE `id` = $id";
            $zgloszenie = $this->checkZgloszenie($db, $sql2);
            if ($zgloszenie == false) {
                echo "<h4 class='my-3'>Jesteś w zasięgu naszej sieci</h4>" .
                "<i class='far fa-grin-hearts fa-5x' style='color: green'></i>" .
                "<h4 class='my-3'>Jeśli jesteś zainteresowany sprawdź naszą ofertę klikając przycisk poniżej</h4>" .
                "<a class='oferta-link' data-bs-toggle='modal' href='#formularz' id='formZgloszeniowy'>" .
                "<div class='oferta-hover btn btn-primary btn-xl text-uppercase'>" .
                "<div class='oferta-hover-content'>Formularz zgloszeniowy</div>" .
                "</div>" .
                "</a>";
                echo '<script type="text/javascript">',
                'findConnection();',
                '</script>';
            } else {
                echo "<h4 class='my-3'>Pod ten adres został złożony wniosek</h4>" .
                "<i class='far fa-grin-wink fa-5x' style='color: orange'></i>" .
                "<h4 class='my-3'>Sprawdź maila bądź zaloguj się aby uzyskać więcej informacji</h4>";
            }
        } else {
            echo "<h4 class='my-3'>Przykro nam ale nie jesteś w naszym zasięgu</h4>" .
            "<i class='far fa-sad-cry fa-5x' style='color: red'></i>" .
            "<h5 class='my-3'>Wpadnij za jakiś czas, w przypadku uzyskania więcej informacji skontaktuj sie z obsługą</h5>";
        }
    }

    function getId($db, $sql) {
        $id = -1;
        if ($result = $db->getMysqli()->query($sql)) {
            $ile = $result->num_rows;
            if ($ile == 1) {
                $row = $result->fetch_object(); //pobierz rekord z użytkownikiem
                $id = $row->id;
            }
        }
        return $id;
    }

    function checkZgloszenie($db, $sql) {
        if ($result = $db->getMysqli()->query($sql)) {
            $ile = $result->num_rows;
            if ($ile == 1) {
                $row = $result->fetch_object(); //pobierz rekord z adresem
                $zgloszenieInt = $row->zgloszenie;
                if ($zgloszenieInt == 1) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        return false;
    }

    function generateForm($db, $dane) {
        ?>

        <div class="modal-body">
            <form id="clientForm" name="contactForm" method="post" action="#contactForm">
                <div class="row justify-content-center">
                    <h2 class="text-uppercase" id="h2Header">Formularz zgłoszeniowy</h2>
                    <div id="nrZgloszenia"></div>
                    <hr>
                    <!-- Project details-->
                    <h4>Podaj dane personalne:</h4>
                    <div class="row align-items-stretch mb-3">
                        <div class="form-group col-md-4">
                            <div class="goLeft">
                                <i class="fas fa-user-circle"></i>
                                <label for="nameClient">Imię:</label>
                            </div>
                            <input type="text" name="name" id="nameClient" class="form-control"
                                   required="required" pattern="^[a-żA-Ż]+(([a-żA-Ż ])?[a-żA-Ż]*)$"
                                   placeholder="Podaj imię"/>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="goLeft">
                                <i class="fas fa-user-circle"></i>
                                <label for="surnameClient">Nazwisko:</label>
                            </div>
                            <input type="text" name="surname" id="surnameClient" class="form-control"
                                   required="required" pattern="^[a-żA-Ż]+(([a-żA-Ż ])?[a-żA-Ż]*)$"
                                   placeholder="Podaj nazwisko"/>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="goLeft">
                                <i class="far fa-calendar-alt"></i>
                                <label for="dateBirth">Pesel:</label>
                            </div>
                            <input type="text" name="pesel" id="peselClient" class="form-control"
                                   required="required" pattern="^[0-9]{11}*)$"
                                   placeholder="Podaj pesel"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="goLeft">
                                    <i class="fas fa-phone-alt"></i>
                                    <label for="phoneClient">Telefon:</label>
                                </div>
                                <input type="tel" id="phoneClient" name="phoneClient" placeholder="Wprowadź numer telefonu"  
                                       class="form-control" pattern="[0-9]{9}" required="required"/>
                            </div>
                            <div class="col-md-4">
                                <div class="goLeft">
                                    <i class="fas fa-road"></i>
                                    <label for="kodpocztowy">Adres e-mail:</label>
                                </div>
                                <input type="email" id="email" name="email" placeholder="Podaj e-mail" class="form-control"
                                       required="required"/>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="goLeft">
                                    <i class="far fa-calendar-alt"></i>
                                    <label for="dateBirth">Data urodzenia (18+):</label>
                                </div>
                                <input type="date" name="birth" id="dateBirth" name="dateBirth" class="form-control" 
                                       required="required"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg">
                                <i class="fas fa-road"></i>
                                <label for="miejscowoscF">Miejscowość:</label>
                                <input id="miejscowoscF" name="miejscowoscF" type="text" placeholder="Miejscowosc" class="form-control" readonly/><br/>

                            </div>
                            <div class="col-lg">
                                <i class="fas fa-road"></i>
                                <label for="ulicaF">Ulica:</label>
                                <input id="ulicaF" name="ulicaF" type="text" placeholder="BRAK" class="form-control" readonly/><br/>

                            </div>
                            <div class="col-lg">
                                <i class="fas fa-road"></i>
                                <label for="numberF">Nr budynku:</label>
                                <input id="numberF" name="numberF" type="text" placeholder="Numer Budynku" class="form-control" readonly/><br/>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg">
                                <h4>Wybierz prędkośc internetu:</h4>
                                <div id="ofertaV1"></div>
                                <input type="radio" id="internetSpeed300" name="internetSpeed" value="1" required="required"/> 
                                <label for="internetSpeed300">Symetryczny światłowód 300MB/s</label><br/>
                                <input type="radio" id="internetSpeed600" name="internetSpeed" value="2" required="required" /> 
                                <label for="internetSpeed600">Symetryczny światłowód 600MB/s</label><br/>
                                <input type="radio" id="internetSpeed1" name="internetSpeed" value="3" required="required"/> 
                                <label for="internetSpeed1">Symetryczny światłowód 1GB/s</label><br/>
                            </div>
                            <div class="col-lg">
                                <h4>Wybierz dodatkową opcje IPTV:</h4>
                                <div id="ofertaV2"></div>
                                <input type="radio" id="tv0" name="iptv" value="0" checked="checked" required="required"/>
                                <label for="tv12">Brak telewizji</label><br/>
                                <input type="radio" id="tv12" name="iptv" value="1" required="required"/> 
                                <label for="tv12">Telewizja internetowa 12 kanałów</label><br/>
                                <input type="radio" id="tv36" name="iptv" value="2" required="required"/> 
                                <label for="tv36">Telewizja internetowa 36 kanałów</label><br/>
                                <input type="radio" id="tv90" name="iptv" value="3" required="required"/> 
                                <label for="tv90">Telewizja internetowa 90 kanałów</label><br/>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <h4>Wybierz długość umowy:</h4>
                        <i class="fas fa-scroll"></i>
                        <label for="umowa">Umowa na:</label>
                        <select name="umowa" id="umowa" name="umowa" class="form-select" aria-label="Default select example">
                            <option value="12" onclick="liveCalc()">12 Miesięcy</option>
                            <option value="24" onclick="liveCalc()">24 Miesięcy</option>
                            <option value="36" onclick="liveCalc()" selected>36 Miesięcy</option>
                        </select><br/>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12" align="center">
                            <h4>Zgoda na przetwarzanie danych:</h4>
                            <input type="checkbox" name="zgoda" value="zgoda" id="zgoda" required="required"/> 
                            <label for="zgoda">Wyrażam zgodę na przetwarzanie danych osobowych</label><br/><br/>

                            <button class="btn btn-danger btn-xl text-uppercase" data-bs-dismiss="modal" id="clearModifyButton" type="button">
                                <i class="fas fa-times me-1"></i>
                                Zamknij
                            </button>
                            <button class="btn btn-success btn-xl text-uppercase" name="sendForm" value="sendForm" type="submit">
                                <i class="fas fa-check"></i>
                                Zatwierdź
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <script type="text/javascript">
            document.getElementById("miejscowoscF").value = '<?php echo $dane['miejscowosc'] ?>';
            document.getElementById("ulicaF").value = '<?php echo $dane['ulica'] ?>';
            document.getElementById("numberF").value = '<?php echo $dane['number'] ?>';
            var nrFormDiv = document.getElementById('nrZgloszenia');
            if (nrFormDiv.innerHTML === "") {
                formNumber = randCase();
            }
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear() - 18;
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }
            today = yyyy + '-' + mm + '-' + dd;
            document.getElementById("dateBirth").setAttribute("max", today);
            document.getElementById("dateBirth").setAttribute("value", today);
        </script>

        <?php
    }

    function updateAddres($dane) {
        ?>
        <script type="text/javascript">
            document.getElementById("miejscowoscF").value = '<?php echo $dane['miejscowosc'] ?>';
            document.getElementById("ulicaF").value = '<?php echo $dane['ulica'] ?>';
            document.getElementById("numberF").value = '<?php echo $dane['number'] ?>';
        </script>
        <?php
    }

}
