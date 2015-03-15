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

    public function save(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("INSERT INTO component(name, template, width, height, description) VALUES(?,?,?,?,?)");
        $sql->execute(
            array(
                $this->name,
                $this->template,
                $this->width,
                $this->height,
                $this->description,
            )
        );

        $this->id = $db->lastInsertId();
    }

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
                $this->template,
                $this->width,
                $this->height,
                $this->description,
                $this->id
            )
        );
    }

    public function delete(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("DELETE FROM component WHERE id = ?");
        $sql->execute(array($this->id));
    }

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

    public static function total(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT COUNT(*) as total FROM component");
        $sql->execute();
        return $sql->fetch(PDO::FETCH_OBJ)->total;
    }
    private function fillFromDBObject($object) {
        $component = new MComponent();
        $component->id = $object->id;
        $component->name = $object->name;
        $component->template = $object->template;
        $component->width = $object->width;
        $component->height = $object->height;
        $component->description = $object->description;
        return $component;
    }

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
            if($sql->fetch()) {
                $params->data->name->error = t("componentNameAlreadyExists");
                $valid = false;
            }
        }

        if(!empty($params->data->template->value)) {
            $params->data->template->error = "";
        } else {
            $params->data->template->error = t("noComponentTemplate");
            $valid = false;
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


        return $params;
    }
}