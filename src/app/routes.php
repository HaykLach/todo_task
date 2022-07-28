<?php

// Static pages routes
$router->addRoute('', ['controller' => 'IndexController', 'action' => 'tasks']);
$router->addRoute('404', ['controller' => 'IndexController', 'action' => 'notFound']);
$router->addRoute('change_desc', ['controller' => 'IndexController', 'action' => 'changeDescription']);
$router->addRoute('save_task', ['controller' => 'IndexController', 'action' => 'addTask']);
$router->addRoute('delete_task', ['controller' => 'IndexController', 'action' => 'delete']);
$router->addRoute('change_status', ['controller' => 'IndexController', 'action' => 'changeStatus']);
$router->addRoute('login_index', ['controller' => 'UserController', 'action' => 'index']);
$router->addRoute('login', ['controller' => 'UserController', 'action' => 'login']);
$router->addRoute('logout', ['controller' => 'UserController', 'action' => 'logout']);

$router->setParams(getUri());