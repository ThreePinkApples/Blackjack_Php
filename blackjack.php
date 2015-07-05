<?php
/**
 * Created by PhpStorm.
 * User: Øyvind
 * Date: 05.07.2015
 * Time: 17.52
 */

if($_SESSION['newRound']){

    if($_SESSION['playerMoney'] < $_POST['bet']){
        $_SESSION['newRound'] = False;
        $_SESSION['playing'] = False;
        $_SESSION['error'] = 'For lite penger';
        header('Location: /');
        exit();
    }

    $_SESSION['deck'] = []; //Cards left in the deck

    $_SESSION['playerCards'] = []; //Cards player has received
    $_SESSION['dealerCards'] = []; //Cards dealer has received
    $_SESSION['playerCardsCalculated'] = 0; //How many cards have already been calculated
    $_SESSION['dealerCardsCalculated'] = 0; //How many cards have already been calculated

    $_SESSION['playerAce'] = False; //Player has ace counting as 11
    $_SESSION['dealerAce'] = False; //Dealer has ace counting as 11

    $_SESSION['playerBlackjack'] = False; //Player has blackjack or not
    $_SESSION['dealerBlackjack'] = False; //Dealer has blackjack or not

    $_SESSION['charlie'] = False; //Player has five-card charlie or not

    $_SESSION['endGame'] = False;

    $_SESSION['playerSum'] = 0;
    $_SESSION['dealerSum'] = 0;
    $_SESSION['bet'] = $_POST['bet'];

    //Make sure bet is not out of bounds
    if($_SESSION['bet'] < 100) $_SESSION['bet'] = 100;
    elseif($_SESSION['bet'] > $_SESSION['maxbet']) $_SESSION['bet'] = $_SESSION['maxbet'];

    //Start round by taking money from player
    $_SESSION['playerMoney'] -= $_SESSION['bet'];
    $_SESSION['account'] += $_SESSION['bet'];

    createDeck();
    playerDraw();
    dealerDraw();
    calculate();

    if($_SESSION['dealerSum'] === 21) $_SESSION['dealerBlackjack'] = True;
    if($_SESSION['playerSum'] === 21){
        $_SESSION['playerBlackjack'] = True;
        $_SESSION['endGame'] = True;
        dealerDraw();
        printCards();
        endOfGame();
    }
    else{
        printCards();
    }

    $_SESSION['newRound'] = False;
    //Prevents refresh of page to instantly start a new game
    header('Location: /');
}

if(isset($_POST['hit'])) hit();
elseif(isset($_POST['check'])) check();

function hit(){
    playerDraw();
    calculate();
    endGameCheck();
    //endGameCheck() will cause cards to be drawn, if true
    if(!$_SESSION['endGame']) printCards();
}

/**
 * User pressed check
 */
function check(){
    calculate();
    $_SESSION['endGame'] = True;
    if($_SESSION['playerSum'] <= 21){
        dealerDraw();
        calculate();
    }
    printCards();
    endOfGame();
}

/**
 * Stop the game
 */
function stop(){
    $_SESSION['playing'] = False;
}

/**
 * Check for automatic end of game
 */
function endGameCheck(){
    if(count($_SESSION['playerCards']) === 5 && $_SESSION['fiveCharlie'] && $_SESSION['playerSum'] <= 21){
        $_SESSION['charlie'] = True;
        $_SESSION['endGame'] = True;
        printCards();
        endOfGame();
    }
    elseif($_SESSION['playerSum'] >= 21){
        check();
    }
}

/**
 * Draw cards for player
 * Draw 2 when amount is under 2, else it draws 1
 */
function playerDraw(){
    $count = count($_SESSION['playerCards']) < 2 ? 2 : 1;

    for($i = 0; $i < $count; $i++){
        //Draw random card
        $index = rand(0, count($_SESSION['deck']) - 1);
        //Find card and give to player
        $card = $_SESSION['deck'][$index];
        $_SESSION['playerCards'][count($_SESSION['playerCards'])] = $card;
        //Remove from deck
        array_splice($_SESSION['deck'], $index, 1);
    }
}

/**
 * Draw cards for dealer
 */
function dealerDraw(){
    if(!$_SESSION['endGame']){
        for($i = 0; $i < 2; $i++){
            //Draw random card
            $index = rand(0, count($_SESSION['deck']) - 1);
            //Find card and give to dealer
            $card = $_SESSION['deck'][$index];
            $_SESSION['dealerCards'][count($_SESSION['dealerCards'])] = $card;
            //Remove from deck
            array_splice($_SESSION['deck'], $index, 1);
        }
    }
    else{
        calculate();

        $maxSum = 17;
        //Draw cards until sum is above or equal to max (which is 17 for dealers)
        while($_SESSION['dealerSum'] < $maxSum){
            //Draw random card
            $index = rand(0, count($_SESSION['deck']) - 1);
            //Find card and give to dealer
            $card = $_SESSION['deck'][$index];
            $_SESSION['dealerCards'][count($_SESSION['dealerCards'])] = $card;
            //Remove from deck
            array_splice($_SESSION['deck'], $index, 1);

            calculate();

            //If dealer has 17, an ace that counts as 11 and game allows dealer to draw on soft 17, adjust maxSum to allow draws
            if($_SESSION['dealerSum'] === 17 && $_SESSION['soft17'] && $_SESSION['dealerAce']){
                $maxSum = 18;
            }
            //Max sum is only set to 18 once to allow one more draw when on 17 with ace as 11
            //If dealer "breaks" and the ace is shifted to 1, then max draw sum is again 17
            else{
                $maxSum = 17;
            }
        }
    }
}

/**
 * Determines winner and gives/takes money accordingly
 */
function endOfGame(){
    if($_SESSION['playerBlackjack']){
        if($_SESSION['dealerBlackjack']){
            //Draw
            $_SESSION['playerMoney'] += $_SESSION['bet'];
            $_SESSION['account'] -= $_SESSION['bet'];
            $_SESSION['result'] = 'Push';
        }
        else{
            //Blackjack victory to player, wins 2.5x!
            $_SESSION['playerMoney'] += $_SESSION['bet'] * 2.5;
            $_SESSION['account'] -= $_SESSION['bet'] * 2.5;
            $_SESSION['result'] = 'Blackjack';
        }
    }
    elseif($_SESSION['charlie']){
        //Player wins 3x on charlie!
        $_SESSION['playerMoney'] += $_SESSION['bet'] * 3;
        $_SESSION['account'] -= $_SESSION['bet'] * 3;
        $_SESSION['result'] = 'Charlie';
    }
    elseif($_SESSION['playerSum'] > 21){
        //Player looses, even if dealer also has > 21
        $_SESSION['result'] = 'Dealer';
    }
    elseif($_SESSION['dealerSum'] > 21){
        //Normal win for player, 2x!
        $_SESSION['playerMoney'] += $_SESSION['bet'] * 2;
        $_SESSION['account'] -= $_SESSION['bet'] * 2;
        $_SESSION['result'] = 'Player';
    }
    elseif($_SESSION['dealerSum'] > $_SESSION['playerSum']){
        //Normal win for dealer
        $_SESSION['result'] = 'Dealer';
    }
    elseif($_SESSION['dealerSum'] < $_SESSION['playerSum']){
        //Normal win for player, 2x!
        $_SESSION['playerMoney'] += $_SESSION['bet'] * 2;
        $_SESSION['account'] -= $_SESSION['bet'] * 2;
        $_SESSION['result'] = 'Player';
    }
    elseif($_SESSION['dealerSum'] === $_SESSION['playerSum']){
        //Draw
        $_SESSION['playerMoney'] += $_SESSION['bet'];
        $_SESSION['account'] -= $_SESSION['bet'];
        $_SESSION['result'] = 'Push';
    }

    stop();
}

/**
 * Calculates sum for player and dealer
 * Calculates only new cards and adds on top of existing sum
 */
function calculate(){
    $dealerSum = $_SESSION['dealerSum'];
    $playerSum = $_SESSION['playerSum'];
    $dealerAce = $_SESSION['dealerAce'];
    $playerAce = $_SESSION['playerAce'];
    $dealerCalculated = $_SESSION['dealerCardsCalculated'];
    $playerCalculated = $_SESSION['playerCardsCalculated'];

    for($dealerCalculated; $dealerCalculated < count($_SESSION['dealerCards']); $dealerCalculated++){
        $card = $_SESSION['dealerCards'][$dealerCalculated];
        calculateCard($card, $dealerAce, $dealerSum);
    }

    for($playerCalculated; $playerCalculated < count($_SESSION['playerCards']); $playerCalculated++){
        $card = $_SESSION['playerCards'][$playerCalculated];
        calculateCard($card, $playerAce, $playerSum);
    }


    $_SESSION['dealerSum'] = $dealerSum;
    $_SESSION['playerSum'] = $playerSum;
    $_SESSION['dealerAce'] = $dealerAce;
    $_SESSION['playerAce'] = $playerAce;
    $_SESSION['dealerCardsCalculated'] = $dealerCalculated;
    $_SESSION['playerCardsCalculated'] = $playerCalculated;
}

/**
 * Calculate vale of single card and add to sum
 *
 * @param array $card Card to calculate
 * @param bool $ace Player has ace as 11 or not
 * @param int $sum Players sum
 */
function calculateCard(&$card, &$ace, &$sum){
    if($card['value'] === 1){
        if($ace || ($sum + 11) > 21) $sum += 1; //Two aces is higher than 22
        else{
            $sum += 11;
            $ace = True;
        }
    }
    elseif($card['value'] > 10) $sum += 10; //Cards above 10 counts as 10
    else $sum += $card['value'];

    //Check for break
    if($sum > 21){
        //If there is an ace that counts as 11, change it to 1
        if($ace){
            $sum -= 10;
            $ace = False;
        }
    }
}


/**
 * Print all drawn cards
 * Will hide dealer cards until end of round
 */
function printCards(){
    $result = '';

    //Printing dealer cards. Only print all cards at end of round
    $count = 1; //Number of cards to show
    if($_SESSION['endGame']){
        $count = count($_SESSION['dealerCards']);
    }
    $result .= '<div id="dealerCards">';
    $result .= '<h4>Dealers kort</h4>';
    for($i = 0; $i < $count; $i++){
        $card = $_SESSION['dealerCards'][$i];
        $result .= '<img src="cards/'.$card['color'].$card['value'].'.png" />';
    }
    if($count > 1)
        $result .= '<br />Sum: '.$_SESSION['dealerSum'];
    $result .= '</div>';


    //Print player cards, always print all
    $result .= '<div id="playerCards">';
    $result .= '<h4>Dine kort</h4>';
    for($i = 0; $i < count($_SESSION['playerCards']); $i++){
        $card = $_SESSION['playerCards'][$i];
        $result .= '<img src="cards/'.$card['color'].$card['value'].'.png" />';
    }
    $result .= '<br />Sum: '.$_SESSION['playerSum'];
    $result .= '</div>';

    $_SESSION['printedCards'] = $result;
}

/**
 * Creates the deck based on specified size.
 * Shuffles it
 */
function createDeck(){
    $counter = 0;

    for($i = 0; $i < $_SESSION['size']; $i++){
        for($j = 1; $j <= 13; $j++){
            $_SESSION['deck'][$counter] = ['color' => 'h', 'value' => $j];
            $counter++;
        }
        for($j = 1; $j <= 13; $j++){
            $_SESSION['deck'][$counter] = ['color' => 'd', 'value' => $j];
            $counter++;
        }
        for($j = 1; $j <= 13; $j++){
            $_SESSION['deck'][$counter] = ['color' => 'c', 'value' => $j];
            $counter++;
        }
        for($j = 1; $j <= 13; $j++){
            $_SESSION['deck'][$counter] = ['color' => 's', 'value' => $j];
            $counter++;
        }
    }

    shuffle($_SESSION['deck']);
}