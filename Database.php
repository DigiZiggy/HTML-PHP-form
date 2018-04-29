<?php
/**
 * Created by PhpStorm.
 * User: sigridnarep
 * Date: 28/4/18
 * Time: 3:32 PM
 */

class Database
{
    private $connection;

    function __construct() {
        $this->connection = new PDO('sqlite:data.sqlite');
        $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }

    function getAllContacts() {

        $statement = $this->connection->prepare(
            "select * from contacts");
        $statement->execute();

        $contacts = [];
        foreach ($statement as $row) {
            $id = $row["id"];
            $firstName = $row["firstName"];
            $lastName = $row["lastName"];


            $contact = new Contact();
            $contact->id = $id;
            $contact->firstName = $firstName;
            $contact->lastName = $lastName;

            $numbers = $this->getNumbersByContactID($id);
             foreach ($numbers as $number) {

             };
            $contact->addNumber($row["number"]);
            $contacts[$id] = $contact;

        }
        return array_values($contacts);
    }

    function getNumbersByContactID($contact_id) {
        $statement = $this->connection->prepare(
            "select * from numbers where contact_id = ?");
        return $statement->execute(array($contact_id));
    }
}