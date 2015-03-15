<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 2.3.2015.
 * Time: 20:27
 */

function t($value){
    include "lang/" . $_SESSION["lang"] . ".php";
    if(!isset($lang[$value])) return "";
    return $lang[$value];

}

function image($image) {
    return baseUrl("images/".$image);
}

function baseUrl($url) {
    return "http://".$_SERVER['SERVER_NAME']."/".$url;
}