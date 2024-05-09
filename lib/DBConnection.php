<?php

class DBConnection {
    private static $instance = null;

    /** @var PDO */
    public $connection;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function connect($dsn) {
        $this->connection = new PDO($dsn);
    }

    public function query($query) {
        return $this->connection->query($query);
    }
}