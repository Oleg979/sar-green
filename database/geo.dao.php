<?php
// Получить список деревьев и кустарников
function getTreesAndShrubs() {
    $stmt = Connection::get()->query('select * from treesandshrubsalldata ORDER BY "mainObjectId", "siteNumber", "plantNumber";');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}
// Получить фото
function getPhotoById($id) {
    $stmt = Connection::get()->query('SELECT "plantImagePath", "leafImagePath" FROM "treesandshrubsalldata" WHERE "treesAndShrubsId" = '.$id);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return $row;
    }
}
// Получить список деревьев
function getTrees() {
    $stmt = Connection::get()->query('select * from treesandshrubsalldataonlyfortrees');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}
// Деревья с пагинацией
function getTreesWithPagination($pageNumber) {
    $offset = 50 * $pageNumber;
    $stmt = Connection::get()->query('select * from treesandshrubsalldataonlyfortrees limit 50 offset '.$offset);
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}
// Количество дереьвев
function getTreesCount() {
    $stmt = Connection::get()->query('select count(*) from treesandshrubsalldataonlyfortrees');
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return $row;
    }
}
// Статистика по состоянию дереьвев
function getTreesStat() {
    $stmt_good = Connection::get()->query('select count(*) from treesandshrubsalldataonlyfortrees where "lifestatuscategory" LIKE \'%Хорошее%\'');
    $stmt_normal = Connection::get()->query('select count(*) from treesandshrubsalldataonlyfortrees where "lifestatuscategory" LIKE \'удовлетворительное%\'');
    $stmt_bad = Connection::get()->query('select count(*) from treesandshrubsalldataonlyfortrees where "lifestatuscategory" LIKE \'%неудовлетворительное%\'');
    $num_bad = 0;
    $num_good = 0;
    while($row = $stmt_good->fetch(PDO::FETCH_ASSOC)) {
        $num_good += $row["count"];
    }
    while($row = $stmt_normal->fetch(PDO::FETCH_ASSOC)) {
        $num_good += $row["count"];
    }
    while($row = $stmt_bad->fetch(PDO::FETCH_ASSOC)) {
        $num_bad += $row["count"];
    }
    return array(
        "bad" => $num_bad,
        "good" => $num_good
    );
}
// Получить список кустарников
function getShrubs() {
    $stmt = Connection::get()->query('select * from treesandshrubsalldataonlyforshrubs');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}
// Получить список цветников и газонов
function getFlowersAndGardens() {
    $stmt = Connection::get()->query('select * from flowerGardensAllData ORDER BY "mainObjecstId", "siteNumber";');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}
// Получить список цветников
function getFlowers() {
    $stmt = Connection::get()->query('select * from flowerGardensAllDataOnlyForFlower');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}
// Получить список газонов
function getGardens() {
    $stmt = Connection::get()->query('select * from flowerGardensAllDataOnlyForGardens');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}
// Получить данные по всем гео-объектам
function getAllObjects() {
    $stmt = Connection::get()->query('SELECT m."mainObjectsId", m."balanceHolderId", m."mainObjectTypeId", m."districtId", m."name", p."sitesCount" FROM "mainObjects" m LEFT JOIN "passportPlantationObjects" p ON p."ID_Object" = m."mainObjectsId"');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}
// Получить данные по всем гео-объектам
function getMainObjectById($id) {
    $stmt = Connection::get()->query('SELECT * FROM "mainObjects" WHERE "mainObjectsId" = '.$id);
    $result = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result = $row;
    }
    $stmt = Connection::get()->query('SELECT "sitesCount" FROM "passportPlantationObjects" WHERE "ID_Object" = '.$id);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result["sitesCount"] = $row["sitesCount"];
    }
    return $result;

}
// Получить паспорта
function getPassports() {
    $stmt = Connection::get()->query('select * from passportObjectView;');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}
// Получить максимального количества участков среди всех объектов
function getMaxSiteCount() {
    $stmt = Connection::get()->query('select max("sitesCount") from "passportPlantationObjects"');
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return $row;
    }
}
// Получить паспорт по айди объекта
function getPassportByObjectId($id) {
    $stmt = Connection::get()->query('select * from passportObjectView where "passportPlantationObjectsId" = (select "passportPlantationObjectsId" from "passportPlantationObjects" where "ID_Object" = '.$id.');');
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return $row;
    }
}
// Получить схему паспорта по айди объекта
function getPassportSchemaByObjectId($id) {
    $passport = getPassportByObjectId($id);
    return ["schemaPath" => $passport["schemaPath"]];
}
// Получить колво деревьев на объекте
function getTreesCountByObjectId($id) {
    $stmt = Connection::get()->query('select count(*) from "treesAndShrubs" where "lifeFormId" = 1 and "mainObjectId" = '.$id);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return $row;
    }
}
// Запрос количества всех цветников по айди объекта и номеру участка
function getFlowerGardensAmountByObjectIdAndSiteNumber($objectId, $siteNumber) {
    $stmt = Connection::get()->query('select count(*) from "flowergardensalldata" where "mainObjecstId" = '.$objectId.' and "siteNumber" = '.$siteNumber);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return $row;
    }
}
// Получить колво кустов на объекте
function getShrubsCountByObjectId($id) {
    $stmt = Connection::get()->query('select count(*) from "treesAndShrubs" where "lifeFormId" = 2 and "mainObjectId" = '.$id);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return $row;
    }
}
// Получить площадь газона на объекте
function getLawnSquareByObjectId($id) {
    $stmt = Connection::get()->query('select "lawnM" from "passportPlantationObjects" where "ID_Object" = '.$id);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return $row;
    }
}
// Получить площадь цветника на объекте
function getGardenSquareByObjectId($id) {
    $stmt = Connection::get()->query('select "flowerGardensM" from "passportPlantationObjects" where "ID_Object" = '.$id);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return $row;
    }
}
// Получить координаты объекта по его ID
function getCoordinatesById($id) {
    $stmt = Connection::get()->query('select "latitude ", longitude from "treesAndShrubs" where "treesAndShrubsId" = '.$id);
    $result = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result = $row;
    }
    return $result;
}
// Получить данные дерева по его ID
function getTreeInfo($id) {
    $stmt = Connection::get()->query('select * from treesAndShrubsAllData where "treesAndShrubsId" = '.$id);
    $result = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result = $row;
    }
    return $result;
}
// Получить неполные данные для маркеров деревьев
function getTreesMarkers() {
    $stmt = Connection::get()->query('select * from treesAndShrubsalldata ORDER BY "mainObjectId", "siteNumber", "plantNumber";');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}
// Получить данные о всех участках по айди объекта
function getAllAreasByObjectId($objectId) {
    $stmt = Connection::get()->query("select * from treesAndShrubsDataSiteNumbersWithMainObjectId($objectId);");
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}
// Запрос всех деревьев и кустарников по айди объекта и номеру участка
function getTreesAndShrubsByAreaId($objectId, $areaNumber) {
    $stmt = Connection::get()->query("select * from treesAndShrubsAllDataForSiteNumberAndMainObjectId($objectId, $areaNumber);");
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}
// Запрос количества всех деревьев и кустарников по айди объекта и номеру участка
function getAmountTreesAndShrubsByAreaId($objectId, $areaNumber) {
    $stmt = Connection::get()->query("select count(*) from treesAndShrubsAllDataForSiteNumberAndMainObjectId($objectId, $areaNumber);");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return $row;
    }
}    
// Получить отфильтрованные деревья
function getFilteredTrees($filters) {
    $sql = constructFilterQueryForTrees($filters);
    writeToServerLog($sql);
    $stmt = Connection::get()->query($sql);
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    
    return $result;
}
// Получить отфильтрованные цветники
function getFilteredFlowerGardens($filters) {
    $sql = constructFilterQueryForFlowerGardens($filters);
    writeToServerLog($sql);
    $stmt = Connection::get()->query($sql);
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    $resultFinal = [];
    if($filters["composite"] != "null" and count($filters["composite"]) == 0) {
        for ($i = 0; $i < count($result); $i++) {
            $row = $result[$i];
            if($row["names"] == "{}") {
                $resultFinal += $row;
            }
        }
        return $resultFinal;
    }
    return $result;
}