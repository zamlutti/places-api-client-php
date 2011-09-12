<?php

function __autoload($class_name)
{
    include_once('../src/client/' . $class_name . '.php');
}

spl_autoload_register('__autoload');