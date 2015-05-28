<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 16.3.2015.
 * Time: 8:43
 */

class MTemplate {

    const TYPE_BACKGROUND_COLOR = "backgroundColor";
    const TYPE_TEXT_COLOR = "textColor";
    const TYPE_MENU_ITEMS = "menuItems";
    const TYPE_SLIDER = "sliderImages";

    public $id;
    public $name;
    public $defaultOptions;

    /**
     * Save model into the database.
     */
    public function save(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("INSERT INTO template(name, defaultOptions) VALUES(?,?)");
        $sql->execute(array(
           $this->name, json_encode($this->defaultOptions)
        ));
    }

    /**
     * Update existing model in the database.
     */
    public function update(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("UPDATE template SET name = ?, defaultOptions = ? WHERE id = ?");
        $sql->execute(array(
            $this->name, json_encode($this->defaultOptions), $this->id
        ));
    }

    /**
     * Delete model from the database.
     */
    public function delete(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("DELETE FROM template WHERE id = ?");
        $sql->execute(array($this->id));
    }

    /**
     * Retrieve single model from database. If model does not exists, return null;
     * @param $id
     * @return MTemplate|null
     */
    public static function get($id) {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM template WHERE id = ?");
        $sql->execute(array($id));
        $tmp = new MTemplate();
        if($result = $sql->fetch(PDO::FETCH_OBJ)) {
            return $tmp->fillObjectFromDBData($result);
        }
        return null;
    }

    /**
     * Retrieve all models from database.
     * @return array
     */
    public static function getAll() {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM template");
        $sql->execute();
        $data = array();
        $tmp = new MTemplate();
        if($results = $sql->fetchAll(PDO::FETCH_OBJ)) {
            foreach($results as $result) {
                $data[] = $tmp->fillObjectFromDBData($result);
            }
        }
        return $data;
    }

    /**
     * Validate provided data. Each option inside of the data has its type and each type is validated.
     * @param $data
     * @return mixed
     */
    public static function validate($data) {
        $valid = true;
        if(empty($data)) {
            $data->hasError = false;
            return $data;
        }
        foreach($data as $k => $option) {
            if($k == "name") continue;
            switch($option->type) {
                case MTemplate::TYPE_BACKGROUND_COLOR :
                    if(empty($option->value)) {
                        $option->error = t("emptyBackgroundColorValue");
                        $valid = false;
                    } else if(!preg_match("/^#[0-9a-f]{3,6}$/",$option->value)) {
                        $option->error = t("invalidColorValue");
                        $valid = false;
                    } else {
                        $option->error = "";
                    }
                    break;
                case MTemplate::TYPE_TEXT_COLOR :
                    if(empty($option->value)) {
                        $option->error = t("emptyTextColorValue");
                        $valid = false;
                    } else if(!preg_match("/^#[0-9a-f]{3,6}$/",$option->value)) {
                        $option->error = t("invalidColorValue");
                        $valid = false;
                    } else {
                        $option->error = "";
                    }
                    break;
                case MTemplate::TYPE_MENU_ITEMS :
                    if(empty($option->items)) {
                        $option->error = t("emptyMenu");
                        $valid = false;
                        break;
                    } else {
                        $option->error = "";
                    }
                    foreach($option->items as $k => $item) {
                        if(empty($item->value)) {
                            $item->error = t("noMenuItemValue");
                            $valid = false;
                        } else if($item->url == "") {
                            $item->error = t("invalidUrl");
                            $valid = false;
                        } else {
                            $item->error = "";
                        }
                    }
                    break;
            }
        }
        $data->hasError = !$valid;

        return $data;
    }

    /**
     * Helper function. Create and populate new model with provided data.
     * @param $data
     * @return MTemplate
     */
    private function fillObjectFromDBData($data){
        $template = new MTemplate();
        $template->id = $data->id;
        $template->name = t($data->name);
        $template->defaultOptions = json_decode($data->defaultOptions);
        foreach($template->defaultOptions as $key => $option) {
            if($key == "name") continue;
            if(empty($option->name)) {
                foreach($option as $o) {
                    $o->name = t($o->name);
                }
            } else {
                $option->name = t($option->name);
            }
        }
        return $template;
    }
}