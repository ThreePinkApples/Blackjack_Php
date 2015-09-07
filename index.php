<?php
/**
 * Created by PhpStorm.
 * User: Øyvind
 * Date: 05.07.2015
 * Time: 15.26
 */
session_start();

//Test data
$_SESSION['owner'] = 'aerandir92';
if(!isset($_SESSION['useCharlie'])) $_SESSION['useCharlie'] = False;
if(!isset($_SESSION['charlieAmount'])) $_SESSION['charlieAmount'] = 7;
if(!isset($_SESSION['soft17'])) $_SESSION['soft17'] = False;
if(!isset($_SESSION['message'])) $_SESSION['message'] = "Have fun!";
if(!isset($_SESSION['size'])) $_SESSION['size'] = 4;
if(!isset($_SESSION['maxbet'])) $_SESSION['maxbet'] = 10000000;

if(!isset($_SESSION['account'])) $_SESSION['account'] = 1000000000;
if(!isset($_SESSION['playerMoney'])) $_SESSION['playerMoney'] = 100000000;
if(!isset($_SESSION['maxSplits'])) $_SESSION['maxSplits'] = 3;
if(!isset($_SESSION['aceHitSplit'])) $_SESSION['aceHitSplit'] = False;
if(!isset($_SESSION['aceReSplit'])) $_SESSION['aceReSplit'] = True;
if(!isset($_SESSION['double'])) $_SESSION['double'] = True;
if(!isset($_SESSION['doubleType'])) $_SESSION['doubleType'] = '9-11';
if(!isset($_SESSION['doubleAfterSplit'])) $_SESSION['doubleAfterSplit'] = True;

if(!isset($_SESSION['acceptNewRound'])) $_SESSION['acceptNewRound'] = True;



$owner = $_SESSION['owner'];
$useCharlie = $_SESSION['useCharlie'];
$charlieAmount = $_SESSION['charlieAmount'];
$soft17 = $_SESSION['soft17'];
$message = $_SESSION['message'];
$size = $_SESSION['size'];
$maxbet = $_SESSION['maxbet'];
$account = $_SESSION['account'];
$playerMoney = $_SESSION['playerMoney'];
$maxSplits = $_SESSION['maxSplits'];
$aceHitSplit = $_SESSION['aceHitSplit'];
$aceReSplit = $_SESSION['aceReSplit'];
$double = $_SESSION['double'];
$doubleType = $_SESSION['doubleType'];
$doubleAfterSplit = $_SESSION['doubleAfterSplit'];

if(!isset($_SESSION['playing'])) $_SESSION['playing'] = False;

$_SESSION['index'] = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/blackjack.css">
    <script src="js/blackjack.js"></script>
</head>
<body>
<?php include('lang.php'); ?>
<section id="info" class="game-section container-fluid">
    <div id="welcome">
        <p><?php echo trans('welcome', ['owner' => $owner, 'account' => $account]) ?></p>
    </div>
    <div id="settings">
        <ul>
            <li><?php echo trans('maxbet', ['maxbet' => $maxbet]) ?></li>
            <li title="<?php echo trans('infoCharlie') ?>">
            <?php
            if ($useCharlie) echo trans('canCharlie', ['charlieAmount' => $charlieAmount]).'</li>';
            else echo trans('notCharlie').'</li>';

            echo '<li title="Soft 17 is when the sum is 17, but with an ace that counts as 11. Making it soft since it can also count as 7.">';
            if ($soft17) echo 'The dealer <b>have to</b> draw on a "soft 17". </li>';
            else echo 'The dealer <b>can\'t</b> draw on a "soft 17". </li>';

            echo '<li title="The number of decks may alter your winning chance.">';
            if ($size > 1) echo 'This casino uses ' . $size . ' decks</li>';
            else echo 'This casino uses 1 deck</li>';

            echo '<li title="If the two first cards in a hand have equal value it legal to split those two cards into separate hands with separat bets and results">';
            if($maxSplits > 1 || $maxSplits < 1) echo 'You are allowed to split ' . $maxSplits . ' times</li>';
            else echo 'You are allowed to split ' . $maxSplits . ' time</li>';

            echo '<li title="Re-splitting aces are situations where you started with two aces, then split, then receive another ace on one of those hands">';
            if($aceReSplit) echo 'You can re-split aces.</li>';
            else echo 'You <b>can\'t</b> re-split aces.</li>';

            echo '<li>';
            if($aceHitSplit) echo 'You can hit after splitting aces</li>';
            else echo 'You <b>can\'t</b> hit after splitting aces. Splitting aces will cause an automatic end of round.</li>';

            echo '<li title="In the beginning of a hand, when you have two cards, you can choose do double your bet. This will give you one more card and then the hand ends.">';
            if($double){
                if($doubleType === 'any') echo 'You can double down on any cards.</li>';
                elseif($doubleType === '9-11') echo 'You can only double on sums between 9 and 11</li>';
                elseif($doubleType === '10-11') echo 'You can only double on sums between 10 and 11</li>';
            }
            else echo 'You <b>can\'t</b> double down.</li>';

            if($double){
                echo '<li title="After you have split your current hand, you can also double it after receiving the second card.">';
                if($doubleAfterSplit) echo 'You can double down after a split</li>';
                else echo 'You <b>can\'t</b> double down after a split</li>';
            }

            ?>
        </ul>
    </div>
    <div id="message">
        <p>
            A little message from the owner: <pre><?php echo $message ?></pre>
        </p>
    </div>
    <br />
    <a href="cp.php" target="_blank">Controllpanel</a>
</section>
<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['bet']) && $_POST['bet'] >= 100 && $_POST['bet'] <= $maxbet){
        //Game starting
        $_SESSION['playing'] = True;
        $_SESSION['newRound'] = True;
    }
}

if(!$_SESSION['playing']) {
//Not in a game, section
?>
<section id="startGame" class="game-section container-fluid">
    <form method="POST" onsubmit="cripple();" class="form-inline">
        <div>
            <p>You have <?php echo '$'.$playerMoney ?> </p>
            <div class="form-group">
                <label for="bet">Bet: $</label>
                <input type="number" id="bet" class="form-control" name="bet" min="100" max="<?php echo $maxbet ?>" />
            </div>
            <button type="submit" name="start" id="start" class="btn btn-success" value="start">Play!</button>
            <?php
            if(isset($_SESSION['blackjackError'])) {
                echo '<p class="alert alert-danger bj-alert">'.$_SESSION['blackjackError'].'</p>';
                unset($_SESSION['blackjackError']);
            }
            ?>
        </div>
    </form>
</section>

<?php
}
else {
    include('blackjack.php');
?>
    <section id="game" class="game-section container-fluid">
        <?php echo $_SESSION['printedCards']; ?>
        <div id="errors">
            <?php
            if(isset($_SESSION['blackjackError'])) {
                echo '<p>'.$_SESSION['blackjackError'].'</p>';
                unset($_SESSION['blackjackError']);
            }
            ?>
        </div>
        <div id="money">
            <h5>You money: <?php echo '$'.$_SESSION['playerMoney'] ?></h5>
        </div>
    </section>
<?php
}
?>
</body>
</html>