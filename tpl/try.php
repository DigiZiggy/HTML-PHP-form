<?php

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

/**
 * Created by PhpStorm.
 * User: sigridnarep
 * Date: 29/4/18
 * Time: 11:05 PM
 */