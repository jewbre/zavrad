<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 29.5.2015.
 * Time: 4:42
 */

class CShippingMethod extends CMain{

    public function get()
    {
        $params = $this->receiveAjax();

        $this->setData(MShippingMethod::get($params->id));
        $this->output();

    }

    public function getAll()
    {
        $this->setData(MShippingMethod::getAll());
        $this->output();
    }

    public function getActive()
    {
        $this->setData(MShippingMethod::getActive());
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

        $msm = new MShippingMethod();
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

        $msm = MShippingMethod::get($params->id);
        $msm->name = $params->name->value;
        $msm->setStatus($params->status->value);
        $msm->update();

        $this->setData($msm);
        $this->output();
    }

    public function delete()
    {
        $params = $this->receiveAjax();
        $msm = MShippingMethod::get($params->id);
        $msm->delete();
    }

    public function deactivate()
    {
        $params = $this->receiveAjax();
        $msm = MShippingMethod::get($params->id);
        $msm->deactivate();
    }

    public function activate()
    {
        $params = $this->receiveAjax();
        $msm = MShippingMethod::get($params->id);
        $msm->activate();
    }
}