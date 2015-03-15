<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 12.3.2015.
 * Time: 1:17
 */
include_once "constants.php";
include_once "model/MDBConnection.php";
include_once "model/MComponent.php";
var_dump(MComponent::getComponents(1,10));