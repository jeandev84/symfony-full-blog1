<?php
namespace DesignPatterns\Containers;


/**
 * Class Singleton
 * @package DesignPatterns\Containers
*/
class Singleton
{
     /**
      * @var array
     */
     private static $instances = [];


     /**
      * @return mixed
     */
     public function instance(): Singleton
     {
         $class = static::class;

         if(! isset(self::$instances[$class]))
         {
             self::$instances[$class] = new static();
         }

         return self::$instances[$class];
     }
}