<?php
// Универсальный метод получения справочных данных
function getGlossaryData($tableName) {
    $stmt = Connection::get()->query('SELECT * FROM "'.$tableName.'" ORDER BY "name" ASC;');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}