<?php


class Db
{
    static function getDbConnection(): ?PDO
    {
        try {
            $dsn = 'mysql:dbname=author_project;host=127.0.0.1';
//            $dbname= 'author_project';
            $user = 'root';
            $pass = '';
            return new PDO($dsn,$user, $pass);
        } catch (PDOException $e) {
            throw new Exception("Connection error: ", $e->getMessage());
        }
    }
}


// check if the database is connected
//$test = Db::getDbConnection();
//
//if($test !== null){
//    echo "Connected";
//}else{
//    echo "Not Connected";
//}