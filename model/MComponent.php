<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 12.3.2015.
 * Time: 0:26
 */

class MComponent {
    public $id;
    public $name;
    public $template;
    public $width;
    public $height;
    public $description;

    /**
     * Save model to the database.
     */
    public function save(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("INSERT INTO component(name, template, width, height, description) VALUES(?,?,?,?,?)");
        $sql->execute(
            array(
                $this->name,
                json_encode($this->template),
                $this->width,
                $this->height,
                $this->description,
            )
        );

        $this->id = $db->lastInsertId();
    }

    /**
     * Update model representation in database.
     */
    public function update(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("
            UPDATE component
            SET name = ?, template = ?, width = ?, height = ?, description = ?
            WHERE id = ?
        ");
        $sql->execute(
            array(
                $this->name,
                json_encode($this->template),
                $this->width,
                $this->height,
                $this->description,
                $this->id
            )
        );
    }

    /**
     * Delete model from the database.
     */
    public function delete(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("DELETE FROM component WHERE id = ?");
        $sql->execute(array($this->id));
    }

    /**
     * Retrieve single model from database.
     * @param $id model identificator
     * @return MComponent|null model, if exists, otherwise null
     */
    public static function get($id) {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM component WHERE id = ?");
        $sql->execute(array($id));
        if($obj = $sql->fetch(PDO::FETCH_OBJ)) {
            $component = new MComponent();
            return $component->fillFromDBObject($obj);
        }
        return null;
    }

    /**
     * Retrieve all models from database.
     * @return array of components
     */
    public static function getComponents() {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM component");
        $sql->execute();
        $data = array();
        $helpObj = new MComponent();
        foreach($sql->fetchAll(PDO::FETCH_OBJ) as $component) {
            $data[] = $helpObj->fillFromDBObject($component);
        }
        return $data;
    }

    /**
     * Number of components.
     * @return int
     */
    public static function total(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT COUNT(*) as total FROM component");
        $sql->execute();
        return intval($sql->fetch(PDO::FETCH_OBJ)->total);
    }

    /**
     * Helper function. Creates and populates new component with provided data.
     * @param $object
     * @return MComponent
     */
    private function fillFromDBObject($object) {
        $component = new MComponent();
        $component->id = $object->id;
        $component->name = $object->name;
        $component->template = json_decode($object->template);
        $component->width = $object->width;
        $component->height = $object->height;
        $component->description = $object->description;
        return $component;
    }

    /**
     * Validate provided parameteres received from component editor.
     * @param $params
     * @return mixed
     */
    public static function validate($params) {
        $valid = true;
        if(!empty($params->data->name->value)) {
            $params->data->name->error = "";
        } else {
            $params->data->name->error = t("noComponentName");
            $valid = false;
        }

        if($valid) {
            $db = MDBConnection::getConnection();
            $sql = $db->prepare("SELECT * FROM component WHERE name = ?");
            $sql->execute(array($params->data->name->value));
            if($result = $sql->fetch(PDO::FETCH_OBJ)) {
                if($result->id != $params->data->id) {
                    $params->data->name->error = t("componentNameAlreadyExists");
                    $valid = false;
                }
            }
        }

        $width = intval($params->data->dimensions->width);
        $height = intval($params->data->dimensions->height);

        if($width > 0 && $width <= 12 && $height > 0 && $height <= 12) {
            $params->data->dimensions->error = "";
        } else {
            $params->data->dimensions->error = t("invalidDimensions");
            $valid = false;
        }

        if($valid) {
            $params->data->hasError = false;
        } else {
            $params->data->hasError = true;
        }

        $params->data->template = MTemplate::validate($params->data->template);
        $params->data->hasError = $params->data->hasError || $params->data->template->hasError;
        unset($params->data->template->hasError);

        return $params;
    }
}