<?php
require_once ('db_connect.php');
header("Access-Control-Allow-Origin: http://localhost:3000");
header('Content-Type: text/html; charset=utf-8');
function getData($conn) {
    $faculty = isset($_GET['faculty']) ? $_GET['faculty'] : '';
    $form_edu = isset($_GET['form_edu']) ? $_GET['form_edu'] : '';
    $course = isset($_GET['course']) ? $_GET['course'] : '';
    $groupe = isset($_GET['groupe']) ? $_GET['groupe'] : '';
        $query = "SELECT * FROM schedule";

//Получение всех данных из get запроса
        if ($stmt = $conn->prepare($query)) {
            // Выполнение запроса
            $stmt->execute();

            $result = $stmt->get_result();

            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            echo json_encode($data,JSON_UNESCAPED_UNICODE);

            $stmt->close();
        }
}

function getForAtrib($conn) {
    $faculty = isset($_GET['faculty']) ? $_GET['faculty'] : '';
    $form_edu = isset($_GET['form_edu']) ? $_GET['form_edu'] : '';
    $course = isset($_GET['course']) ? $_GET['course'] : '';
    $groupe = isset($_GET['groupe']) ? $_GET['groupe'] : '';
    $fields = $_GET['inc'];
    $query = "SELECT DISTINCT $fields FROM schedule";
    if ($stmt = $conn->prepare($query)) {
        $stmt->execute();

        $result = $stmt->get_result();

        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        $stmt->close();
    }


}

function main()
{
    $conn = get_connection();
    if ($conn) {
        $fields = $_GET['inc'];
        switch ($fields){
            case 'all':
                getData($conn);
                break;
            case 'faculty':
                getForAtrib($conn);
                break;
            case 'form_edu':
                getForAtrib($conn);
                break;
            case 'course':
                getForAtrib($conn);
                break;
            default:
                // ... код,  если  $fields  не совпадает ни с одним case ...
                break;
        }
    } else {
        echo "Ошибка при подключении к базе данных.";
    }
    $conn->close();

}

main();
?>