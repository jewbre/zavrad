<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 1.3.2015.
 * Time: 19:14
 */

class COptions extends CMain{

    public $options = array();

    // todo: finish this class

    /**
     * Retrieve all options from database.
     */
    public function get(){
        $this->setData(MOption::getAll());

        $this->output();
    }

    public function save()
    {
        $params = $this->receiveAjax();

        foreach($params as $name => $option){
            $mo = new MOption($name, $name == "allowBuying" ? intval($option->value) : $option->value);
            var_dump($mo);
            var_dump($mo->saveOrUpdate());
        }
    }
}