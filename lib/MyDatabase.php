<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/DBConnection.php';

class MyDatabase extends Database {
    public function connect($dsn) {
        $this->connection = DBConnection::getInstance();
        $this->connection->connect($dsn);
    }

    public function disconnect() {
        $this->connection = null;
    }

    public function select($table, $columns, $conditions, $order = null, $group = null) {
        $query = "SELECT " . implode(', ', $columns) . " FROM $table";
        $query .= " WHERE $conditions";
        if ($group) {
            $query .= " GROUP BY $group";
        }
        if ($order) {
            $query .= " ORDER BY $order";
        }
        $statement = $this->connection->query($query);
        if (!$statement) {
            $error_info = $this->connection->connection->errorInfo();
            throw new Exception('Error executing query: ' . $error_info[0] . ' ' . $error_info[2]);
        }
        if (!$statement->execute()) {
            $error_info = $this->connection->connection->errorInfo();
            throw new Exception('Error executing query: ' . $error_info[0] . ' ' . $error_info[2]);
        }
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($table, $data) {
        $columns = array_keys($data);
        $values = array_values($data);
        $query = "INSERT INTO $table (" . implode(', ', $columns) . ") VALUES (" . implode(', ', array_map(function ($value) {
                return $this->connection->connection->quote($value);
            }, $values)) . ")";
        if (!$this->connection->query($query)) {
            $error_info = $this->connection->connection->errorInfo();
            throw new Exception('Error executing query: ' . $error_info[0] . ' ' . $error_info[2]);
        }
        return true;
    }

    public function delete($table, $conditions) {
        $query = "DELETE FROM $table";
        $query .= " WHERE $conditions";
        $statement = $this->connection->query($query);
        if (!$statement->execute()) {
            throw new Exception("Error executing query: $query");
        }
        return true;
    }

    public function update($table, $data, $conditions) {
        $query = "UPDATE $table SET ";
        $set = [];
        foreach ($data as $column => $value) {
            $set[] = "$column = " . $this->connection->connection->quote($value);
        }
        $query .= implode(', ', $set);
        $query .= " WHERE $conditions";
        return $this->connection->query($query);
    }
}