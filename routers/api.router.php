<?php
// Роутер для документации по API
function route($method, $urlData, $formData) {
    header('Content-Type: text/html');

    // Получение документации по API
    // GET /api
    if ($method === 'GET' && count($urlData) === 0) {
        include("templates/api-doc.html");
        return;
    }

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'У нас нет такого запроса. Проверьте УРЛ.'
    ));
}
