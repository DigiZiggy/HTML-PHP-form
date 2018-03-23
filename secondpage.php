<!DOCTYPE html>
<html lang="et">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href ="style.css" rel="stylesheet" type="text/css">
        <title>Lisa</title>
    </head>
    <body>

        <div id="tab">
        <a href="index.php" id="list-page-link">Nimekiri</a>
            <a> | </a>
        <a href="secondpage.php" id="add-page-link">Lisa</a></div>


        <form method="post" id = "add-form" action="?cmd=add">
            <input type = "text" name="firstName">
            <p>Eesnimi:</p>
            <input type = "text" name="lastName">
            <p>Perekonna nimi:</p>
            <input type = "text" name="phone">
            <p>Telefonid:</p>
            <input type = "text" name="phone2">
            <input name="submit-button" type="submit" value="Salvesta">
        </form>

        <?php
        require_once("todofunctions.php");

        $cmd = isset($_GET["cmd"]) ? $_GET["cmd"] : "view";

        function validate_todo_item($item) {
            $errorMessages = [];

            if (empty($item)) {
                $errorMessages[] = "Väli ei või olla tühi!";
            }

            if (strlen($item) < 3) {
                $errorMessages[] = "Pikkus peab olema vähemalt 3 tähemärki";
            }

            if (strlen($item) > 20) {
                $errorMessages[] = "Pikku ei tohi olla suurem kui 20 tähemärki";
            }

            return $errorMessages;
        }

        if ($cmd == "view") {

            $items = get_items();
            $data = ['$items' => $items];

        } else if ($cmd == "add") {
            $data = [];
            header('Location: index.php');
            if (isset($_POST["firstName"])) {
                $errors = validate_todo_item($_POST["firstName"]);
                if (count($errors) == 0) {
                    add_firstName($_POST["firstName"]);
                } else {
                    $data['$errors'] = $errors;
                }
            } if (isset($_POST["lastName"])) {
                $errors = validate_todo_item($_POST["lastName"]);
                if (count($errors) == 0) {
                    add_lastName($_POST["lastName"]);
                } else {
                    $data['$errors'] = $errors;
                }
            } if (isset($_POST["phone"])) {
                $errors = validate_todo_item($_POST["phone"]);
                if (count($errors) == 0) {
                    add_phone($_POST["phone"]);
                } else {
                    $data['$errors'] = $errors;
                }
            }

            $data['$items'] = get_items();
        }
        ?>

        <footer>
            <div id="footer">
                <p>ICD0007 Näidisrakendus</p>
            </div>
        </footer>

    </body>
</html>