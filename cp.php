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
}

?>

<!DOCTYPE html>
<html>
<head>

</head>
<body>

<form method="POST">

    <div id="soft17">
        <input type="checkbox" name="soft17" id="soft17" <?php echo isset($_SESSION['soft17']) && $_SESSION['soft17'] ? 'checked' : '' ?> /> Tillat dealeren din å trekke ved en soft 17
    </div>

    <div id="charlie">
        <input type="checkbox" name="charlie" <?php echo isset($_SESSION['fiveCharlie']) && $_SESSION['fiveCharlie'] ? 'checked' : '' ?>/> La spilleren få lov til å vinne på en "Five-card Charlie"
    </div>

    <div id="message">
        <label>Melding som skal vises til spillerne</label>
        <br />
        <textarea name="message"><?php echo isset($_SESSION['message']) ? $_SESSION['message'] : '' ?></textarea>
    </div>

    <div id="size">
        <input type="number" name="size" min="<?php echo $minSize ?>" max="<?php echo $maxSize ?>" <?php echo isset($_SESSION['size']) ? 'value="'.$_SESSION['size'].'"' : '' ?> /> Antall kortstokker som skal brukes
    </div>

    <div id="maxbet">
        <input type="number" name="maxbet" min="<?php echo $minMaxbet ?>" max="<?php echo $maxMaxbet ?>" value="<?php echo isset($_SESSION['maxbet']) ? $_SESSION['maxbet'] : '1000000' ?>" /> Sett maks beløp en spiller kan satse på ett spill
    </div>

    <button type="submit" name="save" id="save">Lagre</button>
</form>

</body>
</html>

