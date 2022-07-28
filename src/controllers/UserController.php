<?php

namespace Controllers;


use Models\User;

class UserController
{
    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index() {
        view('Index/login');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($user = $this->userModel->getUser($_POST['login']))) {
            if (password_verify($_POST['password'], $user->password)) {
                session_start();
                $_SESSION['admin_logged_in'] = true;
                $response['status'] = 'success';
                $response['message'] = 'User logged in successfully';
                $response['url'] = URLROOT;
                echo json_encode($response);
                die;
            }
        }
        $response['status'] = 'error';
        $response['message'] = 'Invalid login or password';
        echo json_encode($response);
        die;
    }
    public function logout() {
        session_start();
        $_SESSION['admin_logged_in'] = false;
        session_destroy();
        header("location: ". URLROOT);
        exit;
    }
}