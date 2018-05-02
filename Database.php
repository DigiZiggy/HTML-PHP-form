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
            //returnin database'ist numbreid array'na, ja liimin nad kokku yheks suureks stringiks
            $contact_numbers = $this->getNumbersByContactID($id);
            $contact->numbers = implode(", ", $contact_numbers);

            $contacts[$id] = $contact;

        }
        return $contacts;
    }

    function getNumbersByContactID($contact_id) {
        $statement = $this->connection->prepare(
            "select * from numbers where contact_id = ?");
         $statement->execute(array($contact_id));
         $numbers = [];
        foreach ($statement as $row) {
            $numbers[] = $row["number"];

        }
        return $numbers;
    }
}
