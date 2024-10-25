<?php
require_once ('db_connect.php');
header("Access-Control-Allow-Origin: http://localhost:3000");
header('Content-Type: text/html; charset=utf-8');
function getData($conn) {
    if ($conn) {
        $faculty = isset($_GET['faculty']) ? $_GET['faculty'] : '';
        $form_edu = isset($_GET['form_edu']) ? $_GET['form_edu'] : '';
        $course = isset($_GET['course']) ? $_GET['course'] : '';
        $groupe = isset($_GET['groupe']) ? $_GET['groupe'] : '';
        $fields = isset($_GET['inc']) ? $_GET['inc'] : '*';
        $query = "SELECT $fields FROM schedule";

//Получение всех данных из get запроса
        if ($stmt = $conn->prepare($query)) {
            // Выполнение запроса
            $stmt->execute();

            // Получение результатов
            $result = $stmt->get_result();

            // Формирование массива с результатами
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            // Возвращение данных в формате JSON
            echo json_encode($data,JSON_UNESCAPED_UNICODE);

            // Закрытие выражения
            $stmt->close();
        }


// Закрытие соединения
        $conn->close();
    } else {
        echo "Ошибка при подключении к базе данных.";
    }
}

function main()
{
    $conn = get_connection();
    if ($conn) {
        getData($conn);
    } else {
        echo "Ошибка при подключении к базе данных.";
    }

}

main();
?>