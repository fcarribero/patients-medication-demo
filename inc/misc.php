<?php

//Draws a table from a 2D array
function drawDataTable($data_array) {
    if (empty($data_array)) {
        return "Empty dataset\n";
    }
    $columns = array_keys($data_array[0]);
    $column_lengths = [];
    foreach ($data_array as $row) {
        foreach ($row as $column => $value) {
            $column_lengths[$column] = max(strlen($column), strlen($value), $column_lengths[$column] ?? 0);
        }
    }
    foreach ($columns as $index => $column) {
        $column_lengths[$column] = max(strlen($column), $column_lengths[$column] ?? 0);
    }

    $table = '';

    $columns = array_map(function ($column) use ($column_lengths) {
        return str_pad($column, $column_lengths[$column]);
    }, $columns);

    $table .= implode(' | ', array_map(function ($column) use ($column_lengths) {
            return str_repeat('-', $column_lengths[$column]);
        }, array_keys($column_lengths))) . PHP_EOL;
    $table .= implode(' | ', $columns) . PHP_EOL;
    $table .= implode(' | ', array_map(function ($column) use ($column_lengths) {
            return str_repeat('-', $column_lengths[$column]);
        }, array_keys($column_lengths))) . PHP_EOL;
    foreach ($data_array as $row) {
        $row = array_map(function ($value, $column) use ($column_lengths) {
            return str_pad($value, $column_lengths[$column]);
        }, $row, array_keys($row));
        $table .= implode(' | ', $row) . PHP_EOL;
    }
    return $table;
}

// Build the database and fills it with some data
function buildDB($dsn) {
    global $db;
    $db->connect($dsn);

    $sql = explode(';', file_get_contents(__DIR__ . '/database.sql'));
    foreach ($sql as $query) {
        $query = trim($query);
        if (empty($query)) {
            continue;
        }
        if (!($statement = $db->connection->query($query))) {
            $error_info = $db->connection->connection->errorInfo();
            throw new Exception('Error executing query: ' . $error_info[0] . ' ' . $error_info[2]);
        }
        $statement->execute();
    }

    $db->insert('doctors', ['name' => 'Dr. Meredith Grey', 'id' => 1]);
    $db->insert('doctors', ['name' => 'Dr. Gregory House', 'id' => 2]);
    $db->insert('doctors', ['name' => 'Dr. Miranda Bailey', 'id' => 3]);
    $db->insert('doctors', ['name' => 'Dr. Derek Shepherd', 'id' => 4]);
    $db->insert('doctors', ['name' => 'Dr. Christina Yang', 'id' => 5]);

    $db->insert('patients', ['name' => 'Betty Boop', 'doctor_id' => 1, 'id' => 1]);
    $db->insert('patients', ['name' => 'Harry Potter', 'doctor_id' => 1, 'id' => 2]);
    $db->insert('patients', ['name' => 'Chuck Norris', 'doctor_id' => 3, 'id' => 3]);
    $db->insert('patients', ['name' => 'Princess Consuela Bananahammock', 'doctor_id' => 5, 'id' => 4]);
    $db->insert('patients', ['name' => 'Whoopsy Goldberg', 'doctor_id' => 5, 'id' => 5]);

    $db->insert('medications', ['name' => 'ChuckleX', 'dose' => '5000mg', 'id' => 1]);
    $db->insert('medications', ['name' => 'Giggletrex', 'dose' => '10000mg', 'id' => 2]);
    $db->insert('medications', ['name' => 'Hilarinol', 'dose' => '2000mg', 'id' => 3]);
    $db->insert('medications', ['name' => 'Laughitol', 'dose' => '500mg', 'id' => 4]);
    $db->insert('medications', ['name' => 'Smilenex', 'dose' => '7500mg', 'id' => 5]);

    $db->insert('patient_medication', ['patient_id' => 1, 'medication_id' => 1, 'quantity' => 1, 'frequency_hours' => 6, 'start_by' => '2021-01-01', 'end_by' => '2021-12-31']);
    $db->insert('patient_medication', ['patient_id' => 1, 'medication_id' => 2, 'quantity' => 1, 'frequency_hours' => 3, 'start_by' => '2025-02-01', 'end_by' => '2029-11-15']);
    $db->insert('patient_medication', ['patient_id' => 2, 'medication_id' => 3, 'quantity' => 10, 'frequency_hours' => 12, 'start_by' => '2021-03-01', 'end_by' => '2021-10-11']);
    $db->insert('patient_medication', ['patient_id' => 3, 'medication_id' => 4, 'quantity' => 1, 'frequency_hours' => 24, 'start_by' => '2021-04-01', 'end_by' => '2021-09-01']);
    $db->insert('patient_medication', ['patient_id' => 4, 'medication_id' => 5, 'quantity' => 5, 'frequency_hours' => 6, 'start_by' => '2021-05-01', 'end_by' => '2022-08-20']);
    $db->insert('patient_medication', ['patient_id' => 4, 'medication_id' => 2, 'quantity' => 1, 'frequency_hours' => 6, 'start_by' => '2021-06-01', 'end_by' => '2022-09-20']);
    $db->insert('patient_medication', ['patient_id' => 5, 'medication_id' => 1, 'quantity' => 99, 'frequency_hours' => 7, 'start_by' => '2021-06-01', 'end_by' => '2021-07-24']);

}