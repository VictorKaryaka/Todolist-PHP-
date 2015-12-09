$(document).ready(function () {

    var items;
    var due_date;
    var index;

    // get current tasks
    $.ajax({
        type: 'GET',
        url: 'src/FormHandler.php',
        data: {
            action: 'getCurrentTasks'
        },
        success: function (data) {
            var response = $.parseJSON(data);
            var task_description = [];
            var due_date_local = [];

            for (var key in response.tasks) {
                var current_task = response.tasks[key].task_description;
                task_description.push(current_task);
                due_date_local.push(null);
            }
            storeToLocal('tasks', task_description);
            storeToLocal('due_date', due_date_local);

            items = getFromLocal('tasks');
            due_date = getFromLocal('due_date');
        }
    });

    // if input is empty disable button
    $('#add-button').prop('disabled', true);
    $('input').keyup(function () {
        if ($(this).val().length !== 0) {
            $('#add-button').prop('disabled', false);
        } else {
            $('#add-button').prop('disabled', true);
        }
    });

    // bind input enter with button submit
    $('#main-input').keypress(function (e) {
        if (e.which === 13) {
            if ($('#main-input').val().length !== 0)
                $('#add-button').click();
        }
    });

    //restriction of input characters
    $('#main-input').keyup(function () {
        var inpu_text = $('#main-input').val();
        if (inpu_text.length > 100) {
            $('#main-input').val(inpu_text.substring(0, inpu_text.length - 1));
        }
    });

    //add new task
    $('#add-button').click(function () {
        var value = $('#main-input').val();
        var regExp = /^\s+$/;
        if (regExp.test(value)) return;
        items.push(value);
        due_date.push(null);
        $('#main-input').val('');
        loadList(items);
        storeToLocal('tasks', items);
        storeToLocal('due_date', due_date);
        $('#add-button').prop('disabled', true);
    });

    // delete one item
    $('ul').delegate("span", "click", function (event) {
        event.stopPropagation();
        var element = $('span').index(this);
        $('li').eq(element * 2 - 1).remove();
        $('li').eq(element * 2 - 2).remove();
        items.splice(element - 1, 1);
        due_date.splice(element - 1, 1);
        storeToLocal('tasks', items);
        storeToLocal('due_date', due_date);
    });

    //disable task
    $('ul').delegate($('input:checkbox'), 'click', function () {
        $('.check').change(function () {
            var elem = $('input').index(this) - 2;
            if ($(this).prop('checked')) {
                $('li').eq(elem * 2 + 1).css('text-decoration', 'line-through');
                due_date[elem] = getCurrentDate();
            } else {
                $('li').eq(elem * 2 + 1).css('text-decoration', 'none');
                due_date[elem] = null;
            }
            storeToLocal("due_date", due_date);
        });
    });

    // edit panel
    $('ul').delegate('li', 'click', function () {
        index = $('li').index(this) / 2 ^ 0;
        var content = items[index];
        $('#edit-input').val(content);
    });

    $('#edit-button').click(function () {
        items[index] = $('#edit-input').val();
        loadList(items);
        storeToLocal("tasks", items);
    });

    //save tasks in database
    $('#save').click(function () {
        var items = getFromLocal('tasks');
        var due_date = getFromLocal('due_date');

        $.ajax({
            type: 'GET',
            url: 'src/FormHandler.php',
            data: {
                action: 'saveTasks',
                tasks: items,
                due_date: due_date
            },
            success: function (data) {
                if (data = "ok") location.reload();
            }
        });
    });

    //show completed tasks
    $('#show_completed').click(function () {
        $.ajax({
            type: 'GET',
            url: 'src/FormHandler.php',
            data: {
                action: 'getCompletedTasks'
            },
            success: function (data) {
                var response = $.parseJSON(data);
                $('#save').prop('disabled', true);
                $('li').remove();
                for (var key in response.tasks) {
                    var current_task = response.tasks[key].task_description;
                    var due_date = response.tasks[key].due_date;
                    $('ul').append('<li class= "list-group-item">' + current_task + "  -  " + due_date + '</li>');
                }
            }
        });
    });

    //The function return current date
    function getCurrentDate() {
        var date = new Date();
        var current_date = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" +
            date.getDate() + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
        return current_date;
    }

    // show task list
    function loadList(items) {
        $('li').remove();
        if (items.length > 0) {
            for (var i = 0; i < items.length; i++) {
                $('ul').append('<li class="li-checkbox"><input class="check" type="checkbox" style="margin-top:13px"></li><li class= "list-group-item" data-toggle="modal" data-target="#editModal">' + items[i] + '<span class="glyphicon glyphicon-remove"></span></li>');
            }
        }
    }

    //save to local storage
    function storeToLocal(key, items) {
        localStorage[key] = JSON.stringify(items);
    }

    //get from local storage
    function getFromLocal(key) {
        if (localStorage[key])
            return JSON.parse(localStorage[key]);
        else
            return [];
    }
});
