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
    'welcome' => 'Velkommen til :owner sin blackjack!<br />Dette kasinoet har :account kroner på konto',
    'maxbet' => 'Du kan maks satse :maxbet kr',

    'infoCharlie' => 'En Charlie er når man har et visst antall kort uten å ha en sum over 21. Varierer fra 5 til 10 kort.',
    'canCharlie' => 'Du kan vinne på en "Charlie" med :charlieAmount kort',
    'notCharlie' => 'Du kan <b>ikke</b> vinne med en "Charlie"',

    'infoSoft17' => 'Soft 17 er nå summer en 17, med med en ess som teller som 11. Dette gjør den "myk" siden summen også kan være 7.',
    'canSoft17' => 'Dealeren <b>skal</b> trekke på en "Soft 17"',
    'notSoft17' => 'Dealeren kan <b>ikke</b> trekke på en "Soft 17"',

    'infoDecks' => 'Antall kortstokker kan påvirke din vinnersjanse',
    'multipleDecks' => 'Dette kasinoet bruker :size kortstokker',
    'singleDeck' => 'Dette kasinoet bruker 1 korstokk',

    'infoSplit' => 'Om de to første kortene i en hånd har samme verdi, er mulig å splitte kortene og da få en ekstra hånd å spille med. Disse hendene er helt separate med separate kort, separat beløp og separat resultat.',
    'multipleSplit' => 'Du kan splitte :maxSplit ganger',
    'singleSplit' => 'Du kan splitte 1 gang',

    'infoReSplit' => 'Re-splitting av esser gjelder situasjoner hvor du har startet med to esser, splittet, for å så få ess igjen på en av hendene.',
    'canReSplit' => 'Du kan re-splitte esser',
    'notReSplit' => 'Du kan <b>ikke</b> re-splitte esser',

    'canHitSplitAce' => 'Du kan slå etter å ha splittet esser',
    'notHitSplitAce' => 'Du kan <b>ikke</b> slå etter å ha splittet esser. Splitt av esser vil avslutte runden.',

    'infoDouble' => 'I starten av en hånd, når man har to kort, kan man velge å doble det man satset. Dette vil gi ett kort til og så avslutte hånden.',
    'anyDouble' => 'Du kan alltid doble',
    'rangeDouble' => 'Du kan doble ved en sum i området :range',
    'notDouble' => 'Du kan <b>ikke</b> doble',

    'canSplitDouble' => 'Du kan doble etter å ha splittet',
    'notSplitDouble' => 'Du kan <b>ikke</b> doble etter å ha splittet',

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
    'outOfMoneySplit' => 'Du har ikke råd til å splitte',
    'outOfMoneyDouble' => 'Du har ikke råd til å doble',

    'dealerCards' => 'Dealers kort',
    'sum' => 'Sum',
    'yourCards' => 'Dine kort',

    'c' => 'Kløver',
    's' => 'Spar',
    'h' => 'Hjerter',
    'd' => 'Ruter',

    'win' => 'Du vant :money kr',
    'lost' => 'Du tapte',
    'push' => 'Uavgjort',
    'winCharlie' => '<b>Charlie! :cards kort</b> Du vinner :money kr',
    'winBlackjack' => '<b>Blackjack!</b> Du vinner :money kr',

    'stand' => 'Stå',
    'infoStand' => 'Avslutt hånden',
    'hit' => 'Slå',
    'infoHit' => 'Få et nytt kort',
    'split' => 'Splitt',
    'infoSplit2' => 'Lar deg ta to kort av samme verdi og splitte dem opp i hver sin hånd. Dette krever at du satser start beløpet ditt en gang til',
    'double' => 'Doble',
    'infoDouble2' => 'Doble det du satset på den nåværende hånden, vil gi deg ett kort til og så avslutte hånden.',

    'playAgain' => 'Spill igjen',


    //=============================================
    //================== CP.PHP ===================
    //=============================================

    'settings' => 'Blackjack Innstillinger',
    'useSoft17Label' => 'Dealer må trekke på en soft 17',
    'userCharlieLabel' => 'Aktiver "Charlie" regler',
    'charlieCardsNeededLabel' => 'Antall kort nødvendig for å få "Charlie"',
    'messageToUsersLabel' => 'Melding som skal vises til spillerne',
    'deckAmountLabel' => 'Antall kortstokker',
    'maxbetLabel' => 'Høyeste sum en bruker kan starte å satse med',
    'maxSplitsLabel' => 'Antall ganger spilleren kan splitte',
    'hitSplitAcesLabel' => 'Spilleren kan slå etter å ha splittet esser',
    'reSplitAcesLabel' => 'Spilleren kan re-splitte esser (andre kort kan alltid re-splittes)',
    'doubleLabel' => 'Spilleren kan doble',
    'anyDoubleOption' => 'Alltid',
    'doubleOptionRange' => 'Kun sum :range',
    'whenToDoubleLabel' => 'Når spilleren kan doble',
    'doubleAfterSplitLabel' => 'Spilleren kan doble etter å ha splittet',
    'save' => 'Lagre',
    'toGame' => 'Til spillet'
];