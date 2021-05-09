<?php
// Класс связи с базой данных
class Connection {
    private static $conn;

    // Коннектимся к БД
    public function connect() {
        $pdo = new PDO(
            'pgsql:host=kandula.db.elephantsql.com;dbname=ddzpcgyx', 
            'ddzpcgyx', 
            'qjI5xJ14jxQI2O0osxc6xeQiz5C4qM2H', 
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        return $pdo;
    }

    // Всегда возвращаем один и тот же объект коннекшена,
    // Чтобы предотвратить создание кучи коннекшенов
    // И утечку памяти
    public static function get() {
        if (null === static::$conn) {
            static::$conn = new static();
        }

        return static::$conn->connect();
    }
}