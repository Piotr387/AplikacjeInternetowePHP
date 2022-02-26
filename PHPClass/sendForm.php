<?php

class sendForm {

//Obsluga wyslanego formualrza
    static function sendToServer($db) {

        $args = ['name' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^[0-9A-Za-ząęłńśćźżó_\-]{2,25}$/']],
            'surname' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^[0-9A-Za-ząęłńśćźżó_\-]{2,25}$/']],
            'pesel' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => "/.{11}/"]],
            'phoneClient' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => "/.{9}/"]],
            'email' => FILTER_SANITIZE_EMAIL,
            'birth' => FILTER_SANITIZE_ADD_SLASHES,
            'miejscowoscF' => FILTER_SANITIZE_ADD_SLASHES,
            'ulicaF' => FILTER_SANITIZE_ADD_SLASHES,
            'numberF' => FILTER_SANITIZE_ADD_SLASHES,
            'internetSpeed' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => ["regexp" => "/^(1|2|3)$/"]],
            'iptv' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => ["regexp" => "/^(0|1|2|3)$/"]],
            'umowa' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => ["regexp" => "/^(12|24|36)$/"]]
        ];
        $dane = filter_input_array(INPUT_POST, $args);
        $errors = "";
        foreach ($dane as $key => $val) {
            if ($val === false or $val === NULL) {
                $errors .= $key . " ";
            }
        }
        if ($errors === "") {
            $today = getdate();
            $idForm = $today['year'] . $today['mon'] . $today['mday'] . "/" .
                    $today['hours'] . $today['minutes'] . $today['seconds'] . "/" .
                    floor(mt_rand(1, 99));
            $year = $today['year'];
            $month = $today['mon'];

            $imie = $dane["name"];
            $nazwisko = $dane["surname"];
            $pesel = $dane["pesel"];
            $nrtelefonu = $dane["phoneClient"];
            $email = $dane['email'];
            $time_input = strtotime($dane['birth']);
            $dataUrodzenia = date('Y-m-d', $time_input);
            $miejscowosc = $dane['miejscowoscF'];
            $ulica = $dane['ulicaF'];
            $number = $dane['numberF'];
            $idInternet = $dane['internetSpeed'];
            $idTV = $dane['iptv'];
            $umowa = $dane['umowa'];
            $sqladres = "SELECT * FROM `adresy` WHERE `miejscowosc` = '$miejscowosc' AND `ulica` = '$ulica' AND `numer` = $number ";
            $adres = new phpAdres();
            $idAdres = $adres->getId($db, $sqladres);
            if ($idAdres != -1) {
                if ($idTV == "")
                    $idTV = "NULL";
                $sqlIdClient = "SELECT `idk` FROM `daneklientow` WHERE `pesel` = $pesel";
                if ($resultClient = $db->getMysqli()->query($sqlIdClient)) {
                    if ($resultClient->num_rows > 0) {
                        echo "<h4 class='my-3'>W naszej bazie istnieje już taki klient!</h4>" .
                        "<i class='far fa-grin-hearts fa-5x' style='color: green'></i>" .
                        "<h5 class='my-3'>Jeśli zaczynasz korzystać z naszych usług odwiedź skrzynkę pocztową<br>" .
                        "Natomiast jeśli chcesz dodatkowe usługi pod innym adresem odwiedź panel logowania</h5>";
                    } else {
                        $sql = "INSERT INTO `daneklientow` (`idk`,`imie`,`nazwisko`,`pesel`,`nrtelefonu`,`email`,`dataUrodzenia`,`users_id`) " .
                                "VALUES (NULL, '$imie', '$nazwisko', '$pesel', $nrtelefonu, '$email', '$dataUrodzenia', NULL)";
                        //Dodanei do bazy klienta
                        $answ = $db->insert($sql);
                        //Zwrocenie idk nowo dodanego klienta
                        $wynik = $db->returnObject($sqlIdClient);
                        //zapis idk
                        $idk = $wynik->idk;
                        //Dodajemy nowego uzytkowniak do systemu
                        $dateRejestracji = new DateTime('NOW');
                        $dateRejestracji = $dateRejestracji->format('Y-m-d H:i:s');
                        $passwd = password_hash($pesel, PASSWORD_DEFAULT);
                        $sqlAddUser = "INSERT INTO `users` (`username`,`email`,`passwd`,`datarejestracji`) VALUES ($idk,'$email','$passwd','$dateRejestracji')";
                        $db->insert($sqlAddUser);
                        $sqlGetUserId = "SELECT * FROM `users` WHERE `username` = $idk";
                        $getUserId = $db->returnObject($sqlGetUserId);
                        $userId = $getUserId->id;
                        $sqlUpdateUser = "UPDATE `daneklientow` SET `users_id` = $userId WHERE `idk` = $idk";
                        $db->getMysqli()->query($sqlUpdateUser);
                        //Po dodaniu klienta dodajemy prototyp umowy.
                        $sqlCheckIleUmow = "SELECT `nrumowy` FROM `umowa` WHERE `nrumowy` LIKE '%$year/$month%'";
                        $result = $db->getMysqli()->query($sqlCheckIleUmow);
                        $ile = $result->num_rows;
                        $nr = 1;
                        if ($ile != null) {
                            $nr += $ile;
                        }
                        $idUmowy = $year . "/" . $month . "/" . $nr;
                        $sqlUmowa = "INSERT INTO `umowa` (`nrumowy`,`datazawarcia`,`dlugoscumowy`,`internet_idinternet`, `tv_idtv`, `daneklientow_idk`) "
                                . "VALUES ('$idUmowy',NULL,$umowa,$idInternet,$idTV, $idk)";
                        $db->insert($sqlUmowa);

                        if ($answ == true) {
                            $sqlUpdate = "UPDATE `adresy` SET `zgloszenie` = 1, `daneklientow_idk` = $idk WHERE `adresy`.`id` = $idAdres";
                            $db->getMysqli()->query($sqlUpdate);
                            $sqlFormularz = "INSERT INTO `daneformularza` (`nrzamowienia`,`daneklientow_idk`) VALUES ('$idForm','$idk')";
                            $db->getMysqli()->query($sqlFormularz);

                            $message = "Dziękujemy za zgloszenie nasz pracownik wkrótce sie do ciebie odezwie\n"
                                    . "Twój login to: $idk\n"
                                    . "Twoje hasło: $pesel\n"
                                    . "Hasłem jest twój numer pesel\n"
                                    . "Przy pierwszym logowaniu następi procedura zmiany hasła";
                            $to = $email;
                            $subject = "Witaj w FiboWorld";
                            $headers = "From: fiboworld@example.com" . "\r\n" .
                                    "CC: somebodyelse@example.com";

                            mail($to, $subject, $message, $headers);
                        }
                        echo "<h4 class='my-3'>Dziękujemy za wypełnienie formularza</h4>" .
                        "<i class='far fa-grin-hearts fa-5x' style='color: green'></i>" .
                        "<h5 class='my-3'>Odwiedź swoj adres email do dalszych intrukcji</h5>";
                    }
                } else {
                    echo "<h4 class='my-3'>Błąd połączenia!</h4>" .
                    "<i class='far fa-grin-hearts fa-5x' style='color: green'></i>";
                }
            } else {
                echo "<h4 class='my-3'>Niepoprawne dane, próba wysłania formularza nieudana :/</h4>";
                echo "Niepoprawne dane: $errors";
            }
        } else {
            echo "<h4 class='my-3'>Adres dostawy nie został znaleziony proszę ponów formularz</h4>";
        }
    }

}
