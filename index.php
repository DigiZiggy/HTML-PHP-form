<?php
require_once ("Database.php");
require_once ("Contact.php");
require "lib/tpl.php";

$cmd = param('cmd') ? param('cmd') : 'main';
//session_start();
$data = [];


if ($cmd === 'main') {
    $database_handler = new Database();
    $all_contacts = $database_handler->getAllContacts();
    $data = ['$all_contacts' => $all_contacts];
    $data['$template'] = 'tpl/list.html';
    print render_template('tpl/main.html', $data);

} else if ($cmd === 'add'){
    $data['$template'] = 'tpl/secondADDpage.html';
    print render_template('tpl/main.html', $data);

} else if ($cmd === 'save') {
    $connection = new PDO('sqlite:data.sqlite');
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // prepare sql statement to insert contact
    $statement = $connection->prepare(
        "INSERT INTO contacts (firstName, lastName) values (?, ?);");
    $statement->execute(array($_POST["firstName"],$_POST["lastName"]));
    $contact_id = $connection->lastInsertId();
    $statement = $connection->prepare(
        "INSERT INTO numbers (number, contact_id, type) values (?, ?, ?);");
    $statement->execute(array($_POST["phone1"], $contact_id, 'phone1'));
    if (isset($_POST["phone2"]) && !empty($_POST["phone2"])) {
        $statement = $connection->prepare(
            "INSERT INTO numbers (number, contact_id, type) values (?, ?, ?);");
        $statement->execute(array($_POST["phone2"], $contact_id, 'phone2'));
    }
    if (isset($_POST["phone3"]) && !empty($_POST["phone3"])) {
        $statement = $connection->prepare(
            "INSERT INTO numbers (number, contact_id, type) values (?, ?, ?);");
        $statement->execute(array($_POST["phone3"], $contact_id, 'phone3'));
    }

    header("Location: ?cmd=main");
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

