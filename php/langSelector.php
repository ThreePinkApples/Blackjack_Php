<?php
/**
 * Created by PhpStorm.
 * User: inste
 * Date: 18.09.2015
 * Time: 12.52
 */

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