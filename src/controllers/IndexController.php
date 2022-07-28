<?php

namespace Controllers;

use \Models\Task;

class IndexController
{
    public function __construct()
    {
        $this->taskModel = new Task;
    }

    // Render View
    public function tasks()
    {
        $page = $_GET['page'] ?? 1;
        $sort_by = $_GET['sort_by'] ?? '';
        $order_by = $_GET['order_by'] ?? '';
        $limit = ($page - 1) * 3;
        $data['tasks'] = $this->getTasks($limit, $sort_by, $order_by);
        $data['pageCount'] = ceil($this->taskModel->rowCount() / 3);
        $data['currentPage'] = $page;
        view('Index/home', $data);
    }

    // CREATE new task
    public function addTask()
    {
        $data = [];
        $response = [];
        $data['email'] = $_POST['email'];
        $data['username'] = $_POST['username'];
        $data['description'] = $_POST['description'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($task = $this->taskModel->createTask($data))) {
            $response['status'] = 'success';
            $response['message'] = 'Task created successfully';
            $response['task'] = $task;

            echo json_encode($response);
            die;
        }
        $response['status'] = 'error';
        $response['message'] = 'There was an error creating the task';
        echo json_encode($response);
        die;

    }

    // READ all tasks
    private function getTasks($limit, $sort_by = '', $order_by = '') : array
    {
        return $this->taskModel->selectAll($limit, 3, $sort_by, $order_by);
    }

    // UPDATE task
    public function changeStatus()
    {
//        var_dump($_POST['id'], $_POST['completed']);die;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->taskModel->changeTaskStatus($_POST['id'], $_POST['completed'])) {
            $response['status'] = 'success';
            $response['message'] = 'Status changed successfully';
            echo json_encode($response);
            die;
        }
        $response['status'] = 'error';
        $response['message'] = 'There was an error while changing the task status';
        echo json_encode($response);
        die;
    }

    public function changeDescription()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_desc = $_POST['description'];
            $id = $_POST['id'];
            if ($this->taskModel->updateTaskDescription($id, $new_desc))
            {
                $response['status'] = 'success';
                $response['message'] = 'Status changed successfully';
                echo json_encode($response);
                die;
            }
        }
        $response['status'] = 'error';
        $response['message'] = 'There was an error while changing the task description';
        echo json_encode($response);
        die;
    }

    // DELETE task
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->taskModel->deleteTask($_POST['id'])){
            $response['status'] = 'success';
            $response['message'] = 'Task deleted successfully';

            echo json_encode($response);
            die;
        }

        else{
            $response['status'] = 'error';
            $response['message'] = 'There was an error deleting the task';

            echo json_encode($response);
            die;
        }
    }

    public function notFound()
    {
        view('Index/404');
    }
}