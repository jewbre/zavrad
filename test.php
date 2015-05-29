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


//$tmp = MTemplate::get(3);
$tmp = new MTemplate();
/* Menu */
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

/* Basic listing 1*/
//$tmp->name = "productListingLabel";
//$tmp->defaultOptions = array(
//    "backgroundColor" => array(
//        "name" => "backgroundColorLabel",
//        "type" => "backgroundColor",
//        "value" => "#fff",
//        "error" => "",
//    ),
//    "textColor" => array(
//        "name" => "textColorLabel",
//        "type" => "textColor",
//        "value" => "#000",
//        "error" => "",
//    ),
//    "name" => "basic-listing-1"
//);

/* Slider */
//$tmp->name = "sliderLabel";
//$tmp->defaultOptions = array(
//    "sliderImages" => array(
//        "name" => "slider",
//        "type" => MTemplate::TYPE_SLIDER,
//        "images" => array(
//            array(
//                "url" => ""
//            )
//        )
//    ),
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
//    "name" => "slider-1"
//);


/* Basic listing 2*/
//$tmp->name = "productListing2Label";
//$tmp->defaultOptions = array(
//    "backgroundColor" => array(
//        "name" => "backgroundColorLabel",
//        "type" => "backgroundColor",
//        "value" => "#fff",
//        "error" => "",
//    ),
//    "textColor" => array(
//        "name" => "textColorLabel",
//        "type" => "textColor",
//        "value" => "#000",
//        "error" => "",
//    ),
//    "name" => "basic-listing-2"
//);


/* Single modern */

//$tmp->name = "singleModernLabel";
//$tmp->defaultOptions = array(
//    "backgroundColor" => array(
//        "name" => "backgroundColorLabel",
//        "type" => "backgroundColor",
//        "value" => "#fff",
//        "error" => "",
//    ),
//    "textColor" => array(
//        "name" => "textColorLabel",
//        "type" => "textColor",
//        "value" => "#000",
//        "error" => "",
//    ),
//    "name" => "single-modern"
//);


/* Basic cart */
$tmp->name = "basicCartLabel";
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
    "name" => "basic-cart"
);

//$tmp->update();
$tmp->save();
var_dump(MTemplate::getAll());
