<?php

session_start();

$_SESSION['error'] = false;

if (isset($_POST['title'])) {
    if (empty($_POST['title']) || mb_strlen($_POST['title']) < 3 || mb_strlen($_POST['title']) > 255) {
        $_SESSION['title-error'] = 'Enter correct title';
        $_SESSION['error'] = true;
    } else {
        $_SESSION['title'] = $_POST['title'];
        $_SESSION['title-error'] = '';
        $_SESSION['error'] = false;
    }
}

if (isset($_POST['annotation'])) {
    if (mb_strlen($_POST['annotation']) > 500) {
        $_SESSION['annotation-error'] = 'The number of character must be less than 500';
        $_SESSION['error'] = true;
    } else {
        $_SESSION['annotation'] = $_POST['annotation'];
        $_SESSION['annotation-error'] = '';
        $_SESSION['error'] = false;
    }
}

if (isset($_POST['content'])) {
    if (mb_strlen($_POST['content']) > 30000) {
        $_SESSION['content-error'] = 'The number of character must be less than 30000';
        $_SESSION['error'] = true;
    } else {
        $_SESSION['content'] = $_POST['content'];
        $_SESSION['content-error'] = '';
        $_SESSION['error'] = false;

    }
}

if (isset($_POST['email'])) {
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['email-error'] = 'Enter correct email';
        $_SESSION['error'] = true;
    } else {
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['email-error'] = '';
        $_SESSION['error'] = false;
    }
}

if (isset($_POST['views'])) {
    if (!preg_match("/^[0-9]*$/", (int) $_POST['views']) || (int) $_POST['views'] < 0) {
        $_SESSION['views-error'] = 'Views must be a number and greater than zero';
        $_SESSION['error'] = true;
    } else {
        $_SESSION['views'] = $_POST['views'];
        $_SESSION['views-error'] = '';
        $_SESSION['error'] = false;
    }
}

function checkBiggerThanToday($date)
{
    $today = date("Y-m-d");
    if ($date < $today) {
        return true;
    }
}

if (isset($_POST['date']) && !empty($_POST['date'])) {
    $date = explode('-', $_POST['date']);

    if (!checkdate((int) $date[1], (int) $date[2], (int) $date[0])
        || !checkBiggerThanToday($_POST['date'])) {

        $_SESSION['date-error'] = 'Enter correct date';
        $_SESSION['error'] = true;
    } else {
        $_SESSION['date'] = $_POST['date'];
        $_SESSION['date-error'] = '';
        $_SESSION['error'] = false;
    }
}

if (!isset($_POST['publish_in_index'])) {
    $_SESSION['publish-error'] = 'Check Yes or No';
}

if (isset($_POST['category']) && in_array((int) $_POST['category'], [1, 2, 3])) {
    var_dump(in_array((int) $_POST['category'], [1, 2, 3]));
    $_SESSION['category-error'] = '';
    $_SESSION['error'] = false;
} else {
    $_SESSION['category-error'] = 'Choose category';
    $_SESSION['error'] = true;
}

if ($_SESSION['error'] === false) {
    session_destroy();
}

$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
header("Location: http://$host$uri");
exit;

// $extra = 'index.php';
