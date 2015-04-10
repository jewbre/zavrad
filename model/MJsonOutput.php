<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 7.3.2015.
 * Time: 12:57
 */

/**
 *
 * Handles all json outputs.
 *
 * Class MJsonOutput
 */
class MJsonOutput {


    private $_data = null;
    private $_success = null;

    /**
     * Sets private variable data to provided value. Success is considered true in this case.
     * @param $data
     */
    public function setData($data) {
        $this->_data = $data;
        $this->_success = true;
    }


    /**
     * Retrieves data from object. Returns null if data has not been set yet.
     * @return null|mixed
     */
    public function getData() {
        return $this->_data;
    }

    /**
     * Provides an error. Error should have its error code and description.
     * Use translator option for description so that all errors are globalized.
     *
     * @param $errorCode internal project error code
     * @param $errorDescription description for the provided code
     */
    public function setError($errorCode, $errorDescription) {
        $this->_data = array(
            "errorCode" => $errorCode,
            "errorDescription" => $errorDescription,
        );
        $this->_success = false;
    }

    public function setFailure($data) {
        $this->_data = $data;
        $this->_success = false;
    }


    /**
     * Outputs json object. Will output even if no values have been set.
     */
    public function output($utf8 = false){
        header('Content-Type: application/json');
        $options = 0;
        if($utf8) $options = JSON_UNESCAPED_UNICODE;
        if($this->_success === true) {
            echo json_encode(array(
                "success" => $this->_success,
                "data" => $this->_data,
            ), $options);
        } else if($this->_success === false){
            echo json_encode(array(
                "success" => $this->_success,
                "error" => $this->_data
            ), $options);
        } else {
            echo json_encode( array(
                "success" => false,
                "error" => array(
                    "errorCode" => 404,
                    "errorDescription" => t("noValueSet"),
                )
            ), $options);
        }
    }
}