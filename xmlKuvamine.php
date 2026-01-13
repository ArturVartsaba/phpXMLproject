<?php
$opilased=simplexml_load_file("opilased.xml");
$feed=simplexml_load_file("https://www.err.ee/rss");
?>
<!DOCTYPE html>
<html>
<head>
    <title>XML faili kuvamine - Opilased.xml</title>
</head>
<body>
<h1>XML faili kuvamine - Opilased.xml</h1>
<?php
//1.õpilase nimi
echo "1.õpilase nimi: ".$opilased->opilane[0]->nimi;
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
    ?>
</table>
<h1>RSS uudiste lugemine </h1>
<?php
echo "<ul>";
foreach ($feed->channel->item as $item){
    echo "<li>";
    echo "<a href='$item->link' target='_blank'>".$item->title."</a>";
    echo $item->description;
    echo "kuupäev: ".$item->pubDate;
    echo "</li>";
}
echo "</ul>";
?>
</body>
</html>
