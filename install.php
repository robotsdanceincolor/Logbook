<?php

define('SAFE',true);
include './config.php';

SQL::connect();
$result = SQL::query('SHOW TABLES LIKE "entries"');

if (count($result))
{
    print '<h1>Installed! You should delete this file now.</h1>
    <a href="./">Go to Calendar</a>';
}
else
{
    $query = "CREATE TABLE `entries` (`id` INT(11) AUTO_INCREMENT PRIMARY KEY,`date` DATE,`text` TEXT)";
    SQL::query($query);
    header('location: ./install.php');
}

?>
