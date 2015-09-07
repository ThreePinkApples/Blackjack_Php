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
    'welcome' => 'Velkommen til :owner sin blackjack! Dette kasinoet har :account kroner p� konto',
    'maxbet' => 'Du kan maks satse :maxbet kr',

    'infoCharlie' => 'En Charlie er n�r man har et visst antall kort uten � ha en sum over 21. Varierer fra 5 til 10 kort.',
    'canCharlie' => 'Du kan vinne p� en "Charlie" med :charlieAmount kort',
    'notCharlie' => 'Du kan <b>ikke</b> vinne med en "Charlie"',

    'infoSoft17' => 'Soft 17 er n� summer en 17, med med en ess som teller som 11. Dette gj�r den "myk" siden summen ogs� kan v�re 7.',
    'canSoft17' => 'Dealeren <b>skal</b> trekke p� en "Soft 17"',
    'notSoft17' => 'Delaeren kan <b>ikke</b> trekke p� en "Soft 17"',

    'infoDecks' => 'Antall kortstokker kan p�virke din vinnersjanse',
    'multipleDecks' => 'Dette kasinoet bruker :size kortstokker',
    'singleDeck' => 'Dette kasinoet bruker 1 korstokk',

    'infoSplit' => 'Om de to f�rste kortene i en h�nd har samme verdi, er mulig � splitte kortene og da f� en ekstra h�nd � spille med. Disse hendene er helt separate med separate kort, separat bel�p og separat resultat.',
    'multipleSplit' => 'Du kan splitte :maxSplit ganger',
    'singleSplit' => 'Du kan splitte 1 gang',

    'infoReSplit' => 'Re-splitting av esser gjelder situasjoner hvor du har startet med to esser, splittet, for � s� f� ess igjen p� en av hendene.',
    'canReSplit' => 'Du kan re-splitte esser',
    'notReSplit' => 'Du kan <b>ikke</b> re-splitte esser',

    'canHitSplitAce' => 'Du kan sl� etter � ha splittet esser',
    'notHitSplitAce' => 'Du kan <b>ikke</b> sl� etter � ha splittet esser. Splitt av esser vil avslutte runden.',

    'infoDouble' => 'I starten av en h�nd, n�r man har to kort, kan man velge � doble det man satset. Dette vil gi ett kort til og s� avslutte h�nden.',
    'anyDouble' => 'Du kan alltid doble',
    'rangeDouble' => 'Du kan doble ved en sum i omr�det :range',
    'notDouble' => 'Du kan <b>ikke</b> doble',

    'canSplitDouble' => 'Du kan doble etter � ha splittet',
    'notSplitDouble' => 'Du kan <b>ikke</b> doble etter � ha splittet',

    'ownerMessage' => 'En hilsen fra eieren av kasinoet',

    'controlpanel' => 'Kontrollpanel',

    'playerMoney' => 'Du har :playerMoney kr',
    'betLabel' => 'Sats:',
    'currencyBefore' => '',
    'currencyAfter' => 'kr',
    'start' => 'Start',

    //=============================================
    //=============== BLACKJACK.PHP ===============
    //=============================================

    'outOfMoney' => 'Du har for lite penger',
    'outOfMoneySplit' => 'Du har ikke r�d til � splitte',
    'outOfMoneyDouble' => 'Du har ikke r�d til � doble',

    'dealerCards' => 'Dealers kort',
    'sum' => 'Sum',
    'yourCards' => 'Dine kort',

    'c' => 'Kl�ver',
    's' => 'Spar',
    'h' => 'Hjerter',
    'd' => 'Ruter',

    'win' => 'Du vant :money kr',
    'lost' => 'Du tapte',
    'push' => 'Uvagjort',
    'winCharlie' => '<b>Charlie! :cards kort</b> Du vinner :money',
    'winBlackjack' => '<b>Blackjack!</b> Du vinner :money kr',

    'stand' => 'St�',
    'infoStand' => 'Avslutt h�nden',
    'hit' => 'Sl�',
    'infoHit' => 'F� et nytt kort',
    'split' => 'Splitt',
    'infoSplit2' => 'Lar deg ta to kort av samme verdi og splitte dem opp i hver sin h�nd. Dette krever at du satser start bel�pet ditt en gang til',
    'double' => 'Doble',
    'infoDouble2' => 'Doble det du satset p� den n�v�rende h�nden, vil gi deg ett kort til og s� avslutte h�nden.',

    'playAgain' => 'Spill igjen',


];