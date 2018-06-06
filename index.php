<?php
require_once ("Database.php");
require_once ("Contact.php");
require "lib/tpl.php";

$cmd = param('cmd') ? param('cmd') : 'main';
//session_start();
$data = [];


function validate_todo_item($item) {
    $errorMessages = '';
    if (empty($item)) {
        $errorMessages .= "Input value cannot be empty!";
    }
    else if (strlen($item) < 3 || strlen($item) > 20) {
        $errorMessages .= "Some of the input values were too short or too long. Try again please!";
    }
    return $errorMessages;
}


if ($cmd === 'main') {
    $database_handler = new Database();
    $all_contacts = $database_handler->getAllContacts();
    $data = ['$all_contacts' => $all_contacts];
    $data['$template'] = 'tpl/list.html';
    print render_template('tpl/main.html', $data);

} else if ($cmd === 'add'){
    $data['$template'] = 'tpl/secondADDpage.html';
    print render_template('tpl/main.html', $data);

} else if (strpos($cmd, 'edit') !== false) {
    $findID = explode("_", $cmd);
    $id = $findID[2];
    var_dump($id);
    $database_handler = new Database();
    $allcontacts = $database_handler->getAllContacts();
    foreach ($allcontacts as $contact) {
        if ($contact->id == $id) {
            $numbers = explode(", ", $contact->numbers);
            if (isset($contact->firstName)) {
                $data['$firstName'] = $contact->firstName;
            }
            if (isset($contact->lastName)) {
                $data['$lastName'] = $contact->lastName;
            }
            if (isset($numbers[0])) {
                $data['$phone1'] = $numbers[0];
            }
            if (isset($numbers[1])) {
                $data['$phone2'] = $numbers[1];
            }
            if (isset($numbers[2])) {
                $data['$phone3'] = $numbers[2];
            }
            $data['$id'] = $contact->id;
        }
    }
//    $save_database_handler = new Database();
//    $save_database_handler->editThisContact($id);    //siit mine Muuda ID all olevat kontakti fun
//    header("Location: ?cmd=main");
    $data['$id'] = $id;
    $data['$template'] = 'tpl/editContact.html';
    print render_template('tpl/main.html', $data);

} else if (strpos($cmd, 'saveEdit') !== false) {
    $findID = explode("_", $cmd);
    $id = $findID[2];
    $edit_database_handler = new Database();
    $edit_database_handler->editThisContact($id);
    var_dump($id);
    header("Location: ?cmd=main");

} else if ($cmd === 'save') {
    if (isset($_POST["firstName"]) & isset($_POST["lastName"]) & isset($_POST["phone1"])) {
        $errors1 = validate_todo_item($_POST["firstName"]);
        $errors2 = validate_todo_item($_POST["lastName"]);
        $errors3 = validate_todo_item($_POST["phone1"]);
        if (strlen($errors1) == 0 && strlen($errors2) == 0 && strlen($errors3) == 0) {
            $save_database_handler = new Database();
            $save_database_handler->saveAllContacts();
            header("Location: ?cmd=main");
        } else {
            $errors[] = '';
            array_push($errors, $errors1, $errors2, $errors3);
            $data['$errors'] = $errors;
            $data['$firstName'] = $_POST['firstName'];
            $data['$lastName'] = $_POST['lastName'];
            $data['$phone1'] = $_POST['phone1'];
            $data['$phone2'] = $_POST["phone2"];
            $data['$phone3'] = $_POST["phone3"];
            $data['$template'] = 'tpl/secondADDpage.html';
            print render_template('tpl/main.html', $data);
        }
    }
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


?>

