<?php  

namespace App;

class Logger{
    public function log($msg){
        dump("Call-Method::MSG : $msg");
    }
}
?>