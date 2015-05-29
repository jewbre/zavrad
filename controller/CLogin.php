<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 10.3.2015.
 * Time: 20:06
 */

class CLogin extends CMain{

    /**
     * Logs in user if provided data is correct.
     *
     * Invoked at: /login/login
     *
     * @throws InvalidIdentificator when provided with invalid id type. Valid id types are email address and id of the user.
     */
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


    /**
     * Save successful login to client.
     * @param $user
     */
    public static function registerLogin(MUser $user){
        $user->createSessionId();
        $_SESSION["web-user"] = $user->_session_id;
    }

    /**
     * Check if there is a logged in user.
     * @return bool
     */
    public static function isLoggedIn(){
        return !empty($_SESSION["web-user"]);
    }

    /**
     * Retrieve logged in user, if such exists, or null.
     * @return MUser|null
     */
    public static function getLoggedIn(){
        if(CLogin::isLoggedIn()) {
            return MUser::getUserBySessionId($_SESSION["web-user"]);
        }
        return null;
    }
}