<?php
// Получить список пользователей
function getUsers() {
    $stmt = Connection::get()->query('select * from users');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}
// Удалить пользователя
function deleteUser($id) {
    $stmt = Connection::get()->query('delete from users where id = '.$id);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}
// Выдать пользователю права админа
function grantAdminRights($id) {
    $stmt = Connection::get()->query('update users set isadmin = TRUE where id = '.$id);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}
// Лишить пользователя прав админа
function revokeAdminRights($id) {
    $stmt = Connection::get()->query('update users set isadmin = FALSE where id = '.$id);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}
// Зарегистрировать нового пользователя
function addUser($name, $pass) {
    $hashedPass = md5(md5(trim($pass)));
    $stmt = Connection::get()->query("insert into users (username, password) values ('".$name."', '".$hashedPass."')");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}
// Авторизовать пользователя
function auth($name, $pass) {
    $stmt = Connection::get()->query("select * from users where username = '".$name."'");
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    $user = $result[0];
    if($user) {
        if($user["password"] == md5(md5(trim($pass)))) {
            $hash = md5(generateCode(10));
            $stmt = Connection::get()->query("update users set hash = '".$hash."' where username = '".$name."'");
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                var_dump($row);
            }
            setcookie("id", $user["id"], time()+60*60*24*30, "/");
            setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true);
            return (["success" => true, "isAdmin" => $user["isadmin"]]);
        } else {
            return (["success" => false, "error" => "Wrong password"]);
        }
    }
    return (["success" => false, "error" => "User does not exits"]);
}
// Разлогинить пользователя
function logout() {
    if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true);
        return (["success" => true]); 
    } else {
        return (["success" => false, "error" => "No Cookies"]);
    }
}
// Вспомогательная функция для генерация случайной соли хеша
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}