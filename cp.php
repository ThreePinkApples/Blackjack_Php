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

$maxSize = 6;
$minSize = 1;

$minSplits = 0;
$maxSplits = 3;

$minCharlie = 5;
$maxCharlie = 10;

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

    if($_POST['charlieAmount'] > $maxCharlie)
        $_SESSION['charlieAmount'] = $maxCharlie;
    elseif($_POST['charlieAmount'] < $minCharlie)
        $_SESSION['charlieAmount'] = $minCharlie;
    else
        $_SESSION['charlieAmount'] = $_POST['charlieAmount'];

    $_SESSION['aceHitSplit'] = isset($_POST['aceHitSplit']) ? $_POST['aceHitSplit'] : False;
    $_SESSION['aceReSplit'] = isset($_POST['aceReSplit']) ? $_POST['aceReSplit'] : False;
    $_SESSION['double'] = isset($_POST['double']) ? $_POST['double'] : False;
    $_SESSION['doubleType'] = $_POST['doubleType'];
    $_SESSION['doubleAfterSplit'] = isset($_POST['doubleAfterSplit']) ? $_POST['doubleAfterSplit'] : False;
    $_SESSION['useCharlie'] = isset($_POST['useCharlie']) ? $_POST['useCharlie'] : False;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/blackjack.css">
</head>
<body>
<h2>Blackjack Settings</h2>
<form method="POST">

    <div id="soft17" class="blackjack-option">
        <input type="checkbox" name="soft17" id="soft17" <?php echo isset($_SESSION['soft17']) && $_SESSION['soft17'] ? 'checked' : '' ?> /> Allow dealer to draw on soft 17.
    </div>
    
    <div id="charlieOptions" class="blackjack-option">
        <input type="checkbox" name="useCharlie" <?php echo isset($_SESSION['useCharlie']) && $_SESSION['useCharlie'] ? 'checked' : '' ?> /> Activate Charlie rules.
        <br />
        <input type="number" name="charlieAmount" min="<?php echo $minCharlie ?>" max="<?php echo $maxCharlie ?>" value="<?php echo isset($_SESSION['charlieAmount']) ? $_SESSION['charlieAmount'] : '5' ?>" /> Number of cards needed to get Charlie.
    </div>

    <div id="message" class="blackjack-option">
        <label>Message to be shown to players</label>
        <br />
        <textarea name="message"><?php echo isset($_SESSION['message']) ? $_SESSION['message'] : '' ?></textarea>
    </div>

    <div id="size" class="blackjack-option">
        <input type="number" name="size" min="<?php echo $minSize ?>" max="<?php echo $maxSize ?>" <?php echo isset($_SESSION['size']) ? 'value="'.$_SESSION['size'].'"' : '' ?> /> Number of decks.
    </div>

    <div id="maxbet" class="blackjack-option">
        <input type="number" name="maxbet" min="<?php echo $minMaxbet ?>" max="<?php echo $maxMaxbet ?>" value="<?php echo isset($_SESSION['maxbet']) ? $_SESSION['maxbet'] : '1000000' ?>" /> Max amount player can bet.
    </div>

    <div id="maxSplits" class="blackjack-option">
        <input type="number" name="maxSplits" min="<?php echo $minSplits ?>" max="<?php echo $maxSplits ?>" value="<?php echo isset($_SESSION['maxSplits']) ? $_SESSION['maxSplits'] : '3' ?>" /> Max number of splits allowed.
    </div>

    <div id="aceHitSplit" class="blackjack-option">
        <input type="checkbox" name="aceHitSplit" <?php echo isset($_SESSION['aceHitSplit']) && $_SESSION['aceHitSplit'] ? 'checked' : '' ?> /> Player can hit after splitting aces.
    </div>

    <div id="aceReSplit" class="blackjack-option">
        <input type="checkbox" name="aceReSplit" <?php echo isset($_SESSION['aceReSplit']) && $_SESSION['aceReSplit'] ? 'checked' : '' ?> /> Player can re-split aces (other cards can always be re-splitted).
    </div>

    <div id="double" class="blackjack-option">
        <input type="checkbox" name="double" <?php echo isset($_SESSION['double']) && $_SESSION['double'] ? 'checked' : '' ?> /> Player can double.
    </div>

    <div id="doubleType" class="blackjack-option">
        <select name="doubleType">
            <option value="any" <?php echo isset($_SESSION['doubleType']) && $_SESSION['doubleType'] === 'any' ? 'selected' : '' ?>>Any cards</option>
            <option value="9-11" <?php echo isset($_SESSION['doubleType']) && $_SESSION['doubleType'] === '9-11' ? 'selected' : '' ?>>Only sums 9 - 11</option>
            <option value="10-11" <?php echo isset($_SESSION['doubleType']) && $_SESSION['doubleType'] === '10-11' ? 'selected' : '' ?>>Only sums 10 - 11</option>
        </select>
        When a player can double
    </div>

    <div id="doubleAfterSplit" class="blackjack-option">
        <input type="checkbox" name="doubleAfterSplit" <?php echo isset($_SESSION['doubleAfterSplit']) && $_SESSION['doubleAfterSplit'] ? 'checked' : '' ?> /> Player can double after split.
    </div>

    <button type="submit" name="save" id="save">Save</button>
    <br />
    <a href="index.php">To game</a>
</form>

</body>
</html>

