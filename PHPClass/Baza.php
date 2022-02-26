<?php

class Baza {

    private $mysqli; //uchwyt do BD 

    public function __construct($serwer, $user, $pass, $baza) {
        $this->mysqli = new mysqli($serwer, $user, $pass, $baza);
        /* sprawdz połączenie */
        if ($this->mysqli->connect_errno) {
            printf("Nie udało sie połączenie z serwerem: %s\n", $this->mysqli->connect_error);
            exit();
        }
        /* zmien kodowanie na utf8 */
        if ($this->mysqli->set_charset("utf8")) {
            //udało sie zmienić kodowanie         
        }
    }

//koniec funkcji konstruktora 

    function __destruct() {
        $this->mysqli->close();
    }

    public function select($sql, $pola) {
        //parametr $sql – łańcuch zapytania select         
        //parametr $pola - tablica z nazwami pol w bazie          
        //Wynik funkcji – kod HTML tabeli z rekordami (String)         
        $tresc = "";
        if ($result = $this->mysqli->query($sql)) {
            if ($result->num_rows > 0) {
                $ilepol = count($pola); //ile pól             
                $ile = $result->num_rows; //ile wierszy          
                // pętla po wyniku zapytania $results             
                $tresc .= "<table class='table table-responsive'><thead><tr>";
                foreach ($pola as $value) {
                    $tresc .= "<th>$value</th>";
                }
                $tresc .= "</tr></thead><tbody>";
                while ($row = $result->fetch_object()) {
                    $tresc .= "<tr>";
                    for ($i = 0; $i < $ilepol; $i++) {
                        $p = $pola[$i];
                        $tresc .= "<td>" . $row->$p . "</td>";
                    }
                    $tresc .= "</tr>";
                }
                $tresc .= "</table></tbody>";
                $result->close(); /* zwolnij pamięć */
            } else {
                $tresc = "Brak wynikow wyszukiwania!";
            }
        } else {
            $tresc = "Błąd zapytania! Prawdopodobnie tabela nie została utworzona";
        }
        return $tresc;
    }

    public function delete($sql) {
        if ($this->mysqli->query($sql)) {
            return true;
        } else {
            echo "<br>Wystąpił błąd w usuwaniu";
            return false;
        }
    }

    public function insert($sql) {
        if ($this->mysqli->query($sql)) {
            return true;
        } else {
            echo "<br>Wystąpił błąd w dodawaniu nowego zamowienia";
            return false;
        }
    }

    public function getMysqli() {
        return $this->mysqli;
    }

    function dodajdoBD($bd) {
        $args = [
            'nazw' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^[A-Z]{1}[a-ząęłńśćźżó-]{1,25}$/']],
            'age' => ['filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1, 'max_range' => 100]],
            'country' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'email' => FILTER_VALIDATE_EMAIL,
            'jezyki' => ['filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                'flags' => FILTER_REQUIRE_ARRAY],
            'radio1' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ];
        $dane = filter_input_array(INPUT_POST, $args);
        var_dump($dane);
        $errors = "";
        foreach ($dane as $key => $val) {
            if ($val === false or $val === NULL) {
                $errors .= $key . " ";
            }
        }
        if ($errors === "") {
            $arrayData = "";
            foreach ($dane as $key => $val) {
                if ($arrayData !== "") {
                    $arrayData .= ", ";
                }
                if (is_array($val)) {
                    $to_string = implode(",", $val);
                    $val = $to_string;
                }
                $arrayData .= "'" . htmlspecialchars($val) . "'";
            }
            $sql = "INSERT INTO `klienci` VALUES(NULL, $arrayData)";
            $bd->insert($sql);
        } else {
            echo "<br>Nie poprawnie dane: " . $errors;
        }
    }

    function statsBD($bd) {
        $tbl = array();
        $sql = "SELECT `Zamowienie` FROM `klienci`.`klienci`";
        $result = $this->mysqli->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $array = explode(",", $row["Zamowienie"]);
                foreach ($array as $key => $val) {
                    if ($tbl["$val"] ?? null) {
                        $tbl["$val"]++;
                    } else {
                        $tbl["$val"] = 1;
                    }
                }
            }
        } else {
            echo "0 results";
        }
        $result->close();
        foreach ($tbl as $key => $value) {
            echo $key . ": " . $value . "<br>";
        }
    }

    public function selectUser($login, $passwd, $tabela) {
        //parametry $login, $passwd , $tabela – nazwa tabeli z użytkownikami
        //wynik – id użytkownika lub -1 jeśli dane logowania nie są poprawne
        $id = -1;
        $sql = "SELECT * FROM $tabela WHERE userName='$login'";
        if ($result = $this->mysqli->query($sql)) {
            $ile = $result->num_rows;
            if ($ile == 1) {
                $row = $result->fetch_object(); //pobierz rekord z użytkownikiem
                $hash = $row->passwd; //pobierz zahaszowane hasło użytkownika
                //sprawdź czy pobrane hasło pasuje do tego z tabeli bazy danych:
                if (password_verify($passwd, $hash))
                    $id = $row->id; //jeśli hasła się zgadzają - pobierz id użytkownika
            }
        }
        return $id; //id zalogowanego użytkownika(>0) lub -1
    }

    public function returnObject($sql) {
        if ($result = $this->mysqli->query($sql)) {
            return $result->fetch_object();
        } else {
            return false;
        }
    }

}

?>