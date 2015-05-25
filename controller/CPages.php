<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 3.5.2015.
 * Time: 0:59
 */

class CPages extends CMain{

    public function get(){
        $this->setData(MPage::getAll());
        $this->output();
    }

    public function save(){
        $params = $this->receiveAjax();
        $page = new MPage();
        $page->name = $params->name;
        $page->url = $params->url;
        if($page->save()) {
            $this->setData(array("message" => t("successfulSave")));
        } else {
            $this->setError(200, t("unsuccessfulSave"));
        }
        $this->output();
    }

    public function update(){
        $params = $this->receiveAjax();
        $page = MPage::get($params->id);
        $page->name = $params->name;
        $page->url = $params->url;
        if($page->update()) {
            $this->setData(array("message" => t("successfulEdit")));
        } else {
            $this->setError(200, t("unsuccessfulEdit"));
        }
        $this->output();

    }

    public function delete(){
        $params = $this->receiveAjax();
        $page = MPage::get($params->id);
        $page->delete();
    }

}