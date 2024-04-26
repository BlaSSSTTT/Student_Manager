<?php
require 'config.php';
function addStudent($group, $firstName, $secondName, $gender, $birthday, $status,$conn) {
    $stmt = $conn->prepare("INSERT INTO students (idGroup, firstName, secondName, idGender, birthday, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issisi", $group, $firstName, $secondName, $gender, $birthday, $status);
    $stmt->execute();
}
function editStudent($id, $group, $firstName, $secondName, $gender, $birthday, $status, $conn) {
    $stmt = $conn->prepare("UPDATE students SET idGroup=?, firstName=?, secondName=?, idGender=?, birthday=?, status=? WHERE id=?");
    $stmt->bind_param("issisii", $group, $firstName, $secondName, $gender, $birthday, $status, $id);

    $stmt->execute();
}



function formError($response,$infoError,$name, $code)
{
    $error = ['message' => $infoError, 'type' =>$name];
    $response['error'] = $error;
    $response['error']['code'] = $code;
    $response['status'] = false;
    echo json_encode($response);
    exit();
}


header('Content-Type: application/json');
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $response = array('status' =>true);
    if (!isset($_POST['group'])||!array_key_exists($_POST['group'], $arrGroup)) {
        formError($response,"Incorrect group",'group', 101);
    }
    if (!isset($_POST['firstname'])) {
        formError($response,"Empty firstName",'firstName',102);
    }
    if (!isset($_POST['secondName'])) {
        formError($response,"Incorrect secondName enter",'secondName',103);
    }
    if (!isset($_POST['gender'])||!array_key_exists($_POST['gender'], $arrGender)) {
        formError($response,"Incorrect gender",'gender',104);
    }
    if (!isset($_POST['birthday'])||!strtotime($_POST['birthday'])) {
        formError($response,"Empty birthday",'birthday',105);
    }
    if (!isset($_POST['id'])) {
        formError($response,"Empty id",'id',106);
    }
    $id = $_POST['id'];
    $group = $conn->real_escape_string($_POST['group']);
    $firstName = $conn->real_escape_string($_POST['firstname']);
    $secondName = $conn->real_escape_string($_POST['secondName']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $birthday = $conn->real_escape_string($_POST['birthday']);
    $status = $conn->real_escape_string($_POST['status']);
    if (empty($id)) {
        addStudent($group,$firstName,$secondName,$gender,$birthday,$status, $conn);
        $id = mysqli_insert_id($conn);
    }else{
        editStudent($id,$group,$firstName,$secondName,$gender,$birthday,$status, $conn);
    }
    $response['id'] = $id;

    echo json_encode($response);
}