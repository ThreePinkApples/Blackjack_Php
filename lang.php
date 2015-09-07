'<?php
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
    $text = utf8_encode($text[$index]);
    if($replace !== ''){
        foreach($replace as $key => $word){
            $text = str_replace(':'.$key, $word, $text);
        }
    }
    $text = htmlentities($text);
    $text = str_replace(["&lt;i&gt;", "&lt;b&gt;", "&lt;/i&gt;", "&lt;/b&gt;"], ["<i>", "<b>", "</i>", "</b>"], $text);
    return $text;
}


$result = '<form method="POST">';
$result .= '<div class="form-group">';
$result .= '<select name="lang" id="lang" class="form-control" onchange="this.form.submit()">';
foreach($langs as $short => $lang){
    $result .= '<option value="'.$short.'"';
    if(isset($_SESSION['lang']) && $_SESSION['lang'] === $short)
        $result .= 'selected';
    $result .= '>' . $lang;
    $result .= '</option>';
}
$result .='</select>';
$result .='</div>';
$result .= '</form>';

echo $result;