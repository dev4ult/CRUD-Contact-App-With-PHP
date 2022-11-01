<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "latihan_uts_s3";

$conn = mysqli_connect($host, $user, $pass, $db);

function table_length($table) {
    global $conn;
    $raw_data = mysqli_query($conn, "SELECT * FROM $table");
    $rows = [];
    while ($row = mysqli_fetch_assoc($raw_data)) {
        array_push($rows, $row);
    }

    return sizeof($rows);
}

function select_all_assoc($table, $start_index)
{
    global $conn;
    $raw_data = mysqli_query($conn, "SELECT * FROM $table LIMIT $start_index, 5");
    $rows = [];
    while ($row = mysqli_fetch_assoc($raw_data)) {
        array_push($rows, $row);
    }

    return $rows;
}

function insert_one_to($table, $values)
{
    global $conn;

    mysqli_query($conn, "INSERT INTO $table VALUES ($values)");

    return mysqli_affected_rows($conn);
}

function select_one_from($table, $id)
{
    global $conn;

    $row = mysqli_query($conn, "SELECT * FROM $table WHERE id = $id");

    $row = mysqli_fetch_assoc($row);

    return $row;
}

function delete_one_from($table, $id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM $table WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function edit_one_from($table, $id, $set_values)
{
    global $conn;

    mysqli_query($conn, "UPDATE $table SET $set_values WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function select_with_search_from($table, $like_values)
{
    global $conn;

    $raw_data = mysqli_query($conn, "SELECT * FROM $table WHERE $like_values");

    $rows = [];
    while ($row = mysqli_fetch_assoc($raw_data)) {
        array_push($rows, $row);
    }

    return $rows;
}