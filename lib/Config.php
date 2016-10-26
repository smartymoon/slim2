<?php
namespace Lib;
class Config {
       static public $config;

       public static function init(){
           self::$config =  require './config.php';
       }

        public static function all(){
            return self::$config;
        }

       public static function set($name,$value = '')
       {
           if($name == null){
              //throw exception
           }
           $args = explode('.',$name);
           self::setFromDotFomat(self::$config,$args,$value);
       }

       public static function get($name = null,$default = null)
       {
           if ($name == null)
           {
               return self::all();
           }
           $args   = explode('.',$name);
           $configs = self::$config;
           return self::getFromDotFomat($configs,$args,$default);
       }

       public static function destroy($args)
       {
           if($args == null)
           {
               //throw exception
           }
           $args = explode('.',$args);
           $configs = self::$config;
           $config = self::destroyFromDotFomat($configs,$args);

           array_pop($args);
           self::set(implode('.',$args),$config);
       }

       public static function clear($args)
       {
            self::set($args,null);
       }

       private static function  getFromDotFomat($config,$args,$default)
       {
             $arg = array_shift($args);
             if($arg == null){
                 return $config;
             }else{
                 if(isset($config[$arg]))
                 {
                     return self::getFromDotFomat($config[$arg],$args,$default);
                 }else{
                     return $default;
                 }
             }
       }

       private static function  setFromDotFomat(&$configs,$args,$value)
       {
           $arg = array_shift($args);
           if(empty($args))
           {
               if(empty($arg)){
                   $configs   = $value;
                   return;
               }
               $configs[$arg] = $value;
               return;
           }

           if(!isset($configs[$arg] )|| is_string($configs[$arg]))
           {
               $configs[$arg] = array();
           }

           self::setFromDotFomat($configs[$arg],$args,$value);
       }

       private static function  destroyFromDotFomat(&$configs,$args)
       {
           $arg = array_shift($args);
           if(empty($args))
           {
               unset($configs[$arg]);
               return $configs;
           }

           if(!isset($configs[$arg] ) || is_string($configs[$arg]))
           {
               return;
           }

           return self::destroyFromDotFomat($configs[$arg],$args);
       }

}