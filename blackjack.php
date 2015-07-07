<?php
/**
 * Created by PhpStorm.
 * User: Øyvind
 * Date: 05.07.2015
 * Time: 17.52
 */

/**
 *
 */
if($_SESSION['newRound']) init();
elseif(isset($_POST['hit'])) hit();
elseif(isset($_POST['stand'])) stand();
elseif(isset($_POST['split'])) splitHand();

/**
 * Initializes a new round
 */
function init(){
    //Make sure player is not trying to use money it doesn't have
    if($_SESSION['playerMoney'] < $_POST['bet']){
        $_SESSION['newRound'] = False;
        $_SESSION['playing'] = False;
        $_SESSION['error'] = 'Not enough money';
        header('Location: index.php');
        exit();
    }

    $_SESSION['deck'] = []; //Cards left in the deck

    //Initializes only one array, so that you can count this array to know number of splits
    $_SESSION['playerCards'] = [[]]; //Cards player has received
    $_SESSION['dealerCards'] = []; //Cards dealer has received
    //$_SESSION['playerCardsCalculated'] = [0,0,0,0]; //How many cards have already been calculated
    $_SESSION['dealerCardsCalculated'] = 0; //How many cards have already been calculated

    $_SESSION['playerAce'] = [False, False, False, False]; //Player has ace counting as 11
    $_SESSION['dealerAce'] = False; //Dealer has ace counting as 11

    //Can only have blackjack on first hand
    $_SESSION['playerBlackjack'] = False; //Player has blackjack or not
    $_SESSION['dealerBlackjack'] = False; //Dealer has blackjack or not

    $_SESSION['charlie'] = [False, False, False, False]; //Player has five-card charlie or not
    //Only three here since player can only split 3 times
    $_SESSION['splitAvailable'] = [False, False, False]; //Player can split

    $_SESSION['handDone'] = [False, False, False, False];
    $_SESSION['endGame'] = False;

    $_SESSION['playerSum'] = [0,0,0,0];
    $_SESSION['dealerSum'] = 0;
    $_SESSION['bets'][0] = $_POST['bet'];
    $_SESSION['originalBet'] = $_POST['bet'];
    $hand = 0;
    $_SESSION['currentHand'] = $hand;

    //Make sure bet is not out of bounds
    if($_SESSION['bets'][$hand] < 100) $_SESSION['bets'][$hand] = 100;
    elseif($_SESSION['bets'][$hand] > $_SESSION['maxbet']) $_SESSION['bets'][$hand] = $_SESSION['maxbet'];

    //Start round by taking money from player
    adjustMoney($hand);

    createDeck();
    playerDraw();
    dealerDraw();
    calculate();

    $_SESSION['newRound'] = False;

    if($_SESSION['dealerSum'] === 21) $_SESSION['dealerBlackjack'] = True;
    //Player got blackjack, end the game
    if($_SESSION['playerSum'][$hand] === 21){
        $_SESSION['playerBlackjack'] = True;
        $_SESSION['endGame'] = True;
        $_SESSION['handDone'][$hand] = True;
        printCards();
        endOfGame();
    }
    else{
        printCards();
        //Prevents refresh of page to instantly start a new game
        //header('Location: index.php');
    }
}

/**
 * Handles "hit" press
 */
function hit(){
    playerDraw();
    calculate();
    endHandCheck();
    //endGameCheck() will cause cards to be drawn, if true
    if(!$_SESSION['endGame']) printCards();
}

/**
 * Handles "stand" press
 */
function stand(){
    calculate();
    $_SESSION['handDone'][$_SESSION['currentHand']] = True;
    if(!endGameCheck()) {
        $_SESSION['currentHand']++;
        printCards();
    }
}

/**
 * Handles "split" press
 */
function splitHand(){
    $hand = $_SESSION['currentHand'];
    if($hand < $_SESSION['maxHands'] - 1){
        //Move second card from current hand to a new one
        $card = $_SESSION['playerCards'][$hand][1];
        array_splice($_SESSION['playerCards'][$hand], 1, 1);
        $_SESSION['playerCards'][$hand + 1][0] = $card;

        //Register new bet
        $_SESSION['bets'][$hand + 1] = $_SESSION['bets'][$hand];
        adjustMoney($hand + 1);

        //Draw new card on current hand
        playerDraw();
        calculate();
        printCards();
    }
}

/**
 * Stop the game
 */
function stop(){
    $_SESSION['playing'] = False;
}

/**
 * Check if hand should end
 */
function endHandCheck(){
    //Five card charlie automatically ends hand
    if(count($_SESSION['playerCards'][$_SESSION['currentHand']]) === 5
        && $_SESSION['fiveCharlie']
        && $_SESSION['playerSum'][$_SESSION['currentHand']] <= 21){

        $_SESSION['charlie'][$_SESSION['currentHand']] = True;
        $_SESSION['handDone'][$_SESSION['currentHand']] = True;

        if(!endGameCheck()) {
            printCards();
            $_SESSION['currentHand']++;
        }
    }
    //Reaching or going above 21 automatically ends hand
    elseif($_SESSION['playerSum'][$_SESSION['currentHand']] >= 21){
        stand();
    }
}

/**
 * Check if game should end
 * @return bool
 */
function endGameCheck(){
    //If last hand is done, end game
    if($_SESSION['handDone'][count($_SESSION['playerCards'])-1]) {
        $_SESSION['endGame'] = True;
        endOfGame();
        return True;
    }
    return False;
}
/**
 * Draw cards for player
 * Draw 2 when amount is under 2, else it draws 1
 */
function playerDraw(){
    $count = 1;
    $hand = $_SESSION['currentHand'];
    $numberOfCards = count($_SESSION['playerCards'][$hand]);
    if($hand === 0)
        $count = $numberOfCards === 0 ? 2 : 1;

    for($i = 0; $i < $count; $i++){
        //Draw random card
        $index = rand(0, count($_SESSION['deck']) - 1);
        //Find card and give to player
        $card = $_SESSION['deck'][$index];
        $_SESSION['playerCards'][$hand][$numberOfCards + $i] = $card;
        //Remove from deck
        array_splice($_SESSION['deck'], $index, 1);
    }
    if($numberOfCards + $count === 2
        && $hand !== 3
        && $_SESSION['playerCards'][$hand][0]['gameValue'] === $_SESSION['playerCards'][$hand][1]['gameValue']
        && !$_SESSION['splitAvailable'][$hand]){

            $_SESSION['splitAvailable'][$hand] = True;
    }
    elseif($_SESSION['splitAvailable'][$hand]) $_SESSION['splitAvailable'][$hand] = False;
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
    dealerDraw();
    for($hand = 0; $hand < count($_SESSION['playerCards']); $hand++){
        if($_SESSION['playerBlackjack']){
            if($_SESSION['dealerBlackjack']){
                //Draw
                $_SESSION['result'][$hand] = 'Push';
            }
            else{
                //Blackjack victory to player, wins 2.5x!
                $_SESSION['result'][$hand] = 'Blackjack';
            }
        }
        elseif($_SESSION['charlie'][$hand]){
            //Player wins 3x on charlie!
            $_SESSION['result'][$hand] = 'Charlie';
        }
        elseif($_SESSION['playerSum'][$hand] > 21){
            //Player looses, even if dealer also has > 21
            $_SESSION['result'][$hand] = 'Dealer';
        }
        elseif($_SESSION['dealerSum'] > 21){
            //Normal win for player, 2x!
            $_SESSION['result'][$hand] = 'Player';
        }
        elseif($_SESSION['dealerSum'] > $_SESSION['playerSum'][$hand]){
            //Normal win for dealer
            $_SESSION['result'][$hand] = 'Dealer';
        }
        elseif($_SESSION['dealerSum'] < $_SESSION['playerSum'][$hand]){
            //Normal win for player, 2x!
            $_SESSION['result'][$hand] = 'Player';
        }
        elseif($_SESSION['dealerSum'] === $_SESSION['playerSum'][$hand]){
            //Draw
            $_SESSION['result'][$hand] = 'Push';
        }
        adjustMoney($hand);
    }
    printCards();
    stop();
}

/**
 * Adjusts money based on result
 * @param int $hand Which hands result to adjust for
 */
function adjustMoney($hand){
    if($_SESSION['endGame']){
        $factor = 0;
        if($_SESSION['result'][$hand] === 'Push') $factor = 1;
        elseif($_SESSION['result'][$hand] === 'Player') $factor = 2;
        elseif($_SESSION['result'][$hand] === 'Blackjack') $factor = 2.5;
        elseif($_SESSION['result'][$hand] === 'Charlie') $factor = 3;

        $_SESSION['playerMoney'] += $_SESSION['bets'][$hand] * $factor;
        $_SESSION['account'] -= $_SESSION['bets'][$hand] * $factor;
    }
    else{
        $_SESSION['playerMoney'] -= $_SESSION['bets'][$hand];
        $_SESSION['account'] += $_SESSION['bets'][$hand];
    }
}

/**
 * Calculates sum for player and dealer
 * Calculates only new cards and adds on top of existing sum
 */
function calculate(){
    $dealerSum = $_SESSION['dealerSum'];
    $dealerAce = $_SESSION['dealerAce'];
    $dealerCalculated = $_SESSION['dealerCardsCalculated'];

    for($dealerCalculated; $dealerCalculated < count($_SESSION['dealerCards']); $dealerCalculated++){
        $card = $_SESSION['dealerCards'][$dealerCalculated];
        calculateCard($card, $dealerAce, $dealerSum);
    }

    $_SESSION['dealerSum'] = $dealerSum;
    $_SESSION['dealerAce'] = $dealerAce;
    $_SESSION['dealerCardsCalculated'] = $dealerCalculated;

    //Calculate all hands
    for($hand = 0; $hand < count($_SESSION['playerCards']); $hand++){
        /*$playerSum = $_SESSION['playerSum'][$hand];
        $playerAce = $_SESSION['playerAce'][$hand];
        $playerCalculated = $_SESSION['playerCardsCalculated'][$hand];

        for($playerCalculated; $playerCalculated < count($_SESSION['playerCards'][$hand]); $playerCalculated++){
            $card = $_SESSION['playerCards'][$hand][$playerCalculated];
            calculateCard($card, $playerAce, $playerSum);
        }

        $_SESSION['playerSum'][$hand] = $playerSum;
        $_SESSION['playerAce'][$hand] = $playerAce;
        $_SESSION['playerCardsCalculated'][$hand] = $playerCalculated;*/

        $playerSum = 0;
        $playerAce = False;

        for($i = 0; $i < count($_SESSION['playerCards'][$hand]); $i++){
            $card = $_SESSION['playerCards'][$hand][$i];
            calculateCard($card, $playerAce, $playerSum);
        }

        $_SESSION['playerSum'][$hand] = $playerSum;
    }
}

/**
 * Calculate vale of single card and add to sum
 *
 * @param array $card Card to calculate
 * @param bool $ace Player has ace as 11 or not
 * @param int $sum Players sum
 */
function calculateCard(&$card, &$ace, &$sum){
    if($card['gameValue'] === 1){
        if($ace || ($sum + 11) > 21) $sum += 1; //Two aces is higher than 22
        else{
            $sum += 11;
            $ace = True;
        }
    }
    else $sum += $card['gameValue'];

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
    $result .= '<form method="POST">';
    $result .= '<div id="cards">';
    $result .= '<div id="dealerCards">';
    $result .= '<h4>Dealer\'s cards</h4>';
    $result .= '<div class="hand">';
    for($i = 0; $i < $count; $i++){
        $card = $_SESSION['dealerCards'][$i];
        $result .= '<img src="cards/'.$card['color'].$card['value'].'.png" />';
    }
    if($count > 1)
        $result .= '<br />Sum: '.$_SESSION['dealerSum'];
    $result .= '</div>';
    $result .= '</div>';


    //Print player cards, always print all
    $result .= '<div id="playerCards">';
    $result .= '<h4>Your cards</h4>';
    for($hand = 0; $hand < count($_SESSION['playerCards']); $hand++){
        $result .= '<div id="hand-'.$hand.'" class="hand" style="display:inline-block;">';
        for($i = 0; $i < count($_SESSION['playerCards'][$hand]); $i++){
            $card = $_SESSION['playerCards'][$hand][$i];
            $result .= '<img src="cards/'.$card['color'].$card['value'].'.png" />';
        }
        $result .= '<br />Sum: '.$_SESSION['playerSum'][$hand];

        if($_SESSION['endGame']) {
            $result .= '<p>';
            if ($_SESSION['result'][$hand] === 'Player') {
                $result .= '<b>You won!</b>';
            } elseif ($_SESSION['result'][$hand] === 'Dealer') {
                $result .= '<b>You lost!</b>';
            } elseif ($_SESSION['result'][$hand] === 'Push') {
                $result .= '<b>Draw!</b>';
            } elseif ($_SESSION['result'][$hand] === 'Charlie') {
                $result .= '<b>Five-card Charlie!</b> You win 3 times your bet!';
            } elseif ($_SESSION['result'][$hand] === 'Blackjack') {
                $result .= '<b>Blackjack!</b> You win 2.5 times your bet!';
            }
            $result .= '</p>';
        }
        elseif($_SESSION['currentHand'] === $hand) {
            $result .= '<div id="buttons">';
            $result .= '<button type="submit" name="hit" id="hit" value="hit" title="Get another card.">Hit</button>
                <button type="submit" name="stand" id="stand" value="stand" title="End the game.">Stand</button>';
            if(isset($_SESSION['splitAvailable'][$hand]) && $_SESSION['splitAvailable'][$hand]) {
                $result .= '<button type="submit" name="split" id="split" value="split" title="Let\'s you take two cards of same value, and split them into to separate hands. You also have to place another bet on the new hand, equal to your original bet.">Split</button>';
            }
            $result .= '</div>';
        }
        $result .= '</div>';
    }
    $result .= '</div>';
    $result .= '</div>';
    if($_SESSION['endGame']){
        $result .= '<input type="number" id="bet" name="bet" min="100" max="'.$_SESSION['maxbet'].'" value="'.$_SESSION['originalBet'].'"/>';
        $result .= '<button type="submit" name="again" id="again" value="again">Play again</button>';
    }
    $result .= '</form>';

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
            $_SESSION['deck'][$counter] = ['color' => 'h', 'value' => $j, 'gameValue' => $j > 10 ? 10 : $j];
            $counter++;
        }
        for($j = 1; $j <= 13; $j++){
            $_SESSION['deck'][$counter] = ['color' => 'd', 'value' => $j, 'gameValue' => $j > 10 ? 10 : $j];
            $counter++;
        }
        for($j = 1; $j <= 13; $j++){
            $_SESSION['deck'][$counter] = ['color' => 'c', 'value' => $j, 'gameValue' => $j > 10 ? 10 : $j];
            $counter++;
        }
        for($j = 1; $j <= 13; $j++){
            $_SESSION['deck'][$counter] = ['color' => 's', 'value' => $j, 'gameValue' => $j > 10 ? 10 : $j];
            $counter++;
        }
    }

    shuffle($_SESSION['deck']);
}