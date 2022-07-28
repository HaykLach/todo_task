<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= URLROOT;?>/public/css/style.css">
    <link rel="stylesheet" href="<?= URLROOT;?>/public/css/bootstrap.min.css">
    <title> <?= SITENAME; ?> </title>
</head>
<body>
<?php
session_start();
?>
<input id="is_admin" type="hidden" value="<?php echo  (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) ? '1' : '0'?>">
<nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= URLROOT; ?>">Home</a>
        <?php if (isset($_SESSION['admin_logged_in'])):?>
            <a class="navbar-brand" href="<?= URLROOT; ?>/logout"> Log Out </a>
        <?php else: ?>
        <a class="navbar-brand" href="<?= URLROOT; ?>/login_index">Login</a>
        <?php endif ?>
    </div>
</nav>