<?php
require_once ('db_connect.php');
header("Access-Control-Allow-Origin: http://localhost:3000");
header('Content-Type: text/html; charset=utf-8');
function getData($conn) {
    $faculty = isset($_GET['faculty']) ? $_GET['faculty'] : '';
    $form_edu = isset($_GET['form_edu']) ? $_GET['form_edu'] : '';
    $course = isset($_GET['course']) ? $_GET['course'] : '';
    $groupe = isset($_GET['groupe']) ? $_GET['groupe'] : '';
        $fields = isset($_GET['inc']) =='all' ? '*' : '*';
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
}

function getForAtrib($conn) {
    $faculty = isset($_GET['faculty']) ? $_GET['faculty'] : '';
    $form_edu = isset($_GET['form_edu']) ? $_GET['form_edu'] : '';
    $course = isset($_GET['course']) ? $_GET['course'] : '';
    $groupe = isset($_GET['groupe']) ? $_GET['groupe'] : '';
    $fields = isset($_GET['inc']);
    echo $fields;
    $query = "SELECT DISTINCT $fields FROM schedule";

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
        

        // Закрытие выражения
        $stmt->close();
    }


// Закрытие соединения
    $conn->close();
}

function main()
{
    $conn = get_connection();
    if ($conn) {
        $fields = isset($_GET['inc']);
        switch ($fields){
            case 'all':
                getData($conn);
                break;
            case 'faculty' || 'form_edu' || 'course':
                getForAtrib($conn);
                break;
        }
        getData($conn);
    } else {
        echo "Ошибка при подключении к базе данных.";
    }
    $conn->close();

}

main();
?>