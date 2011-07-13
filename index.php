<?php // Calendar view

define('SAFE',true);
include './config.php';

// Get the date in F, ex.: 01
$month = date('m',time());
if (isset($_GET['month']))
    $month = $_GET['month'];

// Get the date in Y, ex.: 2011
$year = date('Y',time());
if (isset($_GET['year']))
    $year = $_GET['year'];

$start_date = strtotime("$year-$month-01");

SQL::connect();
$query = 'SELECT * FROM `entries` WHERE MONTH(`date`)=:month AND YEAR(`date`)=:year';
$entries = SQL::query($query,array(':month' => $month,':year' => $year));

$prev_month = date('m', strtotime('-1 month',$start_date));
$next_month = date('m', strtotime('+1 month',$start_date));

$prev_year = date('Y', strtotime('-1 year',$start_date));
$next_year = date('Y', strtotime('+1 year',$start_date));

// Use: sprintf($link,$month,$year,$text)
$link = '<a href="'.$_SERVER['PHP_SELF'].'?month=%s&year=%s">%s</a>';

// Start building calendar HTML
$cal = array();

// Build calendar's header; Use $link for time
$buffer = array(
    '<tr class="head">',
    '<td>'.sprintf($link,$month,$prev_year,$prev_year).'</td>',
    EMPTY_COLUMN,EMPTY_COLUMN,"<td>$year</td>",EMPTY_COLUMN,EMPTY_COLUMN,
    '<td>'.sprintf($link,$month,$next_year,$next_year).'</td>',
    '</tr><tr class="head">',
    '<td>'.sprintf($link,$prev_month,$year,$prev_month).'</td>',
    EMPTY_COLUMN,EMPTY_COLUMN,"<td>$month</td>",EMPTY_COLUMN,EMPTY_COLUMN,
    '<td>'.sprintf($link,$next_month,$year,$next_month).'</td>',
    '</tr>'
    );
foreach ($buffer as $b) { $cal[] = $b; }
$buffer = array();

// $days is defined in "config.php"
$cal[] = '<tr id="days">';
foreach ($days as $d)
    $cal[] = "<td>$d</td>";
$cal[] = '</tr>';

// Build first week
$blank_days = date('N',$start_date);
$iter = 0;
$cal[] = '<tr>';
for ($i = 0; $i < $blank_days; $i++,$iter++)
    $cal[] = EMPTY_COLUMN;

// Build remaining days
$range = range(1, date('t',$start_date));
foreach ($range as $d)
{
    if ($iter % 7 == 0)
        $cal[] = '</tr><tr>';
    $date = "$year-$month-$d";

    $class = 'date';
    foreach ($entries as $entry)
    {
        if ($date == $entry['date'])
            $class .= ' entry';
    }
    $cal[] =  "<td class=\"$class\" date=\"$date\">$d</td>";
    $iter++;
} 

// Fill the remaining columns
while ($iter % 7 != 0)
{
        $cal[] = EMPTY_COLUMN;
        $iter++;
}
$cal[] = '</tr>';

include ROOT . '/inc/header.php';

?>

<center><table id="cal"><?php foreach ($cal as $c) { print $c; } ?></table></center>

<?php include ROOT . '/inc/footer.php'; ?>
