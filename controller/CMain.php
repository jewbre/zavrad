<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 7.3.2015.
 * Time: 14:41
 */

class CMain extends MJsonOutput{

    public function receiveAjax(){
        return json_decode(file_get_contents("php://input"));
    }

}