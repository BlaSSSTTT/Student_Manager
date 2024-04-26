<?php
include "config.php";
function addStudent($student, $arrGroup,$arrGender) {
    $newRow = '<tr data-id="' . $student['id'] . '">
                <td><input type="checkbox" class="table-input"></td>
                <td data-value="' . $student['idGroup'] . '">' . $arrGroup[$student['idGroup']] . '</td>
                <td>' . $student['firstName'] . ' ' . $student['secondName'] . '</td>
                <td data-value="' . $student['idGender'] . '">' . $arrGender[$student['idGender']] . '</td>
                <td>' . transformDateFormat($student['birthday']) . '</td>
                <td><i class="bi bi-circle-fill status '. ($student['status'] ? 'active' : '') .'"></i></td>
                <td>
                    <div class="d-flex justify-content-center">
                        <button class="btn addOrEdit" data-id="' . $student['id'] . '">
                            <i class="bi bi-pencil-square edit-btn close-btn table-icons"></i>
                        </button>
                        <button class="btn deleteRow" data-id="' . $student['id'] . '">
                            <i class="bi bi-trash3 delete-btn close-btn table-icons"></i>
                        </button>
                    </div>
                </td>
            </tr>';

    echo $newRow;
}

function transformDateFormat($dateString) {
    $dateComponents = explode("-", $dateString);

    return $dateComponents[2] . "." . $dateComponents[1] . "." . $dateComponents[0];
}


$sql = "SELECT * FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($data as $student) {
        addStudent($student,$arrGroup,$arrGender);
    }
}
