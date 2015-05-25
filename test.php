<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 12.3.2015.
 * Time: 1:17
 */
session_start();
include_once "constants.php";
include_once "functions.php";
include_once "model/MDBConnection.php";
include_once "model/MTemplate.php";
include_once "model/MComponent.php";


$tmp = MTemplate::get(1);
//$tmp->name = "menuLabel";
//$tmp->defaultOptions = array(
//    "menuItems" => array(
//        "name" => "menuItems",
//        "type" => MTemplate::TYPE_MENU_ITEMS,
//        "items" => array(
//            array(
//                "value" => "Menu item example",
//                "error" => "",
//            )
//        )
//    ),
//    "backgroundColor" => array(
//        "name" => "backgroundColorLabel",
//        "type" => "backgroundColor",
//        "value" => "",
//        "error" => ""
//    ),
//    "textColor" => array(
//        "name" => "textColorLabel",
//        "type" => "textColor",
//        "value" => "",
//        "error" => ""
//    ),
//    "name" => "basic-menu-1"
//);

$tmp->name = "productListingLabel";
$tmp->defaultOptions = array(
    "backgroundColor" => array(
        "name" => "backgroundColorLabel",
        "type" => "backgroundColor",
        "value" => "#fff",
        "error" => "",
    ),
    "textColor" => array(
        "name" => "textColorLabel",
        "type" => "textColor",
        "value" => "#000",
        "error" => "",
    ),
    "name" => "basic-listing-1"
);
$tmp->update();

var_dump(MTemplate::getAll());
