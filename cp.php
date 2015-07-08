<?php
/**
 * Created by PhpStorm.
 * User: Øyvind
 * Date: 05.07.2015
 * Time: 15.26
 */
session_start();

$maxMaxbet = 80000000;
$minMaxbet = 1000000;

$maxSize = 5;
$minSize = 1;

$minSplits = 0;
$maxSplits = 3;

if(isset($_POST['save'])){
    $_SESSION['soft17'] = isset($_POST['soft17']) ? $_POST['soft17'] : False;
    $_SESSION['fiveCharlie'] = isset($_POST['charlie']) ? $_POST['charlie'] : False;
    $_SESSION['message'] = $_POST['message'];

    if($_POST['size'] > $maxSize)
        $_SESSION['size'] = $maxSize;
    elseif($_POST['size'] < $minSize)
        $_SESSION['size'] = $minSize;
    else
        $_SESSION['size'] = $_POST['size'];

    if($_POST['maxbet'] > $maxMaxbet)
        $_SESSION['maxbet'] = $maxMaxbet;
    elseif($_POST['maxbet'] < $minMaxbet)
        $_SESSION['maxbet'] = $minMaxbet;
    else
        $_SESSION['maxbet'] = $_POST['maxbet'];

    if($_POST['maxSplits'] > $maxSplits)
        $_SESSION['maxSplits'] = $maxSplits;
    elseif($_POST['maxSplits'] < $minSplits)
        $_SESSION['maxSplits'] = $minSplits;
    else
        $_SESSION['maxSplits'] = $_POST['maxSplits'];

    $_SESSION['double'] = isset($_POST['double']) ? $_POST['double'] : False;
    $_SESSION['doubleAfterSplit'] = isset($_POST['doubleAfterSplit']) ? $_POST['doubleAfterSplit'] : False;
}

?>

<!DOCTYPE html>
<html>
<head>

</head>
<body>

<form method="POST">

    <div id="soft17">
        <input type="checkbox" name="soft17" id="soft17" <?php echo isset($_SESSION['soft17']) && $_SESSION['soft17'] ? 'checked' : '' ?> /> Allow dealer to draw on soft 17.
    </div>

    <div id="charlie">
        <input type="checkbox" name="charlie" <?php echo isset($_SESSION['fiveCharlie']) && $_SESSION['fiveCharlie'] ? 'checked' : '' ?> /> Let player win on a "Five-card Charlie".
    </div>

    <div id="message">
        <label>Message to be shown to players</label>
        <br />
        <textarea name="message"><?php echo isset($_SESSION['message']) ? $_SESSION['message'] : '' ?></textarea>
    </div>

    <div id="size">
        <input type="number" name="size" min="<?php echo $minSize ?>" max="<?php echo $maxSize ?>" <?php echo isset($_SESSION['size']) ? 'value="'.$_SESSION['size'].'"' : '' ?> /> Number of decks.
    </div>

    <div id="maxbet">
        <input type="number" name="maxbet" min="<?php echo $minMaxbet ?>" max="<?php echo $maxMaxbet ?>" value="<?php echo isset($_SESSION['maxbet']) ? $_SESSION['maxbet'] : '1000000' ?>" /> Max amount player can bet.
    </div>

    <div id="maxSplits">
        <input type="number" name="maxSplits" min="<?php echo $minSplits ?>" max="<?php echo $maxSplits ?>" value="<?php echo isset($_SESSION['maxSplits']) ? $_SESSION['maxSplits'] : '3' ?>" /> Max number of splits allowed.
    </div>

    <div id="double">
        <input type="checkbox" name="double" <?php echo isset($_SESSION['double']) && $_SESSION['double'] ? 'checked' : '' ?> /> Player can double.
    </div>

    <div id="doubleAfterSplit">
        <input type="checkbox" name="doubleAfterSplit" <?php echo isset($_SESSION['doubleAfterSplit']) && $_SESSION['doubleAfterSplit'] ? 'checked' : '' ?> /> Player can double after split.
    </div>

    <button type="submit" name="save" id="save">Save</button>
</form>

</body>
</html>

