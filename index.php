<?php
require_once ("Database.php");
require_once ("Contact.php");
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
    return $errorMessages;
}


if ($cmd === 'main') {

    $database_handler = new Database();
    $all_contacts = $database_handler->getAllContacts();
    $data = ['$all_contacts' => $all_contacts];
    $data['$template'] = 'tpl/list.html';

} else if ($cmd === 'ADDlisa') {
    $data['$template'] = 'tpl/secondADDpage.html';


} else if ($cmd === 'add') {

    $url=strtok($_SERVER["REQUEST_URI"],'?');
    header("Location: ".$url.'?cmd=main');

    if (isset($_POST["firstName"]) & isset($_POST["lastName"]) & isset($_POST["phone1"])) {
        $errors1 = validate_todo_item($_POST["firstName"]);
        $errors2 = validate_todo_item($_POST["lastName"]);
        $errors3 = validate_todo_item($_POST["phone1"]);
        if (strlen($errors1) == 0 && strlen($errors2) == 0 && strlen($errors3) == 0) {

            try {
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
            }
            catch(PDOException $e)
            {
                echo "Connection failed: " . $e->getMessage();
            }
        } else {
            $errors[] = '';
            array_push($errors, $errors1, $errors2, $errors3);
            $database_handler = new Database();
            $all_contacts = $database_handler->getAllContacts();
            $data = ['$all_contacts' => $all_contacts];
            $data['$errors'] = $errors;
            $data['$template'] = 'tpl/list.html';

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

print render_template('tpl/main.html', $data);



?>

