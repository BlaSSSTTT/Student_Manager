window.addEventListener('load', async ()=>{
    if (navigator.serviceWorker){
        try {
            await navigator.serviceWorker.register('sm.js');
        }catch (e){
            console.log("Service work fail");
        }

    }
});
let Student = function () {
    this.id = null;
    this.group = "";
    this.firstname = "";
    this.secondName = "";
    this.gender = "";
    this.birthday = "";
    this.status = false;
}

document.addEventListener("DOMContentLoaded", function() {
    $('#myForm').submit(function(event) {
        event.preventDefault();
        let student = new Student();
        student.id = $('#id').val();
        student.group = $('#group').val();
        student.firstname = $('#firstName').val();
        student.secondName = $('#secondName').val();
        student.gender = $('#gender').val();
        student.birthday = $('#birthday').val();
        student.status = ($('#status').prop('checked')) ? 1 : 0;
        addOrUpdateStudent(student);
    });
    $('#submitDelete').click(function() {
        const id = $('#idOfDelete').val();
        deleteStudent(id);
    });

    $('.content').on('click', 'button', function(event) {
        if ($(this).closest("button").hasClass('addOrEdit')) {
            openMainModal($(this).closest("button"));
        }
        if ($(this).closest("button").hasClass('deleteRow')) {
            openWarningModel($(this).closest("button"));
        }
    });

});
function clearValidation() {
    $('.is-invalid').removeClass('is-invalid');
}

function addOrUpdateStudent(student) {
    $.ajax({
        url: 'add_update_student.php',
        type: 'POST',
        data: student,
        dataType: 'json',
        beforeSend:function(){clearValidation()},
        success: function(data) {
            console.log(data);
            if (!data.status) {
                if(data.error.type==="database"){
                    alert(data.error.message);
                }
                document.getElementById(data.error.type).classList.add("is-invalid");
            } else {
                if(student.id===""){
                    student.id=data.id;
                    addStudent(student);
                }else{
                    editStudent(student);
                }
                let modal = bootstrap.Modal.getInstance(document.getElementById("addStudentForm"));
                modal.hide();
            }
        },
        error: function(xhr, status, error) {
            console.error(status + ': ' + error);
        }
    });
}
function deleteStudent(studentId) {
    $.ajax({
        url: 'delete_student.php',
        type: 'POST',
        data: {'id':studentId},
        dataType: 'json',
        success: function(data) {
            if (data.success) {
                const row = getRowByDataAttribute('data-id', studentId);
                row.parentNode.removeChild(row);
                let modal = bootstrap.Modal.getInstance(document.getElementById("deleteWarningModal"));
                modal.hide();
            } else {
                alert("Error deleting item: " + data.error.message);
            }
        },
        error: function(xhr, status, error) {
            console.error(status + ': ' + error);
        }
    });
}
function transformDateFormat(dateString) {
    let dateObject = new Date(dateString);

    let day = dateObject.getDate();
    let month = dateObject.getMonth() + 1;
    let year = dateObject.getFullYear();

    // Format the date in "DD.MM.YYYY" format
    return `${day < 10 ? '0' + day : day}.${month < 10 ? '0' + month : month}.${year}`;
}
function transformDateFormatToISO(dateString) {
    let parts = dateString.split('.');

    return parts[2] + '-' + parts[1].padStart(2, '0') + '-' + parts[0].padStart(2, '0');
}
function updateModal(student) {
    $('#id').val(student.id ? student.id : "");
    $('#group').val(student.group);
    $('#firstName').val(student.firstname);
    $('#secondName').val(student.secondName);
    $('#gender').val(student.gender);
    $('#birthday').val(student.birthday ? transformDateFormatToISO(student.birthday) : "");
    $('#status').prop('checked', student.status);
}

function getRowByDataAttribute(attributeName, attributeValue) {
    const table = $('#studentsTable');
    const rows = table.find('tr');
    for (let i = 0; i < rows.length; i++) {
        const row = $(rows[i]);
        if (row.attr(attributeName) == attributeValue) {
            return row;
        }
    }

    return null;
}


function editStudent(student) {
    const row = getRowByDataAttribute('data-id', student.id);
    const cols = $(row).find('td');

    $(cols[1]).attr("data-value", student.group);
    $(cols[1]).text($('#group option[value="' + student.group + '"]').text());
    $(cols[2]).text(student.firstname + " " + student.secondName);
    $(cols[3]).attr("data-value", student.gender);
    $(cols[3]).text($('#gender option[value="' + student.gender + '"]').text());
    $(cols[4]).text(transformDateFormat(student.birthday));
    if (student.status) {
        $(cols[5]).html('<i class="bi bi-circle-fill status active"></i>');
    } else {
        $(cols[5]).html('<i class="bi bi-circle-fill status"></i>');
    }
}

let openMainModal = function (button) {
    clearValidation();
    let student = new Student();
    let title = "Add student";
    if ($(button).data("id") !== "") {
        title = "Edit student";
        let tr = $(button).closest('tr');
        let columns = tr.find('td');
        let isActive;
        columns.each(function(index, column) {
            if($(column).find('i.status').length > 0) {
                isActive = $(column).find('i.status').hasClass('active');
            }
        });
        student.id = tr.data("id");
        student.group = columns.eq(1).data("value");
        let name = columns.eq(2).text().split(" ");
        student.firstname = name[0];
        student.secondName = name[1];
        student.gender = columns.eq(3).data("value");
        student.birthday = columns.eq(4).text();
        student.status = isActive;
    }
    updateModal(student);
    $('#modalTitle').text(title);

    let modal = new bootstrap.Modal(document.getElementById('addStudentForm'));

    modal.show();
}

function openWarningModel(button) {
    let tr = $(button).closest('tr');
    let columns = tr.find('td');
    let name = columns.eq(2).text().trim();
    $('#idOfDelete').val($(button).data("id"));
    $('#messageForDelete').text("Are you sure you want to delete student " + name + "?");
    let modal = new bootstrap.Modal(document.getElementById("deleteWarningModal"));

    modal.show();
}

function addStudent(student) {
    let status;
    if (student.status) {
        status = '<i class="bi bi-circle-fill status active"></i>';
    } else {
        status = '<i class="bi bi-circle-fill status"></i>';
    }
    const newRow = $('<tr>').attr('data-id', student.id).html(
        `<td><input type="checkbox" class="table-input"></td>
         <td data-value="${student.group}">${$('#group option[value="' + student.group + '"]').text()}</td>
         <td>${student.firstname} ${student.secondName}</td>
         <td data-value="${student.gender}">${$('#gender option[value="' + student.gender + '"]').text()}</td>
         <td>${transformDateFormat(student.birthday)}</td>
         <td>${status}</td>
         <td>
             <div class="d-flex justify-content-center">
                 <button class="btn addOrEdit" data-id="${student.id}">
                     <i class="bi bi-pencil-square edit-btn close-btn table-icons"></i>
                 </button>
                 <button class="btn deleteRow" data-id="${student.id}">
                     <i class="bi bi-trash3 delete-btn close-btn table-icons"></i>
                 </button>
             </div>
         </td>`
    );

    $('#studentsTable tbody').append(newRow);
}
















