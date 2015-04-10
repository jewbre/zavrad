<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 1.3.2015.
 * Time: 19:17
 */

class MDBConnection {

    /**
     * Connection to the database. Created using constants for DNS.
     * @return PDO
     */
    public static function getConnection(){
        return new PDO("mysql:hostname=" . HOSTNAME . ";dbname=" . DBNAME . ";charset=utf8;", DB_USERNAME , DB_PASSWORD );
    }

}