<?php
header('Content-Type: application/json; charset=utf-8');
$mysqli = new mysqli("mysql", "user", "password", "appDB");

//Getting all users
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $result = $mysqli->query("SELECT id, surname, name, course_id as `course`, `grant` FROM students 
        left join `grants` using (course_id) where id = {$_GET['id']}");
    } else {
        $result = $mysqli->query("SELECT id, surname, name, course_id as `course`, `grant` FROM students left join `grants` using (course_id)");
    }
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(['users' => $rows], 200);
    return 0;
}
//Creating new users
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['surname'], $_POST['name'], $_POST['course'])) {
        $surname = $_POST['surname'];
        $name = $_POST['name'];
        $course = $_POST['course'];
        $result = $mysqli->query("INSERT INTO students (`surname`, `name`, `course_id`) VALUES ('$surname', '$name', '$course')");

        echo json_encode(['message' => 'added user: ' . $mysqli->insert_id], 200);
    } else {
        echo json_encode(['message' => 'Error: all fields needed'], 400);
    }
    return 0;
}
//Updating users
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    if (isset($_PUT['id'])) {
        $id = $_PUT['id'];
        $result = $mysqli->query("SELECT * FROM students where id = $id");
        $row = mysqli_fetch_array($result);
        $surname = $row[1];
        $name = $row[2];
        $course = $row[3];
        $psurname = isset($_PUT['surname']) ? $_PUT['surname'] : $surname;
        $pname = isset($_PUT['name']) ? $_PUT['name'] : $name;
        $pcourse = isset($_PUT['course']) ? $_PUT['course'] : $course;
        $result = $mysqli->query("UPDATE students SET `surname`='$psurname',`name`='$pname',`course_id`='$pcourse' WHERE `id` = $id");
        echo json_encode(['message' => 'updated user: ' . $id], 200);
    } else {
        echo json_encode(['message' => 'Error: id is needed'], 400);
    }
    return 0;
}
//Deleting users
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (isset($_GET['id'])) {
        if ($mysqli->query("DELETE FROM students WHERE id = {$_GET['id']}") === TRUE)
            echo json_encode(['message' => 'deleted: ' . $_GET['id']], 200);
        else
            echo "Error deleting record: " . $mysqli->error;
    } else {
        echo json_encode(['message' => 'Error: id is needed'], 400);
    }
}