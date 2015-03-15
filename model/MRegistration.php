<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 7.3.2015.
 * Time: 15:04
 */

class MRegistration {

    private $_data;

    public function MRegistration($data) {
        $this->_data = $data;
    }

    public function validate(){
        $valid = true;

        if(!filter_var($this->_data->email->value, FILTER_VALIDATE_EMAIL)) {
            $valid = false;
            $this->_data->email->error = t("invalidEmail");
            $this->_data->email->hasError = true;
        } else {
            $this->_data->email->error = "";
            $this->_data->email->hasError = false;
        }

        if(!$this->_data->email->hasError) {
            if(!MUser::checkUniqueEmail($this->_data->email->value)) {
                $valid = false;
                $this->_data->email->error = t("notUniqueEmail");
                $this->_data->email->hasError = true;
            } else {
                $this->_data->email->error = "";
                $this->_data->email->hasError = false;
            }
        }

        if(strlen($this->_data->password->value) < 3 || strlen($this->_data->password->value) > 20) {
            $valid = false;
            $this->_data->password->error = t("invalidPasswordLength");
            $this->_data->password->hasError = true;
        } else {
            $this->_data->password->error = "";
            $this->_data->password->hasError = false;
        }

        if($this->_data->password->hasError || $this->_data->password->value != $this->_data->passwordRepeat->value) {
            $valid = false;
            $this->_data->passwordRepeat->error = t("unequalPasswords");
            $this->_data->passwordRepeat->hasError = true;
        } else {
            $this->_data->passwordRepeat->error = "";
            $this->_data->passwordRepeat->hasError = false;
        }

        return $valid;
    }


    public function registerUser(){
        $user = new MUser($this->_data->email->value, $this->_data->password->value);
        $user->save();

        $this->_data->email->value = "";
        $this->_data->password->value = "";
        $this->_data->passwordRepeat->value = "";
        return $user;
    }


    public function getData(){
        return $this->_data;
    }

}