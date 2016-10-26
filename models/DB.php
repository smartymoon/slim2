<?php
namespace models;
class DB {
    protected static $_instance;
    public $DB;

    //单例模式 不允许在类外对类进行实例化
    private function __construct(){
       $this->DB = new \medoo(\lib\Config::get('database'));
    }

    //获得类的实例
    public static function getSingleton(){
        //判断我们类的实例是否存在，没有则创建之
        if(!isset(self::$_instance)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}