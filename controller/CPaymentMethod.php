<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 29.5.2015.
 * Time: 4:54
 */

class CPaymentMethod extends CMain {

    public function get()
    {
        $params = $this->receiveAjax();

        $this->setData(MPaymentMethod::get($params->id));
        $this->output();

    }

    public function getAll()
    {
        $this->setData(MPaymentMethod::getAll());
        $this->output();
    }

    public function getActive()
    {
        $this->setData(MPaymentMethod::getActive());
        $this->output();
    }

    public function save()
    {
        $params = $this->receiveAjax();

        $hasErrors = false;

        if(empty($params->name->value)){
            $params->name->error = t("emptyName");
            $hasErrors = true;
        } else {
            $params->name->error = "";
        }

        if($hasErrors) {
            $this->setFailure($params);
            return;
        }

        $msm = new MPaymentMethod();
        $msm->name = $params->name->value;
        $msm->setStatus($params->status->value);
        $msm->save();

        $this->setData($msm);
        $this->output();
    }


    public function update()
    {
        $params = $this->receiveAjax();

        $hasErrors = false;

        if(empty($params->name->value)){
            $params->name->error = t("emptyName");
            $hasErrors = true;
        } else {
            $params->name->error = "";
        }

        if($hasErrors) {
            $this->setFailure($params);
            return;
        }

        $msm = MPaymentMethod::get($params->id);
        $msm->name = $params->name->value;
        $msm->setStatus($params->status->value);
        $msm->update();

        $this->setData($msm);
        $this->output();
    }

    public function delete()
    {
        $params = $this->receiveAjax();
        $msm = MPaymentMethod::get($params->id);
        $msm->delete();
    }

    public function deactivate()
    {
        $params = $this->receiveAjax();
        $msm = MPaymentMethod::get($params->id);
        $msm->deactivate();
    }

    public function activate()
    {
        $params = $this->receiveAjax();
        $msm = MPaymentMethod::get($params->id);
        $msm->activate();
    }
}