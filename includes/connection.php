<?php

function connection()
{
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "db_result";

    // connect to MySQL server
    $serverConnection = mysqli_connect($host, $username, $password);

    if (!$serverConnection) {
        die("Unable to connect to MySQL Server.");
    }

    // Create database if it doesn't exist
    $createDatabaseQuery = "CREATE DATABASE IF NOT EXISTS `$database`";
    mysqli_query($serverConnection, $createDatabaseQuery);

    mysqli_close($serverConnection);

    // the database connection
    $conn = mysqli_connect($host, $username, $password, $database);

    if (!$conn) {
        die("Unable to connect to project database.");
    }

    mysqli_set_charset($conn, "utf8");

    initialiseDatabase($conn);

    return $conn;
}