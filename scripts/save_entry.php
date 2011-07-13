<?php

// If the entry exists, the row is updated.
// If $_POST['text'] is empty, then it's deleted.
// Else, a new entry is inserted.

// Something is wrong
if (!isset($_POST['date']))
    die;

define('SAFE',true);
include '../config.php';

$date = $_POST['date'];
$text = $_POST['text'];

SQL::connect();
$query = "SELECT `id` FROM `entries` WHERE `date`='$date' LIMIT 1";
$entries = SQL::query($query);

$query = null;
$kvp = array('date' => $date);
if (count($entries))
    if (strlen($text))
    {
        $query = 'UPDATE `entries` SET `text`=:text WHERE `date`=:date';
        $kvp[':text'] = $text;
    }
    else
        $query = 'DELETE FROM `entries` WHERE `date`=:date';
else
{
    $query = 'INSERT INTO `entries` (`date`,`text`) VALUES (:date,:text)';
    $kvp[':text'] = $text;
}

$saved = SQL::query($query,$kvp);

$time = date('h:m:i',time());
if (count($saved))
    echo "Save Sucessful: $time";
else
    echo "Save Failed: $time"; 

?>
