<?php

function __autoload($class_name) 
{
  include '../src/client/'.$class_name.'.php';
}

spl_autoload_register('__autoload');