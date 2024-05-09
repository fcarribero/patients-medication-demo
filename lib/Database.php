<?php

abstract class Database {

    /** @var DBConnection|null */
    public $connection;

    abstract public function connect($dsn);

    abstract public function disconnect();

    abstract public function select($table, $columns, $conditions);

    abstract public function insert($table, $data);

    abstract public function delete($table, $conditions);

    abstract public function update($table, $data, $conditions);
}