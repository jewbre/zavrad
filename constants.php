<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 1.3.2015.
 * Time: 19:23
 */


switch($_SERVER["SERVER_NAME"]) {
    case "webshop.loc" :
        define("HOSTNAME","localhost");
        define("DBNAME","webshop");
        define("DB_USERNAME","root");
        define("DB_PASSWORD","");
        break;
    case "webshop.vdl.hr":
        define("HOSTNAME","");
        define("DBNAME","vdlhr_webshop");
        define("DB_USERNAME","vdlhr_vilim");
        define("DB_PASSWORD","vilim123");
        break;
}
