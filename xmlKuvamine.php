<?php
function lisaOpilane()
{
    $xmlDoc = new DOMDocument("1.0", "UTF-8");
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->load("opilased.xml");
    $xmlDoc->formatOutput = true;

    $xmlOpilane = $xmlDoc->createElement("opilane");
    $xmlDoc->appendChild($xmlOpilane);

    $xmlRoot = $xmlDoc->documentElement;
    $xmlRoot->appendChild($xmlOpilane);

    $elukoht = $xmlDoc->createElement("elukoht");
    $xmlOpilane->appendChild($elukoht);
    unset($_POST["submit"]);

    foreach ($_POST as $voti => $vaartus)
    {
        $kirje = $xmlDoc->createElement($voti, $vaartus);

        if ($voti == "linn" || $voti == "maakond")
            $elukoht->appendChild($kirje);
        else
            $xmlOpilane->appendChild($kirje);
    }

    $xmlDoc->save("opilased.xml");
    header("Refresh:0");
}

$opilased=simplexml_load_file("opilased.xml");

//õpilase otsing
function erialaOtsing($paring)
{
    global $opilased;
    $tulemus=array();
    foreach ($opilased->opilane as $opilane)
    {
        if (substr(strtolower($opilane->eriala), 0, strlen($paring)) == $paring)
        {
            array_push($tulemus, $opilane);
        }
        else if (substr(strtolower($opilane->nimi), 0, strlen($paring)) == $paring)
        {
            array_push($tulemus, $opilane);
        }
        else if (substr(strtolower($opilane->isikukood), 0, strlen($paring)) == $paring)
        {
            array_push($tulemus, $opilane);
        }
    }
    return $tulemus;
}

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="tableStyle.css">
    <title>XML faili kuvamine - Opilased.xml</title>
</head>
<body>
<h1>XML faili kuvamine - Opilased.xml</h1>
<?php
//1.õpilase nimi
echo "1.õpilase nimi: ".$opilased->opilane[0]->nimi;
?>
<form action="?" method="post">
    <label for="otsing">Otsi:</label>
    <input type="text" name="otsing" id="otsing" placeholder="Nimi | Eriala | Isikukood">
    <input type="submit" value="OK">
</form>
<?php
//otsingu tulemus:
if(!empty($_POST['otsing']))
{
    $tulemus=erialaOtsing($_POST['otsing']);

        echo " <table>
    <tr>
        <th>Õpilase nimi</th>
        <th>isikukood</th>
        <th>Eriala</th>
        <th>Elukoht</th>
    </tr>";

    foreach($tulemus as $opilane){
        echo "<tr>";
        echo "<td>".$opilane->nimi."</td>";
        echo "<td>".$opilane->isikukood."</td>";
        echo "<td>".$opilane->eriala."</td>";
        echo "<td>".$opilane->elukoht->linn."</td>", ".
        $opilane->elukoht->maakond.</th>";
        echo "</tr>";
    }
    echo "</table>";

} else {
?>
<table>
    <tr>
        <th>Õpilase nimi</th>
        <th>isikukood</th>
        <th>Eriala</th>
        <th>Elukoht</th>
    </tr>
    <?php
    foreach ($opilased->opilane as $opilane){
        echo "<tr>";
        echo "<td>".$opilane->nimi."</td>";
        echo "<td>".$opilane->isikukood."</td>";
        echo "<td>".$opilane->eriala."</td>";
        echo "<td>".$opilane->elukoht->linn."</td>", ".
        $opilane->elukoht->maakond.</th>";
        echo "</tr>";
    }
    }
    ?>
</table>

<h2>Õpilase sisestamine</h2>

<form>
    <tr>
        <td><label for="nimi">Nimi:</label></td>
        <td><input type="text" id="nimi" name="nimi"></td>
    </tr>
    <br>
    <tr>
        <td><label for="isikukood">Isikukood:</label></td>
        <td><input type="text" id="isikukood" name="isikukood"></td>
    </tr>
    <br>
    <tr>
        <td><label for="eriala">Eriala:</label></td>
        <td><input type="text" id="eriala" name="eriala"></td>
    </tr>
    <br>
    <tr>
        <td><label for="elukoht">Elukoht:</label></td>
        <td><input type="text" id="elukoht" name="elukoht"></td>
    </tr>
    <br>
    <tr>
        <td><input type="submit" id="submit" name="submit" value="Sisesta"></td>
        <td></td>
    </tr>
</form>

<?php
    if(isset($_POST['submit']))
    {
       lisaOpilane();
       echo "<p>Õpilane on lisatud!</p>";
    }
?>

</body>
</html>
