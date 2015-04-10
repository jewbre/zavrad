<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 7.4.2015.
 * Time: 23:02
 */

class CCategory extends CMain{

    public function all(){
        $this->setData(MCategory::getAll());
        $this->output();
    }

    public function update(){
        $params = $this->receiveAjax();
        $category = MCategory::get(intval($params->id));
        $category->name = $params->name;
        $category->status = $params->status;
        if($category->update()) {
            $this->setData(array("message" => t("successfulEdit")));
        } else {
            $this->setError(200, t("unsuccessfulEdit"));
        }
        $this->output();
    }

    public function save(){
        $params = $this->receiveAjax();

        $category = new MCategory();
        $category->name = $params->name;
        $category->status = $params->status;
        if($category->save()) {
            $this->setData(array("message" => t("successfulSave")));
        } else {
            $this->setError(200, t("unsuccessfulSave"));
        }
        $this->output();
    }

    public function delete(){
        $params = $this->receiveAjax();
        $category = MCategory::get($params->id);
        $category->delete();
    }
}