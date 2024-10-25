<?php
function get_connection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ach";

    try {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            throw new Exception("Ошибка подключения: " . $conn->connect_error);
        }
        return $conn;
    } catch (Exception $e) {
        echo "Ошибка подключения: " . $e->getMessage();
        return null;
    }
}

?>