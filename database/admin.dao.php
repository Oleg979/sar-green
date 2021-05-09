<?php
// Добавить дерево или кустарник
function addTreeOrShrub($data, $treeImage, $leafImage) {
    if(strlen($data["recommendationId"]) == 0) {
        $data["recommendationId"] = "null";
    }
    $sql = "call insertDataTreeOrShrub(".$data["mainObjectId"].","
        .$data["treeOrShrubLifeStatusCategoryId"].",".$data["lifeFormId"].","
        .$data["specieId"].",".$data["plantingType"].",".$data["siteNumber"].","
        .$data["currentAge"].",".$data["landingAge"].","
        .$data["heig"]."::real,'".$data["inventDate"]."'::varchar,'".$data["landingDate"]."'::varchar,'".$data["characteris"]."'::text,"
        .$data["recommendationId"].",".$data["diameterAtHeight13"]."::real,".$data["lat"]."::double precision,"
        .$data["long"]."::double precision, '".$treeImage."'::varchar,'".$leafImage."'::varchar);";
    writeToServerLog($sql);
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}
// Обновить дерево или кустарник
function updateTreeOrShrub($data, $treeImage, $leafImage) {
    if($treeImage != null and strlen($treeImage) > 3) {
        writeToServerLog("Updating tree image...");
        $data["imagePath"] = $treeImage;
    }
    if($leafImage != null and strlen($leafImage) > 3) {
        writeToServerLog("Updating leaf image...");
        $data["leafImagePath"] = $leafImage;
    }
    $sql = "call UpdateDataTreeOrShrub(".$data["id"].",".$data["mainObjectId"].","
        .$data["treeOrShrubLifeStatusCategoryId"].",".$data["lifeFormId"].","
        .$data["specieId"].",".$data["plantingType"].",".$data["siteNumber"].","
        .$data["plantNumber"].",".$data["currentAge"].",".$data["landingAge"].","
        .$data["heig"]."::real,'".$data["inventDate"]."'::varchar,'".$data["landingDate"]."'::varchar,'".$data["characteris"]."'::text,"
        .$data["recommendationId"].",".$data["diameterAtHeight13"]."::real,".$data["lat"]."::double precision,"
        .$data["long"]."::double precision, '".$data["imagePath"]."'::varchar,'".$data["leafImagePath"]."'::varchar);";
    writeToServerLog($sql);
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}
function updateTreesAndShrubsCoords($data) {
    $sql = "call UpdateDataTreesAndShrubsCoordinates (".$data["id"].",".$data["lat"]."::double precision,".$data["long"]."::double precision)";
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}
function getMainObjectIdByCadastralNumber($id) {
    $sql = 'SELECT m."mainObjectId" FROM "mainObjects" m JOIN "passportPlantationObjects" p ON p."ID_Object" = m."mainObjectId" WHERE p." cadastralNumber" = '.$id.'::varchar';  
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return $row["mainObjectId"];
    }
}
// Добавить цветок или газон
function addFlowerOrGarden($data) {
    if(count($data["flowersgardencomposit"]) == 0) {
        $data["flowersgardencomposit"] = "{}";
    } else if(count($data["flowersgardencomposit"]) == 1) {
        $data["flowersgardencomposit"] = "{".$data["flowersgardencomposit"][0]."}";
    } else {
        $data["flowersgardencomposit"] = "{".implode(",", $data["flowersgardencomposit"])."}";
    }
    $sql = "call insert_dataFlowerGardens(".$data["flowerGardenTypeId"].","
        .$data["flowerGardenLifeStatusCategoryId"].",".$data["flowerGardenGrassingTypeID"].","
        .$data["siteNumber"].",".$data["areaVal"].",'".$data["dat"]."'::varchar,'"
        .$data["recommend"]."','".$data["statecharacteristic"]."','".$data["flowersgardencomposit"]
        ."'::integer[],".$data["mainObjectId"].");";
    writeToServerLog($sql);
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    } 
}
// Обновить цветок или газон
function updateFlowerOrGarden($data) {
    $data["flowersgardencomposit"] = "{".implode(",", $data["flowersgardencomposit"])."}";
    $sql = "call updateDataFlowerGardens(".$data["flowerGardenId"].",".$data["flowerGardenTypeId"].","
        .$data["flowerGardenLifeStatusCategoryId"].",".$data["flowerGardenGrassingTypeID"].","
        .$data["siteNumber"].",".$data["areaVal"].",'".$data["dat"]."'::varchar,'"
        .$data["recommend"]."','".$data["statecharacteristic"]."','".$data["flowersgardencomposit"]
        ."'::integer[],".$data["mainObjectId"].");";
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    } 
}

// Добавить паспорт
function addPassport($data, $schemaPath) {
    $sql = "call insert_dataPassportPlantationObject('".$data["cadastralNumber"]."'::varchar,"
        .$data["sitesCount"].",'".$data["dateObjCreate"]."'::varchar,"
        .$data["landscapingCategoryId"].",'".$schemaPath."'::varchar,"
        .$data["asphaltM"].",".$data["gravelM"].",".$data["slabsM"].",".$data["primingM"].","
        .$data["buildingsM"].",".$data["pondsM"].",".$data["ID_Object"].","
        .$data["streetLength"].",".$data["avgPassageWidth"].",".$data["totalObjArea"].",".$data["anothrM"].");";
    writeToServerLog($sql);
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// Обновить паспорт
function updatePassport($data, $schemaPath) {
    if($schemaPath) {
        $data["schemaPath"] = $schemaPath;
    }
    $sql = "call updateDataPassportPlantationObject(".$data["id"].",'".$data["cadastralNumber"]."'::varchar,"
        .$data["sitesCount"].",'".$data["dateObjCreate"]."'::varchar,"
        .$data["landscapingCategoryId"].",'".$data["schemaPath"]."'::varchar,"
        .$data["asphaltM"].",".$data["gravelM"].",".$data["slabsM"].",".$data["primingM"].","
        .$data["buildingsM"].",".$data["pondsM"].",".$data["ID_Object"].","
        .$data["streetLength"].",".$data["avgPassageWidth"].",".$data["totalObjArea"].",".$data["anothrM"]
        .");";
    writeToServerLog($sql);
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// Удалить данные из словарных таблиц
function deleteGlossaryTable($tableName, $id) {
    $sql = "call deleteIdData$tableName($id)";
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

function disableDelete($tableName) {
    $sql = 'update "tableBools" set "'.$tableName.'" = false';
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// Добавить данные в словарные таблицы
function addGlossaryTable($tableName, $name) {
    $sql = "call insertData$tableName('$name')";
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// Добавить данные в словарные таблицы массивом
function addGlossaryTableByArray($tableName, $data) {
    for ($i = 0; $i < count($data); $i++) {
        $sql = "call insertData$tableName('$data[$i]')";
        $stmt = Connection::get()->query($sql);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            var_dump($row);
        }
    } 
}

// Изменить данные в словарных таблицах
function changeGlossaryTable($tableName, $data) {
    $id = $data["id"];
    $name = $data["name"];
    $sql = "call updateData$tableName($id, '$name'::varchar)";
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// Добавить данные о главном объекте
function addMainObject($data) {
    $sql = "call insertDataMainObjects('".$data["name"]."',".$data["balanceHolderId"].",".$data["mainObjectTypeId"].",".$data["districtId"].");";
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// Обновить данные о главном объекте
function updateMainObject($data) {
    $sql = "call updateDataMainObject(".$data["id"].",'".$data["name"]."'::varchar,".$data["balanceHolderId"].",".$data["mainObjectTypeId"].",".$data["districtId"].");";
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// Добавить данные о главном объекте в массиве
function addMainObjectArray($data) {
    for ($i = 0; $i < count($data); $i++) {
        $object = $data[$i];
        $sql = "call insertDataMainObjects('".$object["name"]."',".$object["balanceHolderId"].",".$object["mainObjectTypeId"].",".$object["districtId"].");";
        $stmt = Connection::get()->query($sql);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            var_dump($row);
        }
    }
}

// Добавить данные о садовом виде
function addGardenSpecie($data) {
    $sql = "call insertDataGardenSpecies('".$data["name"]."'::varchar);";
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// Обновить данные о садовом виде
function updateGardenSpecie($data) {
    $sql = "call updateDataGardenSpecies(".$data["id"].",'".$data["name"]."'::varchar);";
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// Удалить данные о садовом виде
function deleteGardenSpecie($data) {
    $sql = "call deleteIdDataGardenSpecies(".$data["id"].");";
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// Добавить данные о виде
function addSpecie($data) {
    $sql = "call insertDataSpecies('".$data["name"]."'::varchar,".$data["aboveSpec"].");";
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// Обновить данные о виде
function updateSpecie($data) {
    $sql = "call updateDataSpecies(".$data["id"].",'".$data["name"]."'::varchar,".$data["aboveSpec"].");";
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// Добавить данные о виде массивом
function addSpecieArray($data) {
    for ($i = 0; $i < count($data); $i++) {
        $object = $data[$i];
        $sql = "call insertDataSpecies('".$object["name"]."'::varchar,".$object["aboveSpec"].");";
        $stmt = Connection::get()->query($sql);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            var_dump($row);
        }
    }
}

// Удалить рекомендацию по айди
function deleteRecommendById($id) {
    $sql = "call deleteDataCutRecomendById ($id);";
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// Обновить рекомендацию по айди
function updateRecommendById($id, $data) {
    $name = $data["name"];
    $clarification = $data["clarification"];
    $sql = "call UpdateDataCutRecomendById($id, '$name'::varchar, '$clarification'::varchar)";
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// Добавить рекомендацию
function addRecommend($data) {
    $name = $data["name"];
    $clarification = $data["clarification"];
    $sql = "call insertDataCutRecomend('$name'::varchar, '$clarification'::varchar);";
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// Запрещено ли удаление
function isDeletionProhibited($tableName) {
    $sql = 'select "'.$tableName.'" from "tableBools"';
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return $row[$tableName];
    }
}

// Добавить рекомендацию массивом
function addRecommendArray($data) {
    for ($i = 0; $i < count($data); $i++) {
        $name = $data[$i]["name"];
        $clarification = $data[$i]["clarification"];
        $sql = "call insertDataCutRecomend('$name'::varchar, '$clarification'::varchar);";
        $stmt = Connection::get()->query($sql);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            var_dump($row);
        }
    }
}