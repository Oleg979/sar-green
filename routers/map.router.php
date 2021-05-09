<?php

// Роутер для справочной информации
function route($method, $urlData, $formData) {
    header('Content-Type: application/json');

    // Получение информации о деревьях
    // GET /map/trees
    if ($method === 'GET' && count($urlData) === 1 && $urlData[0] === "trees") {
        $result = getTreesMarkers();
        echo json_encode($result);
        return;
    }

    // Получение информации о деревe
    // GET /map/tree/id
    if ($method === 'GET' && count($urlData) === 2 && $urlData[0] === "tree") {
        $result = getTreeInfo($urlData[1]);
        echo json_encode($result);
        return;
    }

    // Получение фото дерева
    // GET /map/photo/{id}
    if ($method === 'GET' && count($urlData) === 2 && $urlData[0] === "photo") {
        $result = getPhotoById($urlData[1]);
        echo json_encode($result);
        return;
    }

    // Получение колва деревьев на участке
    // GET /map/count/trees/{id}
    if ($method === 'GET' && count($urlData) === 3 && $urlData[0] === "count" && $urlData[1] === "trees") {
        $result = getTreesCountByObjectId($urlData[2]);
        echo json_encode($result);
        return;
    }

    // Получение колва кустов на участке
    // GET /map/count/shrubs/{id}
    if ($method === 'GET' && count($urlData) === 3 && $urlData[0] === "count" && $urlData[1] === "shrubs") {
        $result = getShrubsCountByObjectId($urlData[2]);
        echo json_encode($result);
        return;
    }

    // Получение площади газона
    // GET /map/objects/{id}/lawn
    if ($method === 'GET' && count($urlData) === 3 && $urlData[0] === "objects" && $urlData[2] === "lawn") {
        $result = getLawnSquareByObjectId($urlData[1]);
        echo json_encode($result);
        return;
    }

    // Получение площади цветника
    // GET /map/objects/{id}/garden
    if ($method === 'GET' && count($urlData) === 3 && $urlData[0] === "objects" && $urlData[2] === "garden") {
        $result = getGardenSquareByObjectId($urlData[1]);
        echo json_encode($result);
        return;
    }

    // Получение объекта
    // GET /map/objects/{id}
    if ($method === 'GET' && count($urlData) === 2 && $urlData[0] === "objects") {
        $result = getMainObjectById($urlData[1]);
        echo json_encode($result);
        return;
    }

    // Получить паспорт по айди объекта
    // GET /map/passport/{id}
    if ($method === 'GET' && count($urlData) === 2 && $urlData[0] === "passport") {
        $result = getPassportByObjectId($urlData[1]);
        echo json_encode($result);
        return;
    }

    // Получить схему паспорта по айди объекта
    // GET /map/passport/{id}/schema
    if ($method === 'GET' && count($urlData) === 3 && $urlData[0] === "passport" && $urlData[2] === "schema") {
        $result = getPassportSchemaByObjectId($urlData[1]);
        echo json_encode($result);
        return;
    }

    // Получить максимального количества участков среди всех объектов
    // GET /map/maxSiteCount
    if ($method === 'GET' && count($urlData) === 1 && $urlData[0] === "maxSiteCount") {
        $result = getMaxSiteCount();
        echo json_encode($result);
        return;
    }

    // Получить данные о всех участках по айди объекта
    // GET /map/sites/{objectId}
    if ($method === 'GET' && count($urlData) === 2 && $urlData[0] === "sites") {
        $result = getAllAreasByObjectId($urlData[1]);
        echo json_encode($result);
        return;
    }

    // Запрос всех деревьев и кустарников по айди объекта и номеру участка
    // GET /map/trees/object/{objectId}/site/{siteNumber}
    if ($method === 'GET' && count($urlData) === 5 && $urlData[0] === "trees" && $urlData[1] === "object" && $urlData[3] === "site") {
        $result = getTreesAndShrubsByAreaId($urlData[2], $urlData[4]);
        echo json_encode($result);
        return;
    }

    // Запрос количества всех деревьев и кустарников по айди объекта и номеру участка
    // GET /map/trees/object/{objectId}/site/{siteNumber}/count
    if ($method === 'GET' && count($urlData) === 6 && $urlData[0] === "trees" && $urlData[1] === "object" && $urlData[3] === "site" && $urlData[5] === "count") {
        $result = getAmountTreesAndShrubsByAreaId($urlData[2], $urlData[4]);
        echo json_encode($result);
        return;
    }

    // Запрос количества всех цветников по айди объекта и номеру участка
    // GET /map/flowerGardens/object/{objectId}/site/{siteNumber}/count
    if ($method === 'GET' && count($urlData) === 6 && $urlData[0] === "flowerGardens" && $urlData[1] === "object" && $urlData[3] === "site" && $urlData[5] === "count") {
        $result = getFlowerGardensAmountByObjectIdAndSiteNumber($urlData[2], $urlData[4]);
        echo json_encode($result);
        return;
    }

    // Отфильтрованные деревья
    // POST /map/tree/filter/page/{pageId}
    if ($method === 'POST' && count($urlData) === 4 && $urlData[0] === "tree" && $urlData[1] === "filter" && $urlData[2] === "page") {
        $result = getFilteredTrees($formData, $urlData[3]);
        echo json_encode($result);
        return;
    }

    // Отфильтрованные цветники
    // POST /map/flowerGardens/filter
    if ($method === 'POST' && count($urlData) === 2 && $urlData[0] === "flowerGardens" && $urlData[1] === "filter") {
        $result = getFilteredFlowerGardens($formData);
        echo json_encode($result);
        return;
    }

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'У нас нет такого запроса. Проверьте УРЛ.'
    ));
}
