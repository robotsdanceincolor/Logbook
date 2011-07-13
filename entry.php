<?php // Entry view

// Something went wrong
if (!isset($_GET['date']))
    die;

define('SAFE', true);
include './config.php';

SQL::connect();
$query = 'SELECT * FROM `entries` WHERE `date`=:date LIMIT 1';
$entries = SQL::query($query,array(':date' => $_GET['date']));

$date = $_GET['date'];
$text = '';
if (count($entries) != 0)
    $text = $entries[0]['text'];

// return to associated month / year in calendar view
$date_exp = explode('-', $date);
$back_link = "./index.php?month={$date_exp[1]}&year={$date_exp[0]}";

include ROOT . '/inc/header.php';

?>

<a href="<?php echo $back_link; ?>"><button>Back</button></a>

<form id="from_entry">
    <p>
        <label>Date</label>
        <input id="input_date" readonly="true" type="text" value="<?php echo $_GET['date']; ?>" />
    </p>
    <p><textarea id="textarea_text" cols="50" rows="20" name="text"><?php echo $text; ?></textarea></p>
    <p style="text-align:right;">
        <span id="save_status"></span>
        <input type="button" value="Save" onclick="save_entry();" />
    </p>
</form>

<?php include ROOT . '/inc/footer.php'; ?>
