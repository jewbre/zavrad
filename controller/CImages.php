<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 9.4.2015.
 * Time: 11:26
 */

class CImages extends CMain{

    public function upload(){
        $this->setData(MImage::handleFileUpload());
        $this->output();
    }

    public function get(){
        $params = $this->receiveAjax();
        $this->setData(MImage::getImages($params->page));
        $this->output();
    }

    public function delete(){
        $params = $this->receiveAjax();
        $image = MImage::get($params->id);
        if($image->delete()){
            $this->setData("success");
        } else {
            $this->setError(-1,"error");
        }
        $this->output();
    }
}