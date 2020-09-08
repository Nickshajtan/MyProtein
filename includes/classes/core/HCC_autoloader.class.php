<?php
/*
 * Core classes autoloader
 * HCC
 *
 */
namespace Core;

class HCC_autoloader {
  public static $loader;
  
  public static function init()
     {
         if(self::$loader == NULL) {
             self::$loader = new self();
         }
         return self::$loader;
     }
 
     public function __construct()
     { 
         spl_autoload_register(array($this, 'helpers'));
         spl_autoload_register(array($this, 'modules'));
         spl_autoload_register(array($this, 'libs'));
     }
 
     public function libs($class){
         set_include_path(CORE_CLASSES_DIR . '/libs');
         spl_autoload_extensions('.class.php');
         spl_autoload($class);
     }
 
     public function helpers($class){
         set_include_path(CORE_CLASSES_DIR .'/helpers');
         spl_autoload_extensions('.class.php');
         spl_autoload($class);
     }
 
     public function modules($class){ 
         set_include_path(CORE_CLASSES_DIR .'/modules');
         spl_autoload_extensions('.class.php');
         spl_autoload($class);
     }
}
