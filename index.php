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
if(!isset($_SESSION['stop'])) $_SESSION['stop'] = False;

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

include('php/lang.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/blackjack.css">
    <script src="js/blackjack.js"></script>
    <title>Blackjack</title>
</head>
<body>
<main>
<?php include('php/langSelector.php') ?>
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

            echo '<li title="'.trans('infoSoft17').'">';
            if ($soft17) echo trans('canSoft17').'.</li>';
            else echo trans('notSoft17').'</li>';

            echo '<li title="'.trans('infoDecks').'">';
            if ($size > 1) echo trans('multipleDecks', ['size' => $size]).'</li>';
            else echo trans('singleDeck').'</li>';

            echo '<li title="'.trans('infoSplit').'">';
            if($maxSplits > 1 || $maxSplits < 1) echo trans('multipleSplit', ['maxSplit' => $maxSplits]).'</li>';
            else echo trans('singleSplit').'</li>';

            echo '<li title="'.trans('infoReSplit').'">';
            if($aceReSplit) echo trans('canReSplit').'</li>';
            else echo trans('notReSplit').'.</li>';

            echo '<li>';
            if($aceHitSplit) echo trans('canHitSplitAce').'</li>';
            else echo trans('notHitSplitAce').'</li>';

            echo '<li title="'.trans('infoDouble').'">';
            if($double){
                if($doubleType === 'any') echo trans('anyDouble').'</li>';
                else echo trans('rangeDouble', ['range' => $doubleType]).'</li>';
            }
            else echo trans('notDouble').'</li>';

            if($double){
                echo '<li>';
                if($doubleAfterSplit) echo trans('canSplitDouble').'</li>';
                else echo trans('notSplitDouble').'</li>';
            }

            ?>
        </ul>
    </div>
    <div id="message">
        <p>
            <?php echo trans('ownerMessage') ?>: <pre><?php echo $message ?></pre>
        </p>
    </div>
    <br />
    <a href="cp.php" target="_blank"><?php echo trans('controlpanel')  ?></a>
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
            <p><?php echo trans('playerMoney', ['playerMoney' => $playerMoney]) ?> </p>
            <div class="form-group row col-xs-10 col-sm-5">
                <label for="bet"><?php echo trans('betLabel').' '.trans('currencyBefore') ?></label>
                <input type="number" id="bet" class="form-control" name="bet" min="100" max="<?php echo $maxbet ?>" />
                <label for="bet"><?php echo trans('currencyAfter') ?></label>
            </div>
            <button type="submit" name="start" id="start" class="btn btn-success" value="start"><?php echo trans('start') ?>!</button>
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
    include('php/blackjack.php');
?>
    <section id="game" class="game-section container-fluid">
        <?php
        echo $_SESSION['printedCards'];

        if($_SESSION['stop']) stop();
        elseif($_SESSION['endGame']) $_SESSION['stop'] = True;

        ?>
        <div id="errors">
            <?php
            if(isset($_SESSION['blackjackError'])) {
                echo '<p>'.$_SESSION['blackjackError'].'</p>';
                unset($_SESSION['blackjackError']);
            }
            ?>
        </div>
        <div id="money">
            <h5><?php echo trans('playerMoney', ['playerMoney' => $_SESSION['playerMoney']]) ?></h5>
        </div>
    </section>

<?php
}
?>
</main>
</body>
</html>