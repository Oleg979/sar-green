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
    $stmt = Connection::get()->query('update users set isAdmin = 1 where id = '.$id);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}
// Лишить пользователя прав админа
function revokeAdminRights($id) {
    $stmt = Connection::get()->query('update users set isAdmin = 0 where id = '.$id);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}
// Добавить нового пользователя
function addUser($name, $pass) {
    $stmt = Connection::get()->query('insert into users (username, password) values ('.$name.', '.$pass.')');
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}