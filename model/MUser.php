<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 7.3.2015.
 * Time: 20:12
 */

class MUser {

    const AUTH_GUEST = 1;
    const AUTH_USER = 2;
    const AUTH_MODERATOR = 3;
    const AUTH_ADMIN = 4;
    const AUTH_SUPERADMIN = 5;

    public $_id;
    public $_email;
    public $_password;
    public $_salt;
    public $_authority;


    /**
     * Creates a new user model. If provided salt, password will be crypted with new guid, otherwise both salt and password are set to the user.
     * If new user, always provide pure text password and leave the salt as null.
     *
     * @param $email
     * @param $password
     * @param null $salt
     */
    public function MUser($email, $password, $salt = null) {
        $this->_salt = $salt == null ? uniqid() : $salt;
        $this->_password = $salt == null ? crypt($this->_salt . $email . $password, "$6$" . $this->_salt) : $password;
        $this->_email = $email;
        $this->_authority = MUser::AUTH_USER;
    }

    /**
     * Saves a user to the database. Return success of the operation.
     * @return bool success of the operation
     */
    public function save() {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("INSERT INTO user(email, password, salt, authority) VALUES (?,?,?,?)");
        $result = $sql->execute(array(
            $this->_email, $this->_password, $this->_salt, $this->_authority
        ));
        if($result) {
            $this->_id = $db->lastInsertId();
        }
        return $result;
    }

    /**
     * Change the password of the user with changing of the user guid.
     * @param $password new password to be set to
     */
    public function changePassword($password){
        $this->_salt = uniqid();
        $this->_password = crypt("$6$" . $this->_salt . $this->_email . $password);
    }

    /**
     * Update current user and the changes made to it.
     * @return bool success of the operation
     */
    public function update() {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("UPDATE user SET password = ?, salt = ?, authority = ? WHERE id = ?");
        return $sql->execute(array(
            $this->_password, $this->_salt, $this->_authority, $this->_id
        ));
    }

    /**
     * Give user different authority
     * @param $authority
     */
    public function changeAuthority($authority) {
        $this->_authority = $authority;
    }

    /**
     * Retrieves user from the database for provided identificator. Identificator can be user id number or user email.
     * If user exists, returns MUser object, otherwise null.
     * If invalid type of identificator provided, throws InvalidIdentificator exception.
     *
     * @param $id user id number or user email
     * @return MUser|null
     * @throws InvalidIdentificator
     */
    public static function get($id) {
        $db = MDBConnection::getConnection();
        if(is_string($id) && !intval($id)) {
            $sql = $db->prepare("SELECT * FROM user WHERE email = ?");
        } else if(intval($id)){
            $sql = $db->prepare("SELECT * FROM user WHERE id = ?");
        } else {
            throw new InvalidIdentificator("Fetching user for invalid identificator type: " . $id);
        }
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $results = $sql->execute(array($id));
        if($results && $result = $sql->fetch()) {
            $user = new MUser($result->email, $result->password, $result->salt);
            $user->_id = $result->id;
            $user->_authority = $result->authority;
            return $user;
        }
        return null;
    }


    /**
     * Get user authority.
     * @return int
     */
    public function getAuthority(){
        return $this->_authority;
    }

    /**
     * Get user email.
     * @return mixed
     */
    public function getEmail(){
        return $this->_email;
    }

    /**
     * Get user id.
     * @return mixed
     */
    public function getId(){
        return $this->_id;
    }

    /**
     * Checks if provided email address has not already been used.
     * @param $email
     * @return bool
     */
    public static function checkUniqueEmail($email){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM user WHERE email = ?");
        $sql->execute(array($email));
        if($sql->fetch(PDO::FETCH_OBJ)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     *
     * @param $password
     * @return bool
     */
    public function checkPassword($password){
        return $this->_password == crypt($this->_salt . $this->_email . $password, "$6$" . $this->_salt);
    }

    public static function validateUser($email, $password) {
        $user = MUser::get($email);
        if($user == null) return false;
        return $user->checkPassword($password);
    }
}