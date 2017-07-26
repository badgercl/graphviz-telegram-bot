<?php
class DbConfig{
        public static function getConnection(){
                $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name, 8889);
                $mysqli->set_charset("utf8mb4"); 
                return $mysqli;
        }
        public static function sql($db, $sql){
          $result = $db->query($sql);
          if(!$result) die($db->error);
          $res = array();
          while ($row = $result->fetch_assoc()) {
                  $res[] = $row;
          }
          return $res;
        }
        public static function update($db, $sql){
          return $db->query($sql);
        }
}
