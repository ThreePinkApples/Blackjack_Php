<?php
/**
 * Created by PhpStorm.
 * User: inste
 * Date: 07.09.2015
 * Time: 16.17
 */

$langs = [
    'en'    => 'English',
    'no'    => 'Norsk',
];
if(!isset($_SESSION['lang'])){
    $_SESSION['lang'] = 'en';
}


if(isset($_POST['lang'])){
    $_SESSION['lang'] = $_POST['lang'];
}

function trans($index, $replace = ''){
    global $langs;
    $text = include('lang/'.$langs[$_SESSION['lang']].'.php');
    $text = $text[$index];
    if($replace !== ''){
        foreach($replace as $key => $word){
            $text = str_replace(':'.$key, $word, $text);
        }
    }
    $text = htmlentities($text);
    $text = str_replace(["&lt;i&gt;", "&lt;b&gt;", "&lt;/i&gt;", "&lt;/b&gt;", "&lt;br /&gt;", "&lt;br/&gt;"], ["<i>", "<b>", "</i>", "</b>", "<br />", "<br />"], $text);
    return $text;
}