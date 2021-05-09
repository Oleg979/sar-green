<?php

// Отключаем ворнинги
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

// Получение данных из тела запроса
function getFormData($method) {

    // GET или POST: данные возвращаем как есть
    if ($method === 'GET') return $_GET;
    if ($method === 'POST') {
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE);
        return $input;
    }

    // PUT, PATCH или DELETE
    $data = array();
    $exploded = explode('&', file_get_contents('php://input'));

    foreach($exploded as $pair) {
        $item = explode('=', $pair);
        if (count($item) == 2) {
            $data[urldecode($item[0])] = urldecode($item[1]);
        }
    }

    return $data;
}

// Разрешаем кому угодно выполнять запросы
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Access-Control-Allow-Headers: X-Requested-With");

// Определяем метод запроса
$method = $_SERVER['REQUEST_METHOD'];

if($method === "OPTIONS") {
    header("HTTP/1.1 200 OK");
    return;
}

// Получаем данные из тела запроса
$formData = getFormData($method);

// Разбираем url
$url = (isset($_GET['q'])) ? $_GET['q'] : '';
$url = rtrim($url, '/');
$urls = explode('/', $url);

// Определяем роутер и url data
$router = $urls[0];
$urlData = array_slice($urls, 1);

// Подключаем файл-роутер
include_once 'routers/' . $router . '.router.php';

// Подключаем фукнции базы данных
include_once 'database/connection.php';
include_once 'database/glossary.dao.php';
include_once 'database/geo.dao.php';
include_once 'database/debug.dao.php';
include_once 'database/admin.dao.php';

// Подключаем вспомогательные файлы
include_once "utils/upload.php";
include_once "utils/construct-query.php";
include_once "utils/log.php";

// Запускаем нужный роутер
route($method, $urlData, $formData);
