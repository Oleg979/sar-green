<?php
// Загрузка файлов на сервер
function upload() {
    $uploaddir = 'uploads/';
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
    move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
    return $_FILES['userfile']['name'];
}
function uploadTreeImage($data) {
    writeToServerLog($_FILES['userfile']['name']);
    $extension = explode(".", $_FILES['userfile']['name'])[1];
    if(strlen($extension) === 0) {
        writeToServerLog("photo is not updated");
        return $data["imagepath"];
    }
    $plantNumber = $data["plantNumber"];
    if(!$plantNumber) {
        writeToServerLog("plant number is not provided");
        $plantNumber = time();
    }
    $object = getMainObjectById($data["mainObjectId"]);
    $name = $object['name'];
    $name = $name."-".$data["siteNumber"]."-".$plantNumber.".".$extension;
    writeToServerLog($name);
    $uploaddir = 'uploads/';
    $uploadfile = $uploaddir . basename($name);
    move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
    return $name;
}
function uploadLeafImage() {
    $uploaddir = 'uploads/';
    $uploadfile = $uploaddir . basename($_FILES['leafimg']['name']);
    move_uploaded_file($_FILES['leafimg']['tmp_name'], $uploadfile);
    return $_FILES['leafimg']['name'];
}
function uploadSchemaImage() {
    $uploaddir = 'uploads/';
    $uploadfile = $uploaddir . basename($_FILES['schemaimg']['name']);
    move_uploaded_file($_FILES['schemaimg']['tmp_name'], $uploadfile);
    return $_FILES['schemaimg']['name'];
}
?>