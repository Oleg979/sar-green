<?php
// Скрипт проверки
function executeAuthInterceptor() {
    header('Content-Type: application/json');

    if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
        $stmt = Connection::get()->query("select * from users where id = ".$_COOKIE['id']);
        $result = [];
        while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
            for ($i = 0; $i < count($rows); $i++) {
                $row = $rows[$i];
                $result[$i] = $row;
            }
        }
        if($_COOKIE['hash'] == $result[0]["hash"]) {
            return (["success" => true]);
        } else {
            setcookie("id", "", time() - 3600*24*30*12, "/");
            setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true);
            return (["success" => false, "error" => "Not Authorized"]);
        }
    } else {
        return (["success" => false, "error" => "Not Authorized"]);
    }
}