<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 25.3.2015.
 * Time: 22:05
 */

class CUser extends CMain{

    public function listUsers(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT id,email,authority FROM user");
        $sql->execute();
        foreach($sql->fetchAll(PDO::FETCH_OBJ) as $user) {
            $data[] = $user;
        }

        $this->setData($data);
        $this->output();
    }

    public function getAuthorities(){
        $this->setData(array(
            array("value" => 2, "name" => "User"),
            array("value" => 3, "name" => "Moderator"),
            array("value" => 4, "name" => "Admin"),
        )
        );
        $this->output();
    }

    public function addNewUser(){
        $params = $this->receiveAjax();
        $valid = true;

        if(!filter_var($params->email->value, FILTER_VALIDATE_EMAIL)) {
            $valid = false;
            $params->email->error = t("invalidEmail");
            $params->email->hasError = true;
        } else {
            $params->email->error = "";
            $params->email->hasError = false;
        }


        if($valid && MUser::checkUniqueEmail($params->email->value)) {
            $params->email->error = "";
            $params->email->hasError = false;
        } else {
            $valid = false;
            $params->email->error = t("duplicateEmail");
            $params->email->hasError = true;
        }

        if(strlen($params->password->value) < 3 || strlen($params->password->value) > 20) {
            $valid = false;
            $params->password->error = t("invalidPasswordLength");
            $params->password->hasError = true;
        } else {
            $params->password->error = "";
            $params->password->hasError = false;
        }

        if($valid) {
            $user = new MUser($params->email->value, $params->password->value);
            $user->save();
        }

        $this->setData(
            array(
                "valid" => $valid,
                "params" => $params,
            )
        );
        $this->output();
    }

    public function deleteUser(){
        $params = $this->receiveAjax();
        $user = MUser::get($params->id);
        if(!empty($user)) {
            $user->delete();
        }
        $this->setData("");
        $this->output();
    }

    public function updateUser(){
        $params = $this->receiveAjax();
        $valid = true;


        if(!empty($params->password->value) && (strlen($params->password->value) < 3 || strlen($params->password->value) > 20)) {
            $valid = false;
            $params->password->error = t("invalidPasswordLength");
            $params->password->hasError = true;
        } else {
            $params->password->error = "";
            $params->password->hasError = false;
        }

        if($valid) {
            $user = MUser::get($params->email->value);
            if(!empty($params->password->value)) {
                $user->changePassword($params->password->value);
            }
            $user->changeAuthority($params->authority->value);
            $user->update();
        }

        $this->setData(
            array(
                "valid" => $valid,
                "params" => $params,
            )
        );
        $this->output();
    }
}