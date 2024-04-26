<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="localStyles.css">
    <link rel="manifest" href="manifest.json">
    <title>Students</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<?php include("config.php"); ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-custom-color">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-brand logo">
                ICSIT
            </div>
            <ul class="nav">
                <li class="nav-item">
                    <div class="dropdown me-1 mt-2 p-1">
                        <button class="btn dropdown-toggle dropdown-toggle-no-arrow" aria-expanded="false">
                            <a href="Messages.html"><i class="bi bi-bell-fill text-white bell-dot"></i></a>
                        </button>
                        <ul class="dropdown-menu shadow-lg rounded-start-2 dropdown-comp">
                            <li class="row p-2">
                                <div class="custom-popup-div-icon col-4 mt-4">
                                    <div class="ms-3">
                                        <img class="custom-popup-icon" src="standart.png">
                                    </div>
                                    <div class="ms-1">
                                        Admin
                                    </div>
                                </div>
                                <div class="custom-popup-message bg-white rounded-3 col-8 p-2">
                                    <div class = "p-4">Привіт</div>
                                </div>
                            </li>
                            <li class="row p-2">
                                <div class="custom-popup-div-icon col-4 mt-4">
                                    <div class="ms-3">
                                        <img class="custom-popup-icon" src="icon.jpg">
                                    </div>
                                    <div class="ms-1">
                                        Valera
                                    </div>
                                </div>
                                <div class="custom-popup-message bg-white rounded-3 col-8 p-2">
                                    <div class="p-4"> Привіт</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item dropdown mt-2 p-1">
                    <div class="dropdown-toggle row" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="col-4" src="ava.png" id="ava">
                        <div class="col-7 ava-name-username fs-3 text-white">James Bond</div>
                    </div>
                    <ul class="dropdown-menu shadow-lg dropdown-menu-end mt-2 p-2 settings">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div>

    </nav>

    <div id="sidebar" class="collapse sidebar bg-white d-lg-block pt-5 z-3">
        <a class="ms-5 p-2 text-decoration-none"  href="Dashboard.html">Dashboards</a>
        <a class="ms-5 p-2 text-decoration-none active" href="index.html">Students</a>
        <a class="ms-5 p-2 text-decoration-none" href="Tasks.html">Tasks</a>
    </div>
    <div class="content float-lg-end me-lg-5 p-3">
        <div class="head-message mt-4">Students</div>
        <div  class="text-end">
            <button class="btn btn-icon addOrEdit" data-id="">
                <i class="bi bi-plus-square"></i>
            </button>
        </div>
        <div class = "table-responsive table-container">
            <table id = "studentsTable" class="table text-center table-bordered bg-white table-black-border align-middle text-nowrap">
                <thead>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th>Group</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Birthday</th>
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include("readFromDB.php"); ?>
                </tbody>

            </table>

        </div>
        <div class="d-flex justify-content-center">
            <ul class="pagination">
                <li class="page-item"><a class="page-link bg-white transparent" href="#"><</a></li>
                <li class="page-item"><a class="page-link bg-white transparent" href="#">1</a></li>
                <li class="page-item"><a class="page-link bg-white transparent" href="#">2</a></li>
                <li class="page-item"><a class="page-link bg-white transparent" href="#">3</a></li>
                <li class="page-item"><a class="page-link bg-white transparent" href="#">></a></li>
            </ul>
        </div>

    </div>

    <div class="modal fade" id="addStudentForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                </div>
                <div class="modal-body text-nowrap">
                    <form id="myForm">
                        <input name="id" type="hidden" id="id">
                        <div class="row mb-3">
                            <label for="group" class="col-sm-3 col-form-label">Group</label>
                            <div class="col-sm-9">
                                <select name="group" class="form-select" id="group">
                                    <option selected disabled value="">Choose Group</option>
                                    <?php foreach($arrGroup as $key => $group){ ?>
                                        <option value="<?= $key ?>"><?= $group ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback">
                                    Choose group
                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <label for="firstName" class="col-sm-3 col-form-label">First Name</label>
                            <div class="col-sm-9">
                                <input name="firstName" type="text" class="form-control" id="firstName">
                                <div class="invalid-feedback">
                                    Enter first name consisting of only letters
                                </div>

                            </div>

                        </div>
                        <div class="row mb-3">
                            <label for="secondName" class="col-sm-3 col-form-label">Second Name</label>
                            <div class="col-sm-9">
                                <input name="secondName" type="text" class="form-control" id="secondName">
                                <div class="invalid-feedback">
                                    Enter second name consisting of only letters
                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <label for="gender" class="col-sm-3 col-form-label">Gender</label>
                            <div class="col-sm-9">
                                <select name="gender" class="form-select" id="gender">
                                    <option selected disabled value="">Choose Gender</option>
                                    <?php foreach($arrGender as $key => $gender){ ?>
                                    <option value="<?= $key ?>"><?= $gender?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback">
                                    Choose gender
                                </div>
                            </div>


                        </div>
                        <div class="row mb-3">
                            <label for="birthday" class="col-sm-3 col-form-label">Birthday</label>
                            <div class="col-sm-9">
                                <input name='birthday' type="date" class="form-control " id="birthday">
                                <div class="invalid-feedback">
                                    Введіть дату
                                </div>
                            </div>


                        </div>
                        <div class="row mb-3">
                            <label for="status" class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-1 is-valid">
                                <input name='status' type="checkbox" id="status">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button id="submitButton" class="btn btn-primary confirm-btn" type="submit">OK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal " tabindex="-1" id="deleteWarningModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteForm">
                    <input name="id" hidden id="idOfDelete">
                </form>

                <div class="modal-body" id="messageForDelete">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary confirm-btn" id="submitDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script type="module" src="scripts.js"></script>
</body>
</html>