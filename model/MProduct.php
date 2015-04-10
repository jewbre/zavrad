<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 6.4.2015.
 * Time: 20:44
 */

class MProduct {

    public $id;
    public $code;
    public $name;
    public $description;
    public $excerpt;
    public $status;

    public static function get($id) {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM product WHERE id = ? AND NOT status = ?");
        $sql->execute(array($id, MStatus::DELETED));
        if($result = $sql->fetch(PDO::FETCH_OBJ)){
            return MProduct::fillFromDBData($result);
        }
        return null;
    }

    public static function getAll($allData = false, $page = 1, $per_page = 10) {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM product WHERE NOT status = ?");
        $sql->execute(array(MStatus::DELETED));
        if($results = $sql->fetchAll(PDO::FETCH_OBJ)){
            $data = array();
            foreach($results as $result){
                $product = MProduct::fillFromDBData($result);
                if($allData) {
                    $product->categories = $product->getCategories();
                    $product->images = $product->getImages();
                    $product->price = $product->getPrice();
                }
                $data[] = $product;
            }
            return $data;
        }
        return null;
    }

    public function save(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("INSERT INTO product(code, name, description, excerpt, status) VALUES(?,?,?,?,?)");
        $result = $sql->execute(array($this->code, $this->name, $this->description, $this->excerpt, $this->status));
        $this->id = $db->lastInsertId();
        return $result;
    }

    public function update(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("UPDATE product SET code = ?, name = ?, description = ?, excerpt = ?, status = ? WHERE id = ?");
        return $sql->execute(array($this->code, $this->name, $this->description, $this->excerpt, $this->status, $this->id));
    }

    public function delete(){
        $this->status = MStatus::DELETED;
        return $this->update();
    }

    public function getCategories(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM product_category WHERE product_id = ?");
        $sql->execute(array($this->id));
        if($results = $sql->fetchAll(PDO::FETCH_OBJ)) {
            $data = array();
            foreach($results as $result){
                $data[] = MCategory::get($result->category_id);
            }
            return $data;
        }
        return array();
    }

    public function getImages(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM product_image WHERE product_id = ?");
        $sql->execute(array($this->id));
        if($results = $sql->fetchAll(PDO::FETCH_OBJ)) {
            $data = array();
            foreach($results as $result){
                $data[] = MImage::get($result->image_id);
            }
            return $data;
        }
        return array();
    }

    public function getPrice(){
        return MPrice::get($this->id);
    }

    public function addCategories($categories) {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("DELETE FROM product_category WHERE product_id = ?");
        $sql->execute(array($this->id));
        $sql = $db->prepare("INSERT INTO product_category(product_id, category_id) VALUES(?,?)");
        foreach($categories as $category) {
            $sql->execute(array($this->id, $category));
        }
    }

    public function addImages($images) {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("DELETE FROM product_image WHERE product_id = ?");
        $sql->execute(array($this->id));
        $sql = $db->prepare("INSERT INTO product_image(product_id, image_id) VALUES(?,?)");
        foreach($images as $image) {
            $sql->execute(array($this->id, $image->id));
        }
    }

    public function addPrice($amount, $currency) {
        $price = new MPrice();
        $price->price = $amount;
        $price->currency = $currency;
        $price->product = $this->id;
        $price->save();
    }

    public static function search($args){
        if(empty($args)) return MProduct::getAll();

        $count = 0;
        $where = "";
        $include = array();
        foreach($args as $key => $value) {
            $includable = true;
            if($count > 0) $where .= " AND";
            switch($key) {
                case "name" :
                    $where .= " name LIKE ?";
                    break;
                case "code" :
                    $where .= " code LIKE ?";
                    break;
                case "status":
                    $where .= " status = ?";
                    break;
                case "category":
                    $includable = false;
                    if(is_array($value)) {
                        $tmp = array();
                        foreach($value as $v) {
                            $tmp[] = intval($v);
                        }
                        $in = implode(",", $tmp);
                    } else {
                        $tmp = array();
                        $tmp[] = intval($value);
                        $in = implode(",", $tmp);
                    }
                    $where .= " id IN(SELECT product_id FROM product_category WHERE category_id IN (" . $in . ")";
                default : throw new InvalidArgument("Invalid argument supplied: " . $key);
            }
            if($includable) {
                $include[] = $key;
            }
            $count++;
        }

        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM product WHERE " . $where);

        if(!empty($include)) {
            for ($i = 1; $i <= $count; $i++) {
                $sql->bindParam($i, $args[$include[$i]]);
            }
        }

        $sql->execute();
        if($results = $sql->fetchAll(PDO::FETCH_OBJ)){
            $data = array();
            foreach($results as $result){
                $data[] = MProduct::fillFromDBData($result);
            }
            return $data;
        }
        return null;
    }

    public static function nameExists($name, $id = null) {
        $db = MDBConnection::getConnection();
        if($id == null) {
            $sql = $db->prepare("SELECT * FROM product WHERE name = ?");
            $sql->execute(array($name));
        } else {
            $sql = $db->prepare("SELECT * FROM product WHERE name = ? AND NOT id = ?");
            $sql->execute(array($name, $id));
        }
        if($sql->fetch(PDO::FETCH_OBJ)) {
            return true;
        } else {
            return false;
        }
    }


    public static function fillFromDBData($data){
        $product = new MProduct();
        $product->id = $data->id;
        $product->code = $data->code;
        $product->name = $data->name;
        $product->description = $data->description;
        $product->excerpt = $data->excerpt;
        $product->status = $data->status;
        return $product;
    }
}