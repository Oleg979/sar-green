<?php

// Роутер для справочной информации
function route($method, $urlData, $formData) {
    header('Content-Type: application/json');

    // Получение информации о деревьях и кустарниках
    // GET /geo/treesAndShrubs
    if ($method === 'GET' && count($urlData) === 1 && $urlData[0] === "treesAndShrubs") {
        $result = getTreesAndShrubs();
        echo json_encode($result);
        return;
    }

    // Получение информации о деревьях
    // GET /geo/trees
    if ($method === 'GET' && count($urlData) === 1 && $urlData[0] === "trees") {
        $result = getTrees();
        echo json_encode($result);
        return;
    }

    // Получение информации о деревьях с пагинацией
    // GET /geo/trees/page/${pageId}
    if ($method === 'GET' && count($urlData) === 3 && $urlData[0] === "trees" && $urlData[1] === "page") {
        $pageId = $urlData[2];
        $result = getTreesWithPagination($pageId);
        echo json_encode($result);
        return;
    }

    // Получение информации о деревьях
    // GET /geo/trees/count
    if ($method === 'GET' && count($urlData) === 2 && $urlData[0] === "trees" && $urlData[1] === "count") {
        $result = getTreesCount();
        echo json_encode($result);
        return;
    }

    // Получение статистики по деревьям
    // GET /geo/trees/stat
    if ($method === 'GET' && count($urlData) === 2 && $urlData[0] === "trees" && $urlData[1] === "stat") {
        $result = getTreesStat();
        echo json_encode($result);
        return;
    }

    // Получение информации о цветах и газонах
    // GET /geo/flowersAndGardens
    if ($method === 'GET' && count($urlData) === 1 && $urlData[0] === "flowersAndGardens") {
        $result = getFlowersAndGardens();
        echo json_encode($result);
        return;
    }

    // Получение информации о цветах
    // GET /geo/flowers
    if ($method === 'GET' && count($urlData) === 1 && $urlData[0] === "flowers") {
        $result = getFlowers();
        echo json_encode($result);
        return;
    }

    // Получение информации о газонах
    // GET /geo/gardens
    if ($method === 'GET' && count($urlData) === 1 && $urlData[0] === "gardens") {
        $result = getGardens();
        echo json_encode($result);
        return;
    }

    // Получение информации о кустарниках
    // GET /geo/main
    if ($method === 'GET' && count($urlData) === 1 && $urlData[0] === "main") {
        $result = getAllObjects();
        echo json_encode($result);
        return;
    }

    // Получение информации обо всех гео-объектах
    // GET /geo/all
    if ($method === 'GET' && count($urlData) === 1 && $urlData[0] === "all") {
        $result = getShrubs();
        echo json_encode($result);
        return;
    }

    // Получение информации обо всех паспортах
    // GET /geo/passports
    if ($method === 'GET' && count($urlData) === 1 && $urlData[0] === "passports") {
        $result = getPassports();
        echo json_encode($result);
        return;
    }

    // Получение координат объекта по его ID
    // GET /geo/coords/{id}
    if ($method === 'GET' && count($urlData) === 2 && $urlData[0] === "coords") {
        $id = (int)$urlData[1];
        $result = getCoordinatesById($id);
        echo json_encode($result);
        return;
    }
    
    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'У нас нет такого запроса. Проверьте УРЛ.'
    ));
}
