<?php
// Роутер для справочной информации
function route($method, $urlData, $formData) {
    header('Content-Type: application/json');

    // Получение информации о конкретном типе объектов
    // GET /glossary/{type}
    if ($method === 'GET' && count($urlData) === 1) {
        $typeName = $urlData[0];
        $result = getGlossaryData($typeName);
        echo json_encode($result);
        return;
    }

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'У нас нет такого запроса. Проверьте УРЛ.'
    ));
}
