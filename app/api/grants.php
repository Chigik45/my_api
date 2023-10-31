<?php
header('Content-Type: application/json; charset=utf-8');
$mysqli = new mysqli("mysql", "user", "password", "appDB");

//Getting all grants
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json; charset=utf-8');
    $mysqli = new mysqli("mysql", "user", "password", "appDB");
    if (isset($_GET['id'])) {
        $result = $mysqli->query("SELECT * FROM grants where course_id = {$_GET['id']}");
    } else {
        $result = $mysqli->query("SELECT * FROM grants");
    }
    echo $mysqli->error;
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(['grants' => $rows], 200);
    return 0;
}
//Creating new grant
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['grant'])) {
        $grant = $_POST['grant'];
        $result = $mysqli->query("INSERT INTO grants (`grant`) VALUES ('$grant')");

        echo json_encode(['message' => 'added grant: ' . $mysqli->insert_id], 200);
    } else {
        echo json_encode(['message' => 'Error: enter grant'], 400);
    }
    return 0;
}
//Updating grant
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    if (isset($_PUT['id'])) {
        $id = $_PUT['id'];
        $result = $mysqli->query("SELECT * FROM grants where course_id = $id");
        $row = mysqli_fetch_array($result);
        $grant = $row[1];
        $pgrant = isset($_PUT['grant']) ? $_PUT['grant'] : $grant;
        $result = $mysqli->query("UPDATE grants SET `grant`='$pgrant' WHERE `course_id` = $id");
        echo json_encode(['message' => 'updated grant: ' . $id], 200);
    } else {
        echo json_encode(['message' => 'Error: id is needed'], 400);
    }
    return 0;
}