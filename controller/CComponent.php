<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 12.3.2015.
 * Time: 0:32
 */

class CComponent extends CMain{

    public function save(){
        $params = $this->receiveAjax();
        $params = MComponent::validate($params);
        if($params->data->hasError) {
            $this->setData(array(
                "params" => $params->data
            ));
        } else {
            $component = $this->fillFromParams($params);
            $component->save();

            $params = $this->emptyParams($params);

            $this->setData(array(
                "components" => MComponent::getComponents(),
                "params" => $params->data,
            ));
        }

        $this->output();

    }

    public function update(){
        $params = $this->receiveAjax();
        $params = MComponent::validate($params);
        if($params->data->hasError) {
            $this->setData(array(
                "params" => $params->data
            ));
        } else {
            $component = $this->fillFromParams($params);
            $component->update();

            $params = $this->emptyParams($params);

            $this->setData(array(
                "components" => MComponent::getComponents(),
                "params" => $params->data,
            ));
        }

        $this->output();

    }

    public function delete(){
        $params = $this->receiveAjax();
        $component = MComponent::get($params->data->id);
        $component->delete();
        $this->setData(array(
            "components" => MComponent::getComponents(),
        ));
        $this->output();
    }

    public function get(){
        $this->setData(array(
            "components" => MComponent::getComponents(),
        ));
        $this->output();
    }

    private function fillFromParams($params) {
        $component = new MComponent();
        $component->id = $params->data->id;
        $component->name = $params->data->name->value;
        $component->template = $params->data->template->value;
        $component->width = $params->data->dimensions->width;
        $component->height = $params->data->dimensions->height;
        $component->description = $params->data->description->value;

        return $component;
    }

    private function emptyParams($params) {
        $params->data->name->value = "";
        $params->data->name->error = "";

        $params->data->template->value = "";
        $params->data->template->error = "";

        $params->data->dimensions->width = "";
        $params->data->dimensions->height = "";
        $params->data->dimensions->error = "";

        $params->data->description->value = "";
        $params->data->description->error = "";

        return $params;
    }
}