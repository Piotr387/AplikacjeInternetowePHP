<?php

class UserManager {

    function loginForm() {
        ?>
        <h2 class="text-uppercase">Zaloguj się</h2><br/>
        <form action="logowanie.php" id="logowanieForm" name="numberForm" method="post">
            <div class="row form-group">
                <div class="col-lg-1">
                    <i class="bi bi-person-circle fa-3x"></i>
                </div>
                <div class="col-lg input-group">
                    <input  class="form-control"
                            type="text" name="LogId" placeholder="Wproawdź identyfikator" 
                            required="required"/><br/>
                </div>
            </div><br/>
            <div class="row form-group">
                <div class="col-lg-1">
                    <i class="bi bi-lock-fill fa-3x"></i>
                </div>
                <div class="col-lg input-group">
                    <input  class="form-control"
                            type="password" name="LogPassword" placeholder="Wproawdź hasło" 
                            required="required"/><br/>
                </div>
            </div><br/>
            <div id="searchResult"></div>
            <button class="btn btn-danger btn-xl text-uppercase" data-bs-dismiss="modal" type="button" onclick="location.href = 'index.php'">
                <i class="fas fa-times me-1"></i>
                WRÓĆ
            </button>
            <button class="btn btn-success btn-xl text-uppercase" type="submit" value="Zaloguj" name="Zaloguj">
                <i class="bi bi-box-arrow-in-right"></i>
                Zaloguj się
            </button>
        </form> <?php
    }

    function login($db) {
        $args = ['LogId' => FILTER_SANITIZE_ADD_SLASHES,
            'LogPassword' => FILTER_SANITIZE_ADD_SLASHES
        ];
        $dane = filter_input_array(INPUT_POST, $args);
        $login = $dane["LogId"];
        $passwd = $dane["LogPassword"];
        $userId = $db->selectUser($login, $passwd, "users");
        if ($userId >= 0) { //Poprawne dane
            //rozpocznij sesję zalogowanego użytkownika
            //usuń wszystkie wpisy historyczne dla użytkownika o $userId
            //ustaw datę - format("Y-m-d H:i:s");
            //pobierz id sesji i dodaj wpis do tabeli logged_in_users
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $sesionID = session_id();
            $checkId = $this->getLoggedInUser($db, $sesionID);
            if ($checkId != -1) {
                $sql = "DELETE FROM `logged_in_users` WHERE `logged_in_users`.`sessionId` = '$sesionID'";
                $db->delete($sql);
            }
            $date = new DateTime('NOW');
            $sql = "INSERT INTO `logged_in_users` VALUES ('$sesionID', '$userId', '" . date_format($date, 'Y-m-d H:i:s') . "')";
            $db->insert($sql);
        }
        return $userId;
    }

    function logout($db) {
        //pobierz id bieżącej sesji (pamiętaj o session_start()
        //usuń sesję (łącznie z ciasteczkiem sesyjnym)
        //usuń wpis z id bieżącej sesji z tabeli logged_in_users
        session_start();
        $sesionID = session_id();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        session_destroy();
        $db->delete("DELETE FROM `logged_in_users` WHERE `logged_in_users`.`sessionId` = '$sesionID'");
    }

    function getLoggedInUser($db, $sessionId) {
        $result = $db->getMysqli()->query("SELECT `userId` FROM `logged_in_users` WHERE `sessionId` = '$sessionId'");
        $arr = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($arr, $row);
        }
        if (!empty($arr)) { //Poprawne dane
            $userId = (int) $arr[0]['userId'];
            return $userId;
        } else {
            return -1;
        }
//wynik $userId - znaleziono wpis z id sesji w tabeli logged_in_users
//wynik -1 - nie ma wpisu dla tego id sesji w tabeli logged_in_users
    }

    function getUserStatus($db, $userId) {
        $result = $db->getMysqli()->query("SELECT `status` FROM `users` WHERE `id` = '$userId'");
        $arr = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($arr, $row);
        }
        if (!empty($arr)) { //Poprawne dane
            $status = (int) $arr[0]['status'];
            return $status;
        } else {
            return -1;
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

    function getUserFirstLogin($db, $userId) {
        $sql = "SELECT * FROM `users` WHERE `id` = $userId";
        $firstLog = 0;
        if ($result = $db->getMysqli()->query($sql)) {
            $ile = $result->num_rows;
            if ($ile == 1) {
                $row = $result->fetch_object();
                $firstLog = $row->firstlog;
            }
        }
        return $firstLog;
    }

    function buildPasswordChange($cel) {
        ?>


        <form action="<?php echo $cel ?>" id="logowanieForm" name="numberForm" method="post">
            <div class="row form-group">
                <div class="col-lg-1">
                    <i class="bi bi-lock-fill fa-2x"></i>
                </div>
                <div class="col-lg input-group">
                    <input  class="form-control"
                            type="password" name="LogPasswordOld" placeholder="Wprowadź stare hasło..." 
                            required="required"/><br/>
                </div>
            </div><br/>
            <div class="row form-group">
                <div class="col-lg-1">
                    <i class="bi bi-lock-fill fa-2x"></i>
                </div>
                <div class="col-lg input-group">
                    <input  class="form-control"
                            type="password" name="LogPasswordNew" placeholder="Wprowadź nowe hasło..." 
                            required="required"/><br/>
                </div>
            </div><br/>
            <div class="row form-group">
                <div class="col-lg-1">
                    <i class="bi bi-lock-fill fa-2x"></i>
                </div>
                <div class="col-lg input-group">
                    <input  class="form-control"
                            type="password" name="LogPasswordNewCheck" placeholder="Powtorz nowe hasło..." 
                            required="required"/><br/>
                </div>
            </div><br/>
            <div id="searchResult"></div>
            <button class="btn btn-danger btn-l text-uppercase" data-bs-dismiss="modal" type="button" onclick="location.href = 'index.php'">
                <i class="fas fa-times me-1"></i>
                WRÓĆ
            </button>
            <button class="btn btn-success btn-l text-uppercase" type="submit" value="changePass" name="changePass">
                <i class="bi bi-box-arrow-in-right"></i>
                Zmień hasło
            </button>
        </form>
        <?php
    }

    function zmienHaslo($db, $userId) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $args = ['LogPasswordOld' => FILTER_SANITIZE_ADD_SLASHES,
            'LogPasswordNew' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => "/.{6,25}/"]],
            'LogPasswordNewCheck' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => "/.{6,25}/"]]
        ];
        $dane = filter_input_array(INPUT_POST, $args);
        $errors = "";
        foreach ($dane as $key => $val) {
            if ($val === false or $val === NULL) {
                $errors .= $key . " ";
            }
        }
        if ($errors === "") {
            $passwdOld = $dane["LogPasswordOld"];
            $passwdNew = $dane["LogPasswordNew"];
            $passwdNewCheck = $dane["LogPasswordNewCheck"];
            if ($passwdNew == $passwdNewCheck) {
                $sql = "SELECT * FROM `users` WHERE `id` = $userId";
                if ($result = $db->getMysqli()->query($sql)) {
                    $ile = $result->num_rows;
                    if ($ile == 1) {
                        $row = $result->fetch_object(); //pobierz rekord z użytkownikiem
                        $hash = $row->passwd; //pobierz zahaszowane hasło użytkownika
                        //sprawdź czy pobrane hasło pasuje do tego z tabeli bazy danych:
                        if (password_verify($passwdOld, $hash)) {
                            $hashedNew = password_hash($passwdNew, PASSWORD_DEFAULT);
                            $sql2 = "UPDATE `users` SET `firstLog` = '1', `passwd` = '$hashedNew' WHERE `users`.`id` = $userId ";
                            $db->getMysqli()->query($sql2);
                            ?>
                            <h2 class="text-uppercase">Pomyślnie zmieniono hasło!</h2><br/>
                            <?php
                        } else {
                            ?>
                            <h2 class="text-uppercase">Błędne stare hasło!</h2><br/>
                            <?php
                        }
                    }
                }
            } else {
                ?>
                <h2 class="text-uppercase">Nowe hasła nie zgadzają się!</h2><br/>
                <?php
            }
        } else {
            ?>
            <h2 class="text-uppercase">Nowe hasło jest za krótkie co najmniej 6 znaków!</h2><br/>
            <?php
        }
    }

}
