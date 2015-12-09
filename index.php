<?php
include_once 'src/DatabaseManager.class.php';
$database_manager = new DatabaseManager();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todo List</title>
    <link rel="icon" type="public/image/ico" href="public/img/favicon.ico">
    <link rel="stylesheet" type="text/css" href="public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <script type="text/javascript" src="public/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="public/js/main.js"></script>
    <script type="text/javascript" src="public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="public/js/style.js"></script>
</head>
<body>
<div class="container" style="margin-top:30px;">
    <div class="col-sm-offset-3 col-sm-6">
        <h1 align="center"><img src="public/img/todo.png"></h1>

        <div class="form-group">
            <input id="main-input" type="text" class="form-control" placeholder="Опишите новую задачу">
        </div>
        <div class="btn-toolbar buttons_reg" role="group">
            <button type="button" class="btn btn-default" id="add-button">
                <div class="glyphicon glyphicon-plus" aria-hidden="true"></div>
                &nbsp&nbspДобавить задачу
            </button>

            <button type="button" class="btn btn-default" id="save">
                <div class="glyphicon glyphicon-saved" aria-hidden="true"></div>
                &nbsp&nbspСохранить
            </button>

            <button type="button" class="btn btn-default" id="show_completed">
                <div class="glyphicon glyphicon-tasks" aria-hidden="true"></div>
                &nbsp&nbspПоказать завершенные
            </button>
        </div>
    </div>

    <div class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Редактировать</h4>
                </div>

                <div class="modal-body">
                    <input type="text" class="form-control" id="edit-input">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="edit-button" data-dismiss="modal">Сохранить
                        изменения
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" id="task-list">
    <ul class="list-group">
        <?php
        $rows = $database_manager->getCurrentTasks(false);
        foreach ($rows as $key) {
            foreach ($key as $k => $task) {
                echo '<li class="li-checkbox"><input class="check" type="checkbox" style="margin-top:13px"></li><li class= "list-group-item" data-toggle="modal" data-target="#editModal">' . "$task" . '<span class="glyphicon glyphicon-remove"></span></li>';
            }
        }
        ?>
    </ul>
</div>

</body>
</html>
