<?php
/* 
 * create by gongzheng
 */

class mysql{
    protected static $ins = null;
    protected $host;
    protected $username;
    protected $password;
    protected $port;
    protected $database;
    protected $charset;
    protected $conn= null;
    public static function getIns(){
        if(self::$ins==null){
            self::$ins = new self();
        }
        $config = conf::getIns();
        self::$ins->host = $config->host;
        self::$ins->username = $config->username;
        self::$ins->password = $config->password;
        self::$ins->port = $config->port;
        self::$ins->database = $config->database;
        self::$ins->charset = $config->charset;
        self::$ins->connect();
        self::$ins->select_db();


        //--------------Set Up StrongLoop IP address-----------------     
        self::$ins->hostStrongLoopIp = $config->hostStrongLoopIp;  
        return self::$ins;
    }

    final protected function __construct() {
        
    }
    
    public function connect() {
        $this->conn = mysql_connect($this->host,$this->username,$this->password,$this->port);
    }
    
    public function query($sql) {
        $rs = mysql_query($sql,$this->conn);
        return $rs;
    }
    
    public function setChar() {
        $sql = 'set names '.$this->charset;
        return $this->query($sql);
    }
    
    public function select_db() {
        $sql = 'use ' . $this->database;
        return $this->query($sql);
    }
    
     public function getAll($sql) {
        $rs = $this->query($sql);
        if(!$rs) {
            return false;
        }

        $list = array();
        while($row = mysql_fetch_assoc($rs)) {
            $list[] = $row;
        }
        
        return $list;       
    }
    
    public function getRow($sql) {
        $rs = $this->query($sql);
        if(!$rs) {
            return false;
        }

        return mysql_fetch_assoc($rs);
    }
    
    public function getOne($sql) {
        $rs = $this->query($sql);
        if(!$rs) {
            return false;
        }

        $tmp = mysql_fetch_row($rs);
        return $tmp[0];
    }
    
    
    
    
}