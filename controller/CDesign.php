<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 27.3.2015.
 * Time: 2:04
 */

class CDesign extends CMain{

    public function save(){
        $params = $this->receiveAjax();
        $md = new MDesign();
        $md->name = $params->name;
        $md->data = $params->data;
        $md->page = $params->page;
        $md->save();
    }

    public function update(){
        $params = $this->receiveAjax();
        $md = new MDesign();
        $md->id = $params->id;
        $md->name = $params->name;
        $md->data = $params->data;
        $md->page = $params->page;
        $md->update();
    }

    public function delete(){
        $params = $this->receiveAjax();
        $md = MDesign::get($params->id);
        if(!empty($md)) {
            $md->delete();
        }
    }

    public function getAll(){
        $this->setData(MDesign::getAll());
        $this->output();
    }
}