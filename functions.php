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

function restrictUser($atrs) {
    $restrict = false;
    switch($atrs[0]) {
        case "admin" :
            $admin = true;
            switch($atrs[1]) {
                case "options":
                    $restrict = true;
                case "components" :
                    switch($atrs[2]) {
                        case "get" :
                        case "save" :
                        case "update" :
                        case "delete" :
                        case "templates" :
                            $restrict = false;
                            break;
                        default :
                            $restrict = true;
                    }
                    break;
                case "users":
                    switch($atrs[2]) {
                        case "get":
                        case "authorities":
                        case "add":
                        case "delete":
                        case "update":
                            $restrict = false;
                            break;
                        default :
                            $restrict = true;
                    }
                    break;
                case "builder" :
                    $restrict = true;
                    break;
                case "design" :
                    switch($atrs[2]) {
                        case "save" :
                        case "update" :
                        case "delete" :
                        case "all" :
                            $restrict = false;
                    }
                    break;
                case "category" :
                    switch($atrs[2]) {
                        case "all" :
                        case "save" :
                        case "update" :
                        case "delete" :
                            $restrict = false;
                            break;
                        default :
                            $restrict = true;
                            break;
                    }
                    break;
                case "status" :
                    switch($atrs[2]) {
                        case "regular" :
                            $restrict = false;
                            break;
                    }
                    break;
                case "image" :
                    switch($atrs[2]) {
                        case "upload" :
                        case "get" :
                        case "delete" :
                            $restrict = false;
                            break;
                    }
                    break;
                case "currency" :
                    switch($atrs[2]){
                        case "all" :
                            $restrict = false;
                            break;
                    }
                    break;
                case "products" :
                    switch($atrs[2]) {
                        case "all":
                        case "save":
                        case "update":
                        case "get":
                            $restrict = false;
                            break;
                        default:
                            $restrict = true;
                            break;
                    }
                    break;
                case "shipping-method" :
                    switch($atrs[2]) {
                        case "all":
                        case "save":
                        case "update":
                        case "get":
                        case "delete":
                            $restrict = false;
                            break;
                        default:
                            $restrict = true;
                            break;
                    }
                    break;
                case "payment-method" :
                    switch($atrs[2]) {
                        case "all":
                        case "save":
                        case "update":
                        case "get":
                        case "delete":
                            $restrict = false;
                            break;
                        default:
                            $restrict = true;
                            break;
                    }
                    break;
                case "storage":
                    switch($atrs[2]) {
                        case "cards":
                        case "new":
                        case "inouts":
                            $restrict = false;
                            break;
                        default :
                            $restrict = true;
                            break;
                    }
                    break;
                case "media" :
                    switch($atrs[2]) {
                        case "library" :
                        default:
                            $restrict = true;
                            break;
                    }
                    break;
                case "pages" :
                    switch($atrs[2]) {
                        case "get" :
                        case "save" :
                        case "update" :
                        case "delete" :
                            $restrict = false;
                            break;
                        default :
                            $restrict = true;
                            break;
                    }
                    break;
                default:
                    $restrict = true;
                    break;
            }
            break;

        case "api" :
            switch($atrs[1]){
                case "cart" :
                    switch($atrs[2]){
                        case "get" :
                        case "add" :
                        case "remove" :
                            $restrict = false;
                            break;
                    }
                    break;
            }
            break;
        case "registration" :
            switch($atrs[1]) {
                case "register":
                default:
                    $restrict = false;
                    break;
            }
            break;
        case "login" :
            switch($atrs[1]) {
                case "login":
                default:
                    $restrict = false;
                    break;
            }
            break;
        case "logout" :
            $restrict = false;
            break;
        case "options" :
            switch($atrs[1]){
                case "get":
                case "save":
                    $restrict = false;
                    break;
            };
            break;
        default :
            $restrict = false;

    }

    return $restrict;

}

function isCurrentLanguage($value){
    return $_SESSION["lang"] == $value;
}