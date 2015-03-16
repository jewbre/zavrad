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


$tmp = MTemplate::get(2);
$tmp->defaultOptions = array(
    "menuItems" => array(
        "name" => "menuItems",
        "type" => MTemplate::TYPE_MENU_ITEMS,
        "items" => array(
            array(
                "value" => "Menu item example",
                "error" => "",
            )
        )
    ),
    "backgroundColor" => array(
        "name" => "backgroundColorLabel",
        "type" => "backgroundColor",
        "value" => "",
        "error" => ""
    ),
    "textColor" => array(
        "name" => "textColorLabel",
        "type" => "textColor",
        "value" => "",
        "error" => ""
    ),
);
$tmp->update();

var_dump(MTemplate::getAll());
