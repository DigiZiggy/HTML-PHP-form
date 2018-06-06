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

    function saveAllContacts() {
        // prepare sql statement to insert contact
        $statement = $this->connection->prepare(
            "INSERT INTO contacts (firstName, lastName) values (?, ?);");
        $statement->execute(array($_POST["firstName"],$_POST["lastName"]));
        //viimasena lisatud id j2rgi poogin kylge ka telefoni numbrid tollele id'le niioelda
        $contact_id = $this->connection->lastInsertId();
        $statement = $this->connection->prepare(
            "INSERT INTO numbers (number, contact_id, type) values (?, ?, ?);");
        $statement->execute(array($_POST["phone1"], $contact_id, 'phone1'));
        if (isset($_POST["phone2"]) && !empty($_POST["phone2"])) {
            $statement = $this->connection->prepare(
                "INSERT INTO numbers (number, contact_id, type) values (?, ?, ?);");
            $statement->execute(array($_POST["phone2"], $contact_id, 'phone2'));
        }
        if (isset($_POST["phone3"]) && !empty($_POST["phone3"])) {
            $statement = $this->connection->prepare(
                "INSERT INTO numbers (number, contact_id, type) values (?, ?, ?);");
            $statement->execute(array($_POST["phone3"], $contact_id, 'phone3'));
        }
    }


    function editThisContact($contact_id) {
        $statement = $this->connection->prepare(
            "UPDATE contacts set firstName = ?, lastName = ? WHERE id = $contact_id");
        $statement->execute(array($_POST["firstName"],$_POST["lastName"]));

        $statement = $this->connection->prepare(
            "delete from numbers where contact_id = ?");
        $statement->execute(array($contact_id));

        $statement = $this->connection->prepare(
            "INSERT INTO numbers (number, contact_id, type) values (?, ?, ?);");
        $statement->execute(array($_POST["phone1"], $contact_id, 'phone1'));
        if (isset($_POST["phone2"]) && !empty($_POST["phone2"])) {
            $statement = $this->connection->prepare(
                "INSERT INTO numbers (number, contact_id, type) values (?, ?, ?);");
            $statement->execute(array($_POST["phone2"], $contact_id, 'phone2'));
        }
        if (isset($_POST["phone3"]) && !empty($_POST["phone3"])) {
            $statement = $this->connection->prepare(
                "INSERT INTO numbers (number, contact_id, type) values (?, ?, ?);");
            $statement->execute(array($_POST["phone3"], $contact_id, 'phone3'));
        }

//        $statement = $this->connection->prepare(
//            "UPDATE numbers set number = ?, contact_id = ?, type = ? WHERE contact_id = $contact_id");
//        $statement->execute(array($_POST["phone1"], $contact_id, 'phone1'));
//        if (isset($_POST["phone2"]) && !empty($_POST["phone2"])) {
//            $statement = $this->connection->prepare(
//                "UPDATE numbers set number = ?, contact_id = ?, type = ? WHERE contact_id = $contact_id");
//            $statement->execute(array($_POST["phone2"], $contact_id, 'phone2'));
//        }
//        if (isset($_POST["phone3"]) && !empty($_POST["phone3"])) {
//            $statement = $this->connection->prepare(
//                "UPDATE numbers set number = ?, contact_id = ?, type = ? WHERE contact_id = $contact_id");
//            $statement->execute(array($_POST["phone3"], $contact_id, 'phone3'));
//        }

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
