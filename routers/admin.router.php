<?php
// Роутер для административных операций
function route($method, $urlData, $formData) {
    header('Content-Type: application/json');

    // Пишем в логи, чтобы потом удобнее было отлаживать
    $file = 'logs/admin.log';
    $current = file_get_contents($file);
    $current .= date("M,d,Y h:i:s A")."\n";
    $current .= $urlData[0]."\n";
    $current .= json_encode($formData);
    $current .= "\n\n";
    file_put_contents($file, $current);

    // Добавить дерево или кустарник
    // POST /admin/addTreeOrShrub
    if ($method === 'POST' && count($urlData) === 1 && $urlData[0] === "addTreeOrShrub") {
        $json = file_get_contents($_FILES['jsonbody']["tmp_name"]);
        writeToServerLog($json);
        $decoded_json = json_decode($json, true);
        $treeImage = uploadTreeImage($decoded_json);
        $leafImage = uploadLeafImage();
        $result = addTreeOrShrub($decoded_json, $treeImage, $leafImage);
        echo json_encode([
            "success" => true,
            "filename" => $treeImage
        ]);
        return;
    }

    // Обновить дерево или кустарник
    // POST /admin/updateTreeOrShrub
    if ($method === 'POST' && count($urlData) === 1 && $urlData[0] === "updateTreeOrShrub") {
        $json = file_get_contents($_FILES['jsonbody']["tmp_name"]);
        writeToServerLog($json);
        $decoded_json = json_decode($json, true);
        $treeImage = uploadTreeImage($decoded_json);
        $leafImage = uploadLeafImage();
        writeToServerLog($treeImage);
        writeToServerLog($leafImage);
        $result = updateTreeOrShrub($decoded_json, $treeImage, $leafImage);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Добавить цветок или газон
    // POST /admin/addFlowerOrGarden
    if ($method === 'POST' && count($urlData) === 1 && $urlData[0] === "addFlowerOrGarden") {
        $result = addFlowerOrGarden($formData);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Обновить координаты
    // POST /admin/updateTreesAndShrubsCoords
    if ($method === 'POST' && count($urlData) === 1 && $urlData[0] === "updateTreesAndShrubsCoords") {
        $result = updateTreesAndShrubsCoords($formData);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Обновить цветок или газон
    // POST /admin/updateFlowerOrGarden
    if ($method === 'POST' && count($urlData) === 1 && $urlData[0] === "updateFlowerOrGarden") {
        $result = updateFlowerOrGarden($formData);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Добавить паспорт
    // POST /admin/addPassport
    if ($method === 'POST' && count($urlData) === 1 && $urlData[0] === "addPassport") {
        $json = file_get_contents($_FILES['jsonbody']["tmp_name"]);
        writeToServerLog($json);
        $decoded_json = json_decode($json, true);
        $schemaPath = uploadSchemaImage();
        $result = addPassport($decoded_json, $schemaPath);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Обновить паспорт
    // POST /admin/updatePassport
    if ($method === 'POST' && count($urlData) === 1 && $urlData[0] === "updatePassport") {
        $json = file_get_contents($_FILES['jsonbody']["tmp_name"]);
        writeToServerLog($json);
        $decoded_json = json_decode($json, true);
        $schemaPath = uploadSchemaImage();
        $result = updatePassport($decoded_json, $schemaPath);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Удалить объект из связанной таблицы
    // GET /deleteGlossary/{tableName}/{id}
    if ($method === 'GET' && count($urlData) === 3 && $urlData[0] === "deleteGlossary") {
        $result = deleteGlossaryTable($urlData[1], $urlData[2]);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Добавить из связанной таблицы
    // POST /addGlossary/{tableName}
    if ($method === 'POST' && count($urlData) === 2 && $urlData[0] === "addGlossary") {
        $result = addGlossaryTable($urlData[1], $formData["name"]);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Добавить из связанной таблицы массивом
    // POST /addGlossaryArray/{tableName}
    if ($method === 'POST' && count($urlData) === 2 && $urlData[0] === "addGlossaryArray") {
        $result = addGlossaryTableByArray($urlData[1], $formData["names"]);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Изменить справочник
    // POST /updateGlossary/{tableName}
    if ($method === 'POST' && count($urlData) === 2 && $urlData[0] === "updateGlossary") {
        $result = changeGlossaryTable($urlData[1], $formData);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }
    
    // Добавить главный объект
    // POST /addMainObject
    if ($method === 'POST' && count($urlData) === 1 && $urlData[0] === "addMainObject") {
        $result = addMainObject($formData);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Обновить главный объект
    // POST /updateMainObject
    if ($method === 'POST' && count($urlData) === 1 && $urlData[0] === "updateMainObject") {
        $result = updateMainObject($formData);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }
    
    // Добавить главный объект массивом
    // POST /addMainObjectArray
    if ($method === 'POST' && count($urlData) === 1 && $urlData[0] === "addMainObjectArray") {
        $result = addMainObjectArray($formData["objects"]);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }
    
    // Добавить вид
    // POST /addSpecie
    if ($method === 'POST' && count($urlData) === 1 && $urlData[0] === "addSpecie") {
        $result = addSpecie($formData);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Обновить вид
    // POST /updateSpecie
    if ($method === 'POST' && count($urlData) === 1 && $urlData[0] === "updateSpecie") {
        $result = updateSpecie($formData);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Добавить вид массивом
    // POST /addSpecieArray
    if ($method === 'POST' && count($urlData) === 1 && $urlData[0] === "addSpecieArray") {
        $result = addSpecieArray($formData["objects"]);
        echo json_encode([
            "success" => true,
        ]);
        return;
    } 

    // Удалить рекомендацию
    // GET /deleteRecommend/{id}
    if ($method === 'GET' && count($urlData) === 2 && $urlData[0] === "deleteRecommend") {
        $result = deleteRecommendById($urlData[1]);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Проверить, можно ли удалять
    // GET /canDelete/{tableName}
    if ($method === 'GET' && count($urlData) === 2 && $urlData[0] === "canDelete") {
        $result = isDeletionProhibited($urlData[1]);
        echo json_encode([
            "canDelete" => $result,
        ]);
        return;
    }

    // Проверить, можно ли удалять
    // GET /disableDelete/{tableName}
    if ($method === 'GET' && count($urlData) === 2 && $urlData[0] === "disableDelete") {
        $result = disableDelete($urlData[1]);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Обновить рекомендацию
    // POST /updateRecommend/{id}
    if ($method === 'POST' && count($urlData) === 2 && $urlData[0] === "updateRecommend") {
        $result = updateRecommendById($urlData[1], $formData);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Добавить рекомендацию
    // POST /addRecommend
    if ($method === 'POST' && count($urlData) === 1 && $urlData[0] === "addRecommend") {
        $result = addRecommend($formData);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Добавить рекомендацию массивом
    // POST /addRecommendArray
    if ($method === 'POST' && count($urlData) === 1 && $urlData[0] === "addRecommendArray") {
        $result = addRecommendArray($formData["objects"]);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Получить список пользователей
    // GET /users
    if ($method === 'GET' && count($urlData) === 1 && $urlData[0] === "users") {
        $result = getUsers();
        echo json_encode($result);
        return;
    }

    // Выдать пользователю права админа
    // GET /users/grant/{userId}
    if ($method === 'GET' && count($urlData) === 3 && $urlData[0] === "users" && $urlData[1] === "grant") {
        $result = grantAdminRights($urlData[2]);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Лишить пользователя прав админа
    // GET /users/revoke/{userId}
    if ($method === 'GET' && count($urlData) === 3 && $urlData[0] === "users" && $urlData[1] === "revoke") {
        $result = revokeAdminRights($urlData[2]);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Удалить пользователя
    // GET /users/delete/{userId}
    if ($method === 'GET' && count($urlData) === 3 && $urlData[0] === "users" && $urlData[1] === "delete") {
        $result = deleteUser($urlData[2]);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Добавить пользователя
    // POST /users/add
    if ($method === 'POST' && count($urlData) === 2 && $urlData[0] === "users" && $urlData[1] === "add") {
        $result = addUser($formData["name"], $formData["password"]);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'У нас нет такого запроса. Проверьте УРЛ.'
    ));
}
