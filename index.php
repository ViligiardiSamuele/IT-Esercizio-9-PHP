<?php
session_start();
require("colori.php");
$lunghezza_sequenza = 4;
$end_game = false;
$indovinato = false;

//contenitore tentativi
if (!isset($_SESSION["sequenze"]))
    $_SESSION["sequenze"] = array();

//generazione sequenza randomica di colori da indovinare
if (!isset($_SESSION["sequenza_random"])) {
    $_SESSION["sequenza_random"] = array();
    for ($i = 0; $i < $lunghezza_sequenza; $i++) {
        array_push($_SESSION["sequenza_random"], array_values($COLORI)[array_rand(array_keys($COLORI), 1)]);
    }
}
/**/
echo '<p>Debug: ';
foreach ($_SESSION['sequenza_random'] as $color) {
    echo $color . ' ';
}
echo '</p>';

if (isset($_POST["colore1"])) {
    //creazione del tentativo
    $sequenza = array();
    for ($i = 0; $i < $lunghezza_sequenza; $i++) {
        array_push($sequenza, $_POST["colore" . ($i + 1)]);
    }
    //confronto tentativo con sequenza_randomica
    $indovinato = true;
    for ($i = 0; $i < $lunghezza_sequenza; $i++)
        if ($COLORI[$sequenza[$i]] != $_SESSION["sequenza_random"][$i]) {
            $indovinato = false;
        }
    //salvataggio tentativo se inesatto
    if (!$indovinato)
        array_push($_SESSION["sequenze"], $sequenza);
}
echo '
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body data-bs-theme="dark">';
echo '<h1 class="text-center">Gioco del MasterMind</h1>';
echo '<p class="text-center">⚫ = Posizione corretta | ⚪ = Posizione sbagliata | ❌ = Non esiste</p>';
echo '<div class="card m-2 w-50 mx-auto sfumatura-1">';
echo '<div class="card-body">';
echo '<div class="card mb-1">';
echo '<div class="card-body">';
if ($indovinato) {
    echo '<h1>Hai <b>indovinato</b> la sequenza in ' . (count($_SESSION["sequenze"]) + 1) . ' tentativi</h1>';
} else if (count($_SESSION['sequenze']) >= 10) {
    //tentativi esauriti
    echo '<h1>Hai raggiunto il numero massimo di tentativi</h1>';
    $end_game = true;
} else {
    //form inserimento tentativo
    echo '<form method="POST" action="#">';
    echo '<table class="table">';
    echo '<thead>';
    for ($i = 0; $i < $lunghezza_sequenza; $i++)
        echo '<th scope="col">C' . ($i + 1) . '</th>';
    echo '</thead>';
    echo '<tbody>';
    echo '<tr>';
    for ($i = 0; $i < 4; $i++) {
        echo '<td scope="row">';
        echo '<select required name="colore' . ($i + 1) . '">';
        echo '<option class="option-width" default></option>';
        foreach ($COLORI as $nome => $emoji) {
            echo '<option class="option-width" value="' . $nome . '">' . $emoji . '</option>';
        }
        echo '</select>';
        echo '</td>';
    }
    echo '<td>';
    echo '<button type="submit" class="btn btn-success">✓</button>';
    echo '</td>';
    echo '</tr>';
    echo '</tbody>';
    echo '</table>';
    echo '</form>';
}
echo '</div>';
echo '</div>';


//tabella tentativi
echo '<div class="card">';
echo '<div class="card-body">';
if (count($_SESSION["sequenze"]) != 0) {

    echo '<table class="table">';
    echo '<thead>';
    echo '<th scope="col">Num</th>';
    for ($i = 0; $i < $lunghezza_sequenza; $i++)
        echo '<th scope="col">C' . ($i + 1) . '</th>';
    echo '<th scope="col">Indicatori</th>';
    echo '</thead>';
    echo '<tbody>';
    $count = 0;
    foreach ($_SESSION['sequenze'] as $sequenza) {
        $count++;
        echo '<tr>';
        echo '<td scope="row">' . $count . '</td>';
        foreach ($sequenza as $colore) {
            echo '<td>' . $COLORI[$colore] . '</td>';
        }
        // -- logica indicatori --
        $indicatori = array();
        for ($i = 0; $i < $lunghezza_sequenza; $i++) {
            //controllo che il colore sia contenuto
            if (in_array($COLORI[$sequenza[$i]], $_SESSION["sequenza_random"])) {
                //controllo che il colore sia nella stessa posizione
                //echo $COLORI[$sequenza[$i]] . ' --- ' . $_SESSION["sequenza_random"][$i];
                if ($COLORI[$sequenza[$i]] == $_SESSION["sequenza_random"][$i]) {
                    array_push($indicatori, $black);
                } else {
                    array_push($indicatori, $white);
                }
            } else array_push($indicatori, '❌');
        }
        //stampa indicatori
        echo "<td>";
        foreach ($indicatori as $colore) {
            echo $colore;
        }
        echo "</td>";
        echo '</tr>';
    }
}
if ($end_game || $indovinato) {
    session_destroy();
    echo '<a class="btn btn-primary text-center" href="index.php" role="button">Inizia una nuova partita</a>';
}
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

echo '</tbody>';
echo '</table>';
echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>';
echo '</body>';
echo '</html>';
