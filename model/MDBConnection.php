<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 1.3.2015.
 * Time: 19:17
 */

class MDBConnection {

    public static function getConnection(){
        return new PDO("mysql:hostname=" . HOSTNAME . ";dbname=" . DBNAME . ";", DB_USERNAME , DB_PASSWORD );
    }

}