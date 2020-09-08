<?php
/*
 * Autoloader function
 * Include files from this DIR only with needle namespaces
 *
 */
namespace Core;

(function(){
  spl_autoload_register( __NAMESPACE__ . '\\autoload');
  
  function autoload( $class ) {
    try {
      $class = ltrim( $class, '\\');
    
      if( strpos( $class, __NAMESPACE__ ) !== false ) {
        return false;
      }
      
      set_include_path( __DIR__ );
      spl_autoload_extensions('.class.php');
      spl_autoload($class);
    }
    
  }
});
