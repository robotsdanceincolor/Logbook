<?php

if (!defined('SAFE'))
    die;

// Fedora complained
date_default_timezone_set('America/Los_Angeles');

// Now we are not dependent on application location
define('ROOT',dirname(__FILE__));

// an abstract SQL class
include ROOT . '/lib/SQL.php';

// For use with MySQL database
define('SQL_HOST','localhost');
define('SQL_USER','username');
define('SQL_PASS','password');
define('SQL_BASE','logbook');
define('SQL_DSN','mysql:host='.SQL_HOST.';dbname='.SQL_BASE.';');

// For empty space in our calendar <table> -- for readability
define('EMPTY_COLUMN','<td>&nbsp</td>');
define('PER_PAGE',20);

$days = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');

?>
