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

include_once "autoloader.php";

$admin = false;
if(restrictUser($atrs)) {

    if(CLogin::isLoggedIn()) {
        if(!CLogin::getLoggedIn()->isAdmin()) {
            header("Location: /");
            die();
        }
    } else {
        $redirect = "";
        foreach($atrs as $atr) {
            if(!empty($atr)) {
                $redirect .= "/" . $atr;
            }
        }

        if($redirect == "") $redirect = "/";

        $_SESSION["redirect"] = $redirect;

        header("Location: /login");
        die();
    }
}

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
            case "category" :
                switch($atrs[2]) {
                    case "all" :
                    $obj = new CCategory();
                        $obj->all();
                        die();
                    case "save" :
                        $obj = new CCategory();
                        $obj->save();
                        die();
                    case "update" :
                        $obj = new CCategory();
                        $obj->update();
                        die();
                    case "delete" :
                        $obj = new CCategory();
                        $obj->delete();
                        die();
                    default : $view = new VCategory();
                        break;
                }
                break;
            case "status" :
                switch($atrs[2]) {
                    case "regular" :
                        $obj = new CStatus();
                        $obj->regular();
                        die();
                }
                break;
            case "image" :
                switch($atrs[2]) {
                    case "upload" :
                        $obj = new CImages();
                        $obj->upload();
                        die();
                    case "get" :
                        $obj = new CImages();
                        $obj->get();
                        die();
                    case "delete" :
                        $obj = new CImages();
                        $obj->delete();
                        die();
                }
                break;
            case "currency" :
                switch($atrs[2]){
                    case "all" :
                        $obj = new CCurrency();
                        $obj->all();
                        die();
                }
                break;
            case "products" :
                switch($atrs[2]) {
                    case "all":
                        $obj = new CProducts();
                        $obj->all();
                        die();
                    case "save":
                        $obj = new CProducts();
                        $obj->save();
                        die();
                    case "update":
                        $obj = new CProducts();
                        $obj->update();
                        die();
                    case "get":
                        $obj = new CProducts();
                        $obj->get();
                        die();
                    case "delete":
                        $obj = new CProducts();
                        $obj->delete();
                        die();
                    default:
                        $view = new VProducts();
                        break;
                }
                break;
            case "shipping-method" :
                switch($atrs[2]) {
                    case "all":
                        $obj = new CShippingMethod();
                        $obj->getAll();
                        die();
                    case "save":
                        $obj = new CShippingMethod();
                        $obj->save();
                        die();
                    case "update":
                        $obj = new CShippingMethod();
                        $obj->update();
                        die();
                    case "get":
                        $obj = new CShippingMethod();
                        $obj->get();
                        die();
                    case "delete":
                        $obj = new CShippingMethod();
                        $obj->delete();
                        die();
                    default:
                        $view = new VShippingMethods();
                        break;
                }
                break;
            case "payment-method" :
                switch($atrs[2]) {
                    case "all":
                        $obj = new CPaymentMethod();
                        $obj->getAll();
                        die();
                    case "save":
                        $obj = new CPaymentMethod();
                        $obj->save();
                        die();
                    case "update":
                        $obj = new CPaymentMethod();
                        $obj->update();
                        die();
                    case "get":
                        $obj = new CPaymentMethod();
                        $obj->get();
                        die();
                    case "delete":
                        $obj = new CPaymentMethod();
                        $obj->delete();
                        die();
                    default:
                        $view = new VPaymentMethods();
                        break;
                }
                break;
            case "storage":
                switch($atrs[2]) {
                    case "cards":
                        $obj = new CStorage();
                        $obj->cards();
                        die();
                    case "new":
                        $obj = new CStorage();
                        $obj->newCard();
                        die();
                    case "inouts":
                        $obj = new CStorage();
                        $obj->getInOut();
                        die();
                    default :
                        $view = new VStorage();
                        break;
                }
                break;
            case "media" :
                switch($atrs[2]) {
                    case "library" :
                    default:
                        $view = new VMediaLibrary();
                        break;
                }
                break;
            case "pages" :
                switch($atrs[2]) {
                    case "get" :
                        $obj = new CPages();
                        $obj->get();
                        die();
                    case "save" :
                        $obj = new CPages();
                        $obj->save();
                        die();
                    case "update" :
                        $obj = new CPages();
                        $obj->update();
                        die();
                    case "delete" :
                        $obj = new CPages();
                        $obj->delete();
                        die();
                    default : $view = new VPages();
                        break;
                }
                break;
            default: $view = new VOptions();
                break;
        }
        break;

    case "api" :
        switch($atrs[1]){
            case "cart" :
                switch($atrs[2]){
                    case "get" :
                        $obj = new CCart();
                        $obj->get();
                        die();
                    case "add" :
                        $obj = new CCart();
                        $obj->add();
                        die();
                    case "remove" :
                        $obj = new CCart();
                        $obj->remove();
                        die();
                }
                break;
        }
        break;
    case "registration" :
        if(CLogin::isLoggedIn()) {
            header("Location: /");
            die();
        }
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
        if(CLogin::isLoggedIn()) {
            header("Location: /");
            die();
        }
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
    case "logout" :
        $obj = new CLogin();
        $obj->logout();
        break;
    case "options" :
        switch($atrs[1]){
            case "get":
                $obj = new COptions();
                $obj->get();
                die();
                break;
            case "save":
                $obj = new COptions();
                $obj->save();
                die();
                break;
            case "saveMenu":
                $obj = new COptions();
                $obj->saveMenu();
                die();
                break;
            case "saveSlider":
                $obj = new COptions();
                $obj->saveSlider();
                die();
                break;
        };
        break;




    case "test":
        $view = new VTest();
        break;
    default :
        if($page = MPage::getByUrl("/".$route)) {
            if($design = MDesign::getByPage($page->id)) {
            } else {
                $design = MDesign::getByPage(1);
            }
        }

}

$r =  explode('?', $_SERVER['REQUEST_URI'], 2);
$data = array("route"=> $r, "routeElements" => explode("/", $r[0]));

if($atrs[0] == "admin") {
    $data["renderHeader"] = false;
    $layout = new VAdminLayout();
    $layout->setupLayout($view, $data);
} else if(intval($atrs[1])){
    $data["renderHeader"] = true;
    $page = MPage::getByUrl("/".$atrs[0]."/{id}");
    $design = MDesign::getByPage($page->id);
    $layout = new VDisplayLayout($design);
    $layout->setupLayout(null, $data);
} else if($page = MPage::getByUrl("/".$route)) {
    $data["renderHeader"] = true;
    $design = MDesign::getByPage($page->id);
    $layout = new VDisplayLayout($design);
    $layout->setupLayout(null, $data);
} else {
    $header = new Header();
    $header->renderPartial();
    $view->renderPartial();
    $route =  explode('?', $_SERVER['REQUEST_URI'], 2);
    $route = $route[0];
    $footer = new Footer();
    $footer->renderPartial();
}
