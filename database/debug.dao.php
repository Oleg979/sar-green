<?php
// Служебный запрос, выводящий список всех таблиц в БД
function getAllTablesInfo() {
    $stmt = Connection::get()->query(
    "SELECT * 
        FROM pg_catalog.pg_tables
        WHERE schemaname != 'pg_catalog'
        AND schemaname != 'information_schema';
    ");
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    } 
}