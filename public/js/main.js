$(document).ready(function () {
    $("#login_form").on('submit', function (e) {
        $('.error_message').hide();

        e.preventDefault();

        var can_continue = checkValid();

        if (can_continue) {
            var login = $("#login").val();
            var password = $("#password").val();
            $.ajax({
                url: '/login',
                type: "POST",
                data: {
                    login: login,
                    password: password,
                },
                success: function (data) {
                    var res = JSON.parse(data);
                    if (res.status === 'success') {
                        window.location.href = res.url
                    } else {
                        $(".error_list").append("<p class='error_message'>" + res.message + "</p>");
                    }
                }
            })
        } else {
            $(".error_list").append("<p class='error_message'>Please fill required fields</p>");
        }
    })
    $("#create_task").on('submit', function (e) {
        $('.error_message').hide();
        e.preventDefault();
        var can_continue = checkValid();

        var email = $("#email").val();
        var description = $("#description").val();
        var username = $("#username").val();

        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if (!email.match(validRegex)) {
            $("#email").addClass('hasError');
            $(".error_list").append("<p class='error_message'>Please provide valid email address</p>");
            can_continue = false;
        }

        if (can_continue) {
            $.ajax({
                url: '/save_task',
                type: "POST",
                data: {
                    email: email,
                    description: description,
                    username: username
                },
                success: function (data) {
                    var res = JSON.parse(data);
                    if (res.status === 'success') {
                        var completed = res.task.completed;
                        var completed_class = completed === 1 ? "class='completed'" : '';
                        var id = res.task.id;
                        var username = res.task.username;
                        var email = res.task.email;
                        var description = res.task.description;
                        if($("#tasks_list tr").length < 3) {
                            $("#tasks_list").append("<tr " + completed_class + "id='task_row_" + id + "' >" +
                                "        <th scope='row'>" + id + "</th>" +
                                "        <td>" + email + "</td>" +
                                "        <td>" + username + "</td>" +
                                "        <td>" + description + "</td>" +
                                "        <td>" +
                                "<input type='checkbox' data-id='" + id + "' class='task_completed' " + completed + " >"
                                + "      </td>" +
                                "        <td>" +
                                "            <button type='submit' data-id='" + id + "' class='btn btn-danger delete_task'>Delete</button>" +
                                "            <button type='submit' data-id='" + id + "' class='btn btn-secondary edit_task'>Edit</button>" +
                                "        </td>" +
                                "    </tr>");
                        }

                        $("#email").val('');
                        $("#description").val('');
                        $("#username").val('');
                        init_delete();
                        init_checked();
                    }
                }

            })
        } else {
            $(".error_list").append("<p class='error_message'>Please fill required fields</p>");
        }

    });
    $(".edit_task").click(function () {
        var id = $(this).data('id');
        $("#description_"+id+"_text").hide();
        $("#description_" + id).append('<input type="text" id="task_desc_text" class="form-control required_form" placeholder="Enter task here">');
        $("#save_" + id).attr('style', "display:block !important")
        $(this).hide();
    });
    $(".save-task-desc").on('click',  function () {
        var id = $(this).data('id');
        var can_continue = true;
        var btn = $(this);
        $("#task_desc_text").removeClass('hasError');

        if ($("#task_desc_text").val() === '') {
            $("#task_desc_text").addClass('hasError');
            can_continue = false;
        }

        if (can_continue) {
            var new_desc = $("#task_desc_text").val();
            $.ajax({
                url: '/change_desc',
                type: "POST",
                data: {
                    id: id,
                    description: new_desc,
                },
                success: function (data) {
                    var res = JSON.parse(data);
                    if (res.status === 'success') {
                        $("#description_" + id).html('<td id="description_' + id + '"><span id="description_' + id + '_text"> ' + new_desc + '</span><p class="info">Edit by admin</p> </td>');

                        btn.hide();
                        $(".edit_task").show();
                    }
                }
            })
        }
    })
    init_delete();
    init_checked();
});

function init_delete() {
    $(".delete_task").on('click', function () {
        var data_id = $(this).data('id');
        $.ajax({
            url: '/delete_task',
            type: "POST",
            data: {
                id: data_id
            },
            success: function (data) {
                var res = JSON.parse(data);
                if (res.status === 'success') {
                    $("#task_row_" + data_id).fadeOut('slow');
                }
            }

        })
    })
}

function init_checked() {
    var is_admin = $("#is_admin").val() === '1';

    $(".task_completed").on('click', function () {
        if (is_admin) {
            var id = $(this).data('id');
            var completed = $(this).prop('checked') === true ? 1 : 0;
            $.ajax({
                url: '/change_status',
                type: "POST",
                data: {
                    id: id,
                    completed: completed
                },
                success: function (data) {
                    var res = JSON.parse(data);
                    if (res.status === 'success') {
                        if (completed) {
                            $("#task_row_" + id).addClass('completed')
                        } else {
                            $("#task_row_" + id).removeClass('completed')
                        }
                        $(this).prop('checked', completed);
                    }
                }
            })
        } else {
            return false;
        }
    })
}
function checkValid() {
    var can_continue = true;

    $(".required_form").each(function () {
        $(this).removeClass('hasError');
        if ($(this).val() === '') {
            $(this).addClass('hasError');
            can_continue = false;
        }
    });

    return can_continue;
}