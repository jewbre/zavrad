<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 10.3.2015.
 * Time: 20:06
 */

class CLogin extends CMain{

    public function login(){
        $params = $this->receiveAjax();
        $user = MUser::get($params->data->email->value);
        if($user != null) {
            if($user->checkPassword($params->data->password->value)) {
                $params->data->error->value = "";
                $params->data->error->hasError = false;
                $this->setData(
                    array(
                        "valid" => true,
                        "data" => $params,
                    )
                );

                CLogin::registerLogin($user);
            } else {
                $params->data->error->value = t("invalidLogin");
                $params->data->error->hasError = true;
                $this->setData(
                    array(
                        "valid" => false,
                        "data" => $params,
                    )
                );
            }
        } else {
            $params->data->error->value = t("invalidLogin");
            $params->data->error->hasError = true;
            $this->setData(
                array(
                    "valid" => false,
                    "data" => $params,
                )
            );
        }
        $this->output();
    }


    public static function registerLogin($user){
        $_SESSION["web-user"] = json_encode($user);
    }

    public static function isLoggedIn(){
        return !empty($_SESSION["web-user"]);
    }

    public static function getLoggedIn(){
        if(CLogin::isLoggedIn()) {
            return json_decode($_SESSION["web-user"]);
        }
        return null;
    }
}