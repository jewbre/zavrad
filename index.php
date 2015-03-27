<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 1.3.2015.
 * Time: 18:30
 */
session_start();

if(!isset($_SESSION["lang"])) {
    $_SESSION["lang"] = "en";
}
if(isset($_GET["lang"])) {
    $lang = $_GET["lang"];
    if(in_array($lang, array("en","cro"))) {
        $_SESSION["lang"] = $lang;
    }
}


$route = (isset($_REQUEST["r"]) ? $_REQUEST["r"] : "");
$atrs = explode("/", $route);
$atrs[1] = (isset($atrs[1]) ? $atrs[1] : "");
$atrs[2] = (isset($atrs[2]) ? $atrs[2] : "");


include_once "header.php";
include_once "footer.php";
include_once "autoloader.php";



switch($atrs[0]) {
    case "admin" :
        switch($atrs[1]) {
            case "options":
                $view = new VOptions();
                break;
            case "components" :
                switch($atrs[2]) {
                    case "get" :
                        $obj = new CComponent();
                        $obj->get();
                        die();
                    case "save" :
                        $obj = new CComponent();
                        $obj->save();
                        die();
                    case "update" :
                        $obj = new CComponent();
                        $obj->update();
                        die();
                    case "delete" :
                        $obj = new CComponent();
                        $obj->delete();
                        die();
                    case "templates" :
                        $obj = new CComponent();
                        $obj->getTemplates();
                        die();
                    default :
                        $view = new VComponents();
                        break;
                }
                break;
            case "users":
                switch($atrs[2]) {
                    case "get":
                        $obj = new CUser();
                        $obj->listUsers();
                        die();
                    case "authorities":
                        $obj = new CUser();
                        $obj->getAuthorities();
                        die();
                    case "add":
                        $obj = new CUser();
                        $obj->addNewUser();
                        die();
                    case "delete":
                        $obj = new CUser();
                        $obj->deleteUser();
                        die();
                    case "update":
                        $obj = new CUser();
                        $obj->updateUser();
                        die();
                    default :
                        $view = new VUsers();
                }
                break;
            case "builder" :
                $view = new VGrid();
                break;
            case "design" :
                switch($atrs[2]) {
                    case "save" :
                        $obj = new CDesign();
                        $obj->save();
                        die();
                    case "update" :
                        $obj = new CDesign();
                        $obj->update();
                        die();
                    case "delete" :
                        $obj = new CDesign();
                        $obj->delete();
                        die();
                    case "all" :
                        $obj = new CDesign();
                        $obj->getAll();
                        die();
                }
                break;
        }
        break;

    case "registration" :
        switch($atrs[1]) {
            case "register":
                $obj = new CRegistration();
                $obj->register();
                die();
            default:
                $view = new VRegistration();
                break;
        }
        break;
    case "login" :
        switch($atrs[1]) {
            case "login":
                $obj = new CLogin();
                $obj->login();
                die();
                break;
            default:
                $view = new VLogin();
                break;
        }
        break;





    case "test":
        $view = new VTest();
        break;
    default :
//        var_dump("default akcija: ".$route, $atrs);
//        var_dump(CLogin::getLoggedIn());
        include_once "index2.html";
        die();
}

$header = new Header();
$header->renderPartial();
$view->renderPartial();
$route =  explode('?', $_SERVER['REQUEST_URI'], 2);
$route = $route[0];
$footer = new Footer();
$footer->renderPartial(array("route"=> $route));