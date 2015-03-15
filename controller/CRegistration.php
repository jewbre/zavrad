<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 7.3.2015.
 * Time: 14:40
 */

class CRegistration extends CMain{

    public function register(){
        $data = $this->receiveAjax();

        $registration = new MRegistration($data->data);
        $valid = $registration->validate();

        if($valid) {
            CLogin::registerLogin(
                $registration->registerUser()
            );
        }

        $this->setData(
            array(
                "valid" => $valid,
                "data" => $registration->getData(),
                "successMessage" => t("successfulRegistration"),
            )
        );

        $this->output();
    }
}