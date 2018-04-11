<?php
require_once("todofunctions.php");
require "lib/tpl.php";

$cmd = param('cmd') ? param('cmd') : 'main';

$data = [];


function validate_todo_item($item) {
    $errorMessages = '';

    if (empty($item)) {
        $errorMessages .= "Input value cannot be empty!";
    }
    if (strlen($item) < 3 || strlen($item) > 20) {
        $errorMessages .= "Some of the input values were too short or too long. Try again please!";
    }
 //   if (strlen($item) > 20) {
  //      $errorMessages[] = "Pikkus ei tohi olla suurem kui 20 tähemärki";
  //  }
    return $errorMessages;
}


if ($cmd === 'main') {

    $items = get_items();
    $data = ['$items' => $items];
    $data['$template'] = 'tpl/list.html';


} else if ($cmd === 'ADDlisa') {
    $data['$template'] = 'tpl/secondADDpage.html';

} else if ($cmd === 'add') {

    if (isset($_POST["firstName"]) & isset($_POST["lastName"]) & isset($_POST["phone"])) {
        $errors1 = validate_todo_item($_POST["firstName"]);
        $errors2 = validate_todo_item($_POST["lastName"]);
        $errors3 = validate_todo_item($_POST["phone"]);
        if (strlen($errors1) == 0 & strlen($errors2) == 0 & strlen($errors3) == 0) {
            add_firstName($_POST["firstName"]);
            add_lastName($_POST["lastName"]);
            add_phone($_POST["phone"]);
        } else {
            $errors[] = '';
            array_push($errors, $errors1);
            array_push($errors, $errors2);
            array_push($errors, $errors3);
            $data['$errors'] = $errors;
        }
//    } if (isset($_POST["lastName"])) {
//        $errors = validate_todo_item($_POST["lastName"]);
//        if (count($errors) == 0) {
//            add_lastName($_POST["lastName"]);
//        } else {
//            $data['$errors'] = $errors;
//        }
//    } if (isset($_POST["phone"])) {
//        $errors = validate_todo_item($_POST["phone"]);
//        if (count($errors) == 0) {
//            add_phone($_POST["phone"]);
//        } else {
//            $data['$errors'] = $errors;
//        }
    }

    $data['$template'] = 'tpl/list.html';
    $data['$items'] = get_items();
}

function param($key) {
    if (isset($_GET[$key])) {
        return $_GET[$key];
    } else if (isset($_POST[$key])) {
        return $_POST[$key];
    } else {
        return '';
    }
}

print render_template('tpl/main.html', $data);

?>

