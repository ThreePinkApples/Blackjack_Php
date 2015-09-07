<?php
/**
 * Created by PhpStorm.
 * User: inste
 * Date: 07.09.2015
 * Time: 16.19
 */

return [
    //=============================================
    //=============== INDEX.PHP ===================
    //=============================================

    'title' => 'Blackjack',
    'welcome' => 'Welcome to :owner\'s blackjack! This casino has $:account',
    'maxbet' => 'You can max bet $:maxbet',

    'infoCharlie' => 'A "Charlie" is when you\'ve got a certain number of cards without surpassing 21. Varies from 5 to 10 cards.',
    'canCharlie' => 'You can win with a "Charlie" with :charlieAmount cards',
    'notCharlie' => 'You <b>can\'t</b> win with a "Charlie"',

    'infoSoft17' => '"Soft 17" is when the sum is 17, but with an ace counting as 11. This makes it "soft" since the sum also can be 7.',
    'canSoft17' => 'The dealer <b>shall</b> draw on a "Soft 17"',
    'notSoft17' => 'The delaer <b>can\'t</b> draw on a "Soft 17"',

    'infoDecks' => 'The amount of card decks might affect your winning chance',
    'multipleDecks' => 'This casino uses :size deck of cards',
    'singleDeck' => 'This casino uses 1 deck of cards',

    'infoSplit' => 'If the two first cards in a hand has the same value, it is possible to split the cards into two separate hands. A separate bet is placed on the new hand. You continue playing on the original hand, and continue to the next when it is finished.',
    'multipleSplit' => 'You can split :maxsplit times',
    'singleSplit' => 'You can split ones.',

    'infoReSplit' => 'Re-splitting aces is when you\'ve already split two aces, and then receives another ace on one of those two hands.',
    'canReSplit' => 'You can re-split aces',
    'notReSplit' => 'You <b>can\'t</b> re-split aces',

    'canHitSplitAce' => 'You can hit after splitting aces',
    'notHitSplitAce' => 'You <b>can\'t</b> hit after splitting aces. Splitting aces will end the round.',

    'infoDouble' => 'In the beginning of a hand, when you have two cards, you can choose to double your bet. This will give you one more card and end the hand.',
    'anyDouble' => 'You can always double',
    'rangeDouble' => 'You can double with a sum within the range :range',
    'notDouble' => 'You <b>can\'t</b> double',

    'canSplitDouble' => 'You can double after split',
    'notSplitDouble' => 'You <b>can\'t</b> double after split',

    'ownerMessage' => 'A message from the owner',

    'controlpanel' => 'Control Panel',

    'playerMoney' => 'You have $:playerMoney',
    'betLabel' => 'Bet:',
    'currencyBefore' => '$',
    'currencyAfter' => '',
    'start' => 'Start',

    //=============================================
    //=============== BLACKJACK.PHP ===============
    //=============================================

    'outOfMoney' => 'Not enough money',
    'outOfMoneySplit' => 'You can\'t afford to split',
    'outOfMoneyDouble' => 'You can\'t afford to double',

    'dealerCards' => 'Dealer cards',
    'sum' => 'Sum',
    'yourCards' => 'Your cards',

    'c' => 'Club',
    's' => 'Spade',
    'h' => 'Heart',
    'd' => 'Diamond',

    'win' => 'You won $:money',
    'lost' => 'You lost',
    'push' => 'Draw',
    'winCharlie' => '<b>Charlie! :cards cards</b> You win $:money',
    'winBlackjack' => '<b>Blackjack!</b> You win $:money',

    'stand' => 'Stand',
    'infoStand' => 'End hand',
    'hit' => 'Hit',
    'infoHit' => 'Get another card',
    'split' => 'Split',
    'infoSplit2' => 'Lets you take two cards of same value and split them up into two separate hands. This also causes you to place another bet, equal to the original one, on the new hand',
    'double' => 'Double',
    'infoDouble2' => 'Double what you bet on your current hand, gives you one more card and then ends the hand.',

    'playAgain' => 'Play again',


    //=============================================
    //================== CP.PHP ===================
    //=============================================

    'settings' => 'Blackjack Settings',
    'useSoft17Label' => 'Dealer must draw on a "Soft 17"',
    'userCharlieLabel' => 'Activate "Charlie" rules',
    'charlieCardsNeededLabel' => 'Number of cards needed to get a "Charlie"',
    'messageToUsersLabel' => 'Message displayed to the player',
    'deckAmountLabel' => 'Number of decks',
    'maxbetLabel' => 'Highest bet a user can start with',
    'maxSplitsLabel' => 'Number of times the player can split',
    'hitSplitAcesLabel' => 'The player can hit after splitting aces',
    'reSplitAcesLabel' => 'The player can re-split aces (other cards can always be re-splitted)',
    'doubleLabel' => 'The player can double',
    'anyDoubleOption' => 'Always',
    'doubleOptionRange' => 'Only between :range',
    'whenToDoubleLabel' => 'When the player can double',
    'doubleAfterSplitLabel' => 'The player can double after a split',
    'save' => 'Save',
    'toGame' => 'To game'
];