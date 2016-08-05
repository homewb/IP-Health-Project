<?php
/* 
 * create by gongzheng
 */

class conf{
    
    protected static $ins = null;
    protected $cfg = array();
    public static function getIns(){
        if(self::$ins == null){
            self::$ins = new self();
        }
        return self::$ins;
    }
    
    final protected function __construct() {
        require(ROOT.'data/config.php');
        $this->cfg = $cfg;
    }
    //megic fouction
    
    public function __get($key) {
        if(!isset($this->cfg[$key])){
            return null;
        }
        return $this->cfg[$key];
    }
    
    public function __set($key, $value) {
        $this->cfg[$key]=$value;
    }    
       
}
