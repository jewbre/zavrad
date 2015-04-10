<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 8.4.2015.
 * Time: 23:52
 */

class MImage {

    public $id;
    public $width;
    public $height;
    public $parent;
    public $priority = 10;
    public $status;
    public $url;

    public static function get($id, $width = null, $height = null) {
        $db = MDBConnection::getConnection();
        if(empty($width) || empty($height)) {
            $sql = $db->prepare("SELECT * FROM image WHERE id = ?");
            $sql->execute(array($id));
            if($result = $sql->fetch(PDO::FETCH_OBJ)) {
                return MImage::fillFromDBData($result);
            }
            return null;
        } else {
            $sql = $db->prepare("SELECT * FROM image WHERE parent = ? AND width = ? AND height = ?");
            $sql->execute(array($id, $width, $height));
            if($result = $sql->fetch(PDO::FETCH_OBJ)) {
                return MImage::fillFromDBData($result);
            } else {
                return MImage::get($id);
            }
        }
    }

    public static function getImages($page = 1, $number = 20) {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM image WHERE parent IS NULL AND status = :status ORDER BY id DESC LIMIT :offset, :per_page");
        $sql->bindValue(":offset",($page-1)*$number,PDO::PARAM_INT);
        $sql->bindValue(":per_page",$number,PDO::PARAM_INT);
        $sql->bindValue(":status",MStatus::AVAILABLE,PDO::PARAM_INT);
        $sql->execute();
        if($results = $sql->fetchAll(PDO::FETCH_OBJ)) {
            $data = array();
            foreach($results as $result) {
                $data[] = MImage::fillFromDBData($result);
            }
            return $data;
        }
        return null;
    }

    public function save(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("INSERT INTO image(width,height,parent,priority,status,url) VALUES(?,?,?,?,?,?)");
        $result = $sql->execute(array($this->width, $this->height, $this->parent, $this->priority, $this->status, $this->url));
        $this->id = $db->lastInsertId();
        return $result;
    }

    public function update(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("UPDATE image SET priority = ?, status = ? WHERE id = ?");
        return $sql->execute(array($this->priority, $this->status, $this->id));
    }

    public function delete(){
        $this->status = MStatus::DELETED;
        return $this->update();
    }

    public static function handleFileUpload($fileName = "file") {
        $allowedExtentions = array("jpg","jpeg","png","gif");
        $allowedTypes = array("image/jpg","image/jpeg","image/png","image/gif");
        $maxFileSize = 5000000000;
        if((!empty($_FILES[$fileName])) && ($_FILES[$fileName]['error'] == 0)) {
            $filename = basename($_FILES[$fileName]['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            if (in_array($ext, $allowedExtentions) && in_array($_FILES[$fileName]["type"],$allowedTypes) &&
                ($_FILES[$fileName]["size"] < $maxFileSize)) {
                //Determine the path to which we want to save this file
                $name = hash("md5",$filename.time()) . "." . $ext;
                $newname = 'images/upload/' . $name;
                //Check if the file with the same name is already exists on the server
                if (!file_exists($newname)) {
                    //Attempt to move the uploaded file to it's new place
                    if ((move_uploaded_file($_FILES[$fileName]['tmp_name'],$newname))) {
                        $image = new MImage();
                        $dimensions = getimagesize($newname);
                        $image->width = $dimensions[0];
                        $image->height = $dimensions[1];
                        $image->status = MStatus::AVAILABLE;
                        $image->url = $newname;
                        $image->save();
                        $image->resizeImages($name);
                        return $image;
                    } else {
                        echo "Error: A problem occurred during file upload!";
                    }
                } else {
                    echo "Error: File ".$_FILES[$fileName]["name"]." already exists";
                }
            } else {
                echo "Error: Only .jpg images under 350Kb are accepted for upload";
            }
        } else {
            echo "Error: No file uploaded";
        }
        return null;
    }

    public function resizeImages($name) {
        $ext = substr($name, strrpos($name, '.') + 1);
        $dimensions = array(array("width" => 400, "height" => 300),array("width" => 300, "height" => 400));
        switch($ext) {
            case "png":
                $original = imagecreatefrompng("./" . $this->url);
                break;
            case "gif":
                $original = imagecreatefromgif("./" . $this->url);
                break;
            case "jpeg":
            case "jpg":
            default:
                $original = imagecreatefromjpeg("./" . $this->url);
        }

        $ratio = $this->width / $this->height;
        foreach($dimensions as $dimension) {

            $ratio_second = $dimension["width"] / $dimension["height"];
            if($ratio_second >= $ratio) {
                $w = $this->width;
                $h = round($w / $ratio_second);
            } else {
                $h = $this->height;
                $w = round($h * $ratio_second);
            }
            $newImage = imagecreatetruecolor($dimension["width"],$dimension["height"]);
            imagefill($newImage,0,0,0x7f000000);
            imagecopyresized($newImage,$original,0,0,0,0,$dimension["width"],$dimension["height"],$w,$h);

            $fileName = "images/upload/" . $dimension["width"] . "x" . $dimension["height"] . "_" . $name;

            switch($ext) {
                case "png":
                    imagealphablending($newImage, false);
                    imagesavealpha($newImage, true);
                    imagepng($newImage, $fileName);
                    break;
                case "gif":
                    imagegif($newImage, $fileName);
                    break;
                case "jpeg":
                case "jpg":
                default:
                    imagejpeg($newImage, $fileName);
            }

            imagedestroy($newImage);

            $image = new MImage();
            $image->width = $dimension["width"];
            $image->height = $dimension["height"];
            $image->parent = $this->id;
            $image->url = $fileName;
            $image->status = MStatus::AVAILABLE;
            $image->save();

        }
    }


    private static function fillFromDBData($data) {
        $image = new MImage();
        $image->id = $data->id;
        $image->width = $data->width;
        $image->height = $data->height;
        $image->parent = $data->parent;
        $image->priority = $data->priority;
        $image->status = $data->status;
        $image->url = $data->url;
        return $image;
    }
}