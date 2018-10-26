<?php
/*
 * Author: Xu Ding
 * website: www.startutorial.com
 *          www.the-di-lab.com
 */
class Polygon
{
    static $_dbHost     = 'localhost'; 
    static $_dbName     = 'polygon_drawer';   
    static $_dbUserName = 'root';  
    static $_dbUserPwd  = '';
     
    // get coordinates
    static public function getCoords()
    {
        return self::get();
    }
     
    // save coordinates
    static public function saveCoords($rawData)
    {
        self::save($rawData);
    }
     
    // save lat/lng to database
    static public function save ($data)
    {
        $con = mysqli_connect(self::$_dbHost, self::$_dbUserName, self::$_dbUserPwd);
         
        // connect to database
        if (!$con) {
            die('Could not connect: ' . mysqli_error());
        }
         
        mysqli_select_db($con,self::$_dbName);
         
        // delete old data
        mysqli_query("DELETE FROM public");
         
        // insert data
        mysqli_query("INSERT INTO public (data) VALUES ($data)");
         
        // close connection
        mysqli_close($con);
    }  
     
    // get lat/lng from database
    static private function get()
    {  
        $con = mysqli_connect(self::$_dbHost, self::$_dbUserName, self::$_dbUserPwd);
         
        // connect to database
        if (!$con) {
            die('Could not connect: ' . mysqli_error());
        }
         
        mysqli_select_db(self::$_dbName, $con);
         
        $result = mysqli_query("SELECT * FROM public");
                 
        $data   = false;
         
        while($row = mysqli_fetch_array($result))
        {
            $data = $row['data'];
        }
         
        // close connection
        mysqli_close($con);     
         
        return $data;
    }
     
}