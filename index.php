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
if(!isset($_SESSION['fiveCharlie'])) $_SESSION['fiveCharlie'] = True;
if(!isset($_SESSION['soft17'])) $_SESSION['soft17'] = False;
if(!isset($_SESSION['message'])) $_SESSION['message'] = "Ha det morro!";
if(!isset($_SESSION['size'])) $_SESSION['size'] = 2;
if(!isset($_SESSION['maxbet'])) $_SESSION['maxbet'] = 1000000;

if(!isset($_SESSION['account'])) $_SESSION['account'] = 1000000000;
if(!isset($_SESSION['playerMoney'])) $_SESSION['playerMoney'] = 100000000;


$owner = $_SESSION['owner'];
$fiveCharlie = $_SESSION['fiveCharlie'];
$soft17 = $_SESSION['soft17'];
$message = $_SESSION['message'];
$size = $_SESSION['size'];
$maxbet = $_SESSION['maxbet'];
$account = $_SESSION['account'];
$playerMoney = $_SESSION['playerMoney'];

if(!isset($_SESSION['playing'])) $_SESSION['playing'] = False;

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body>
    <div id="welcome">
        <p>Velkommen til <?php echo $owner ?> sin blackjack! Dette kasinoet har <?php echo $account ?> kroner på konto.</p>
    </div>
    <div id="settings">
        <ul>
            <li>Du kan maks satse <?php echo $maxbet ?> kroner</li>
            <?php
            if ($fiveCharlie) echo '<li>Her kan du vinne med en "Five Card Charlie"!</li>';
            else echo '<li>Du kan <b>ikke</b> vinne med en "Five Card Charlie"!</li>';

            if ($soft17) echo '<li>Dealeren <b>må</b> trekke på en "Soft 17"</li>';
            else echo '<li>Dealeren kan <b>ikke</b> trekke på en "soft 17"</li>';

            if ($size > 1) echo '<li>Dette kasinoet bruker ' . $size . ' kortstokker</li>';
            else echo '<li>Dette kasinoet bruker 1 korstokk</li>';
            ?>
        </ul>
    </div>
    <div id="message">
        <p>
            En listen hilsen fra eieren av kasinoet: <pre><?php echo $message ?></pre>
        </p>
    </div>
    <br />
    <a href="cp.php" target="_blank">Kontrollpanel</a>
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
    <form method="POST">
        <div>
            <p>Du har <?php echo $playerMoney ?> kroner</p>
            <span>Sats:</span>
            <input type="number" id="bet" name="bet" min="100" max="<?php echo $maxbet ?>" />
            <span>kroner</span>
            <?php
            if(isset($_SESSION['error'])) {
                echo '<p>'.$_SESSION['error'].'</p>';
                unset($_SESSION['error']);
            }
            ?>
        </div>
        <div>
            <input type="submit" name="start" id="start" value="Start spill!"/>
        </div>
    </form>

<?php
}
else {
    //echo $_POST['bet'];
    include('blackjack.php');
    echo $_SESSION['printedCards'];
?>
    <form method="POST">
        <?php
            if(!$_SESSION['endGame']) {
        ?>
            <button type="submit" name="hit" id="hit" value="hit">Nytt kort</button>
            <button type="submit" name="check" id="check" value="check">Stå</button>
        <?php
            }
        else {
            echo '<p>';
            if ($_SESSION['result'] === 'Player') {
                echo '<b>Du vant!</b>';
            } elseif ($_SESSION['result'] === 'Dealer') {
                echo '<b>Du tapte!</b>';
            } elseif ($_SESSION['result'] === 'Push') {
                echo '<b>Uavgjort!</b>';
            } elseif ($_SESSION['result'] === 'Charlie') {
                echo '<b>Five-card Charlie!</b> Du får dermed utbetalt 3 ganger det du satset!';
            } elseif ($_SESSION['result'] === 'Blackjack') {
                echo '<b>Blakjack!</b> Du får dermed utbetalt 2.5 ganger det du satset!';
            }
            echo '</p>';
            ?>
            <input type="number" id="bet" name="bet" min="100" max="<?php echo $maxbet ?>"
                   value="<?php echo $_SESSION['bet'] ?>"/>
            <button type="submit" name="again" id="again" value="again">Spill på nytt</button>
        <?php
        }
        ?>
    </form>
    <h5>Dine penger: <?php echo $_SESSION['playerMoney'] ?></h5>
<?php
}
?>
</body>
</html>