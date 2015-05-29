<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 29.5.2015.
 * Time: 3:55
 */

class CShippingAddress extends CMain {

    public function get()
    {
        $params = $this->receiveAjax();
        $this->setData(MShippingAddress::get($params->id));

        $this->output();
    }

    public function getUserAdresses()
    {
        $user = CLogin::getLoggedIn();
        $this->setData(MShippingAddress::getUserAddresses($user->_id));

        $this->output();
    }

    public function save()
    {
        $params = $this->receiveAjax();

        $hasErrors = false;

        if(empty($params->recipient->value)) {
            $params->recipient->error = t("emptyRecipientName");
            $hasErrors = true;
        } else {
            $params->recipient->error = "";
        }


        if(empty($params->address->value)) {
            $params->address->error = t("emptyAddress");
            $hasErrors = true;
        } else {
            $params->address->error = "";
        }


        if(empty($params->city->value)) {
            $params->city->error = t("emptyCityName");
            $hasErrors = true;
        } else {
            $params->city->error = "";
        }


        if(empty($params->country->value)) {
            $params->country->error = t("emptyCountryName");
            $hasErrors = true;
        } else {
            $params->country->error = "";
        }


        if(empty($params->postal_code->value)) {
            $params->postal_code->error = t("emptyPostalCode");
            $hasErrors = true;
        } else {
            $params->postal_code->error = "";
        }

        if($hasErrors) {
            $this->setFailure($params);

            $this->output();
            return;
        }


        $msa = new MShippingAddress();
        $msa->recipient = $params->recipient->value;
        $msa->address = $params->address->value;
        $msa->address_extra = $params->address_extra->value;
        $msa->city = $params->city->value;
        $msa->country = $params->country->value;
        $msa->postal_code = $params->postal_code->value;
        $msa->status = MStatus::ACTIVE;
        $msa->save();

        $this->setData($msa);
        $this->output();
    }

    public function update()
    {
        $params = $this->receiveAjax();

        $hasErrors = false;

        if(empty($params->recipient->value)) {
            $params->recipient->error = t("emptyRecipientName");
            $hasErrors = true;
        } else {
            $params->recipient->error = "";
        }


        if(empty($params->address->value)) {
            $params->address->error = t("emptyAddress");
            $hasErrors = true;
        } else {
            $params->address->error = "";
        }


        if(empty($params->city->value)) {
            $params->city->error = t("emptyCityName");
            $hasErrors = true;
        } else {
            $params->city->error = "";
        }


        if(empty($params->country->value)) {
            $params->country->error = t("emptyCountryName");
            $hasErrors = true;
        } else {
            $params->country->error = "";
        }


        if(empty($params->postal_code->value)) {
            $params->postal_code->error = t("emptyPostalCode");
            $hasErrors = true;
        } else {
            $params->postal_code->error = "";
        }

        if($hasErrors) {
            $this->setFailure($params);

            $this->output();
            return;
        }


        $msa = MShippingAddress::get($params->id);
        $msa->recipient = $params->recipient->value;
        $msa->address = $params->address->value;
        $msa->address_extra = $params->address_extra->value;
        $msa->city = $params->city->value;
        $msa->country = $params->country->value;
        $msa->postal_code = $params->postal_code->value;
        $msa->status = $params->status->value;
        $msa->update();

        $this->setData($msa);
        $this->output();
    }

    public function deactivate()
    {
        $params = $this->receiveAjax();
        $msa = MShippingAddress::get($params->id);
        $msa->deactivate();

        $this->setData($msa);
        $this->output();
    }

    public function delete()
    {
        $params = $this->receiveAjax();
        $msa = MShippingAddress::get($params->id);
        $msa->delete();
    }

}