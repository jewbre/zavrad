<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 1.3.2015.
 * Time: 18:58
 */

/**
 * Autoloades all files. Used for including files when needed.
 * Make sure file name is equal to the actual file name.
 * File path can be empty string ("") or a subfolder path (ex. "model/MModel").
 * You can determine when to include a file:
 *  - "*" : always
 *  - array(n-values) : when specific route is selected
 */
$files = array(
//    array(name, path, includeWhen)
//        "includeWhen" => "*" | array("route1", "route2", "route3")

    // Models
    array("MDBConnection","model","*"),
    array("MJsonOutput","model","*"),
    array("MOption","model","*"),
    array("MUser","model","*"),
    array("MRegistration","model",array("registration")),
    // component should be loaded in more cases
    array("MTemplate","model",array("admin")),
    array("MComponent","model",array("admin")),
    array("MDesign","model","*"),

    // Controllers
    array("CMain","controller","*"),
    array("COptions","controller","*"),
    array("CRegistration","controller",array("registration")),
    array("CLogin","controller","*"),
    array("CComponent","controller",array("admin")),
    array("CUser","controller","*"),
    array("CDesign","controller","*"),

    // Views
    array("VOptions","view",array("admin")),
    array("VRegistration","view",array("registration")),
    array("VLogin","view",array("login")),
    array("VComponents","view",array("admin")),
    array("VGrid","view",array("admin")),
    array("VUsers","view",array("admin")),
    array("VTest","view","*"),

    // Exceptions
    array("InvalidIdentificator","exceptions","*"),
);

include_once "functions.php";
include_once "constants.php";

foreach($files as $file) {
    if($file[2] == "*" || in_array($atrs[0], $file[2])) {
        include_once $file[1] . "/" . $file[0] . ".php";
    }
}