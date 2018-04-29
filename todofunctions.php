<?php

const DATA_FILE = "data.txt";



//function add_firstName($firstName) {
//    if (isset($firstName) && $firstName !== "") {
//        $items = get_items();
//        if (!in_array($firstName, $items)) {
//            file_put_contents(DATA_FILE, $firstName.";", FILE_APPEND);
//        }
//    }
//}
//
//function add_lastName($lastName) {
//    if (isset($lastName) && $lastName !== "") {
//        $items = get_items();
//        if (!in_array($lastName, $items)) {
//            file_put_contents(DATA_FILE, $lastName.";", FILE_APPEND);
//        }
//    }
//}
//
//function add_phone($phone) {
//    if (isset($phone) && $phone !== "") {
//        $items = get_items();
//        if (!in_array($phone, $items)) {
//            file_put_contents(DATA_FILE, $phone . PHP_EOL, FILE_APPEND);
//        }
//    }
//}

$connection = new PDO('sqlite:data.sqlite');
// set the PDO error mode to exception
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function getAllContacts() {
    $statement = $connection->prepare("SELECT * FROM contacts");
    $statement->execute();
}

function getNumbers() {

}


function get_items() {
    $lines = file('data.txt');
    $items = [];

    foreach ($lines as $line) {
        $individual = explode(';', trim($line));
        array_push($items, $individual);
        }
    return $items;
}


/**
 * Created by PhpStorm.
 * User: sigridnarep
 * Date: 18/3/18
 * Time: 9:14 PM
 */