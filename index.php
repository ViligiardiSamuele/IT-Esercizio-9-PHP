<?php
require("colori.php");
session_start();

if (!isset($_SESSION["sequenze"]))
    $_SESSION["sequenze"] = array();

echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Gioco del Master Mind</h1>
<form method="POST" action="#">
<table>
    <tr>';
for ($i = 0; $i < count($COLORI); $i++) {
    echo '<td><select required="true" name="colore' . ($i + 1) . '">
        <option default></option>';
    for ($j = 0; $j < count($COLORI); $j++) {
        echo '<option value="' . $COLORI[$j] . '">' . $COLORI[$j] . '</option>';
    }
    echo '</select></td>';
}
echo '
        <td><input type="submit"></td>
    </tr>
</table>
<br><br>
<table>';
for($i = 0; i < $_SESSION["sequenze"]; $i++){
    
}
</table>
';

echo '
</body>
</html>';
