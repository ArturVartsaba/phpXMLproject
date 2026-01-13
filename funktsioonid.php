<?php
//Uudiste lugemise funktsioon
function uudised($url, $kogus)
{
    $feed=simplexml_load_file($url);
    echo "<ul>";
    echo "kuupäev: ".date("d.m.Y", $feed->channel->item->pubDate);
    $loendur=0;
    foreach ($feed->channel->item as $item){
        if($loendur<=$kogus){
            echo "<li>";
            echo "<a href='$item->link' target='_blank'>".$item->title."</a>";
            echo $item->description;
            echo "<img src='$item->image'>";
            echo "</li>";
            $loendur++;
        }
    }
    echo "</ul>";
}