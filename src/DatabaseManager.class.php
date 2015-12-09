<?php

class DatabaseManager
{
    private $connection;

    /**
     * DatabaseConnector constructor.
     */
    public function __construct()
    {
        $path_to_config = $_SERVER['DOCUMENT_ROOT'] . '/todolist/config.ini';
        $config = parse_ini_file($path_to_config) or die('File config.ini not found');

        $dsn = 'mysql' . ':host=' . $config['db_host'] . ';dbname=' . $config['db_name'];
        try {
            $this->connection = new PDO($dsn, $config['db_user'], $config['db_pass']);
        } catch (PDOException $ex) {
            echo('MySQL connection error: ' . $ex->getMessage());
        }
    }

    /**
     * @param $task
     * @param $due_date
     *
     * The function save new task in database
     */
    public function saveTask($task, $due_date)
    {
        for ($i = 0; $i < sizeof($task); $i++) {
            if ($this->isHasTask($task[$i])) {
                if ($due_date[$i] == '') {
                    $sql = 'UPDATE tasks SET due_date = NULL WHERE task_description = ' . "'$task[$i]'" . ';';
                } else {
                    $sql = 'UPDATE tasks SET due_date = ' . "'$due_date[$i]'" . ' WHERE task_description = ' . "'$task[$i]'" . ';';
                }
                $this->connection->query($sql);
            } else {
                $sql = 'INSERT INTO tasks (task_description, due_date) VALUES (?, ?)';
                $statement = $this->connection->prepare($sql);
                if ($due_date[$i] == '') {
                    $statement->execute(array($task[$i], null));
                } else {
                    $statement->execute(array($task[$i], $due_date[$i]));
                }
            }
        }

        echo 'ok';
    }

    /**
     * @param bool|true $get_Json
     * @return array
     *
     * The function return list of current tasks
     */
    public function getCurrentTasks($get_Json = true)
    {
        $sql = 'SELECT task_description FROM tasks WHERE due_date IS NULL ;';
        $state = $this->connection->query($sql);
        $rows = $state->fetchAll(PDO::FETCH_ASSOC);
        if ($get_Json) {
            echo json_encode(array('tasks' => $rows));
        } else {
            return $rows;
        }
    }

    /**
     * The function return list of completed tasks
     */
    public function getCompletedTasks()
    {
        $sql = 'SELECT task_description, due_date FROM tasks WHERE due_date IS NOT NULL ;';
        $state = $this->connection->query($sql);
        $rows = $state->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array('tasks' => $rows));
    }

    /**
     * @param $task
     * @return bool
     *
     * The function check task in database
     */
    private function isHasTask($task)
    {
        $sql = 'SELECT task_description FROM tasks WHERE task_description = ' . "'$task'" . ';';
        $statement = $this->connection->query($sql);
        $row = $statement->fetch(PDO::FETCH_LAZY);

        return (is_bool($row)) ? false : true;
    }
}