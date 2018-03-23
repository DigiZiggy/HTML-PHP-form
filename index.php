<!DOCTYPE html>
<html lang="et">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href ="style.css" rel="stylesheet" type="text/css">
        <title>Harjutustund 1</title>
        <style>


        </style>
    </head>
    <body>


        <div id="tab">
        <a href="index.php" id="list-page-link">Nimekiri</a>
            <a> | </a>
        <a href="secondpage.php" id="add-page-link">Lisa</a></div>


         <table class = "table">
             <tr>
                 <th>Eesnimi</th>
                 <th>Perekonnanimi</th>
                 <th>Telefonid</th>
             </tr>
             <tr>
                 <?php
                 require_once("todofunctions.php");
                 $items = get_items();
                 $lines = file('data.txt');
                    foreach ($lines as $line) {
                        print $line;
                    }
                 ?>
             </tr>
             <tr>
                 <td>
                     <span>SIgird</span>
                 </td>
                 <td>
                     <span>Narep</span>
                 </td>
                 <td>
                     <span>937625171</span>
                 </td>
             </tr>
             <tr>
                 <td>
                     <span>Charly</span>
                 </td>
                 <td>
                     <span>Bean</span>
                 </td>
                 <td>
                     <span>08217333</span>
                 </td>
             </tr>
        </table>


        <footer>
            <div id="footer">
                <p>ICD0007 Näidisrakendus</p>
            </div>
        </footer>
        
    </body>
</html>