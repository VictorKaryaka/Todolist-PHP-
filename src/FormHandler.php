<?php
include_once 'DatabaseManager.class.php';

$action = $_GET['action'];
$databaseManager = new DatabaseManager();

switch ($action) {
    case('getCurrentTasks'): {
        $databaseManager->getCurrentTasks();
        break;
    }
    case('getCompletedTasks'): {
        $databaseManager->getCompletedTasks();
        break;
    }
    case('saveTasks'): {
        $databaseManager->saveTask($_GET['tasks'], $_GET['due_date']);
        break;
    }
}