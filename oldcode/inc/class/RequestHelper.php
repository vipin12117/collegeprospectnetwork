<?php

class RequestHelper
{
    public static function getVar($name, $default = NULL, $source = 'REQUEST')
    {
        switch ($source) {
            case 'GET':
                $super = &$_GET;
                break;
            
            case 'POST':
                $super = &$_POST;
                break;
            
            case 'SESSION':
                $super = &$_SESSION;
                break;
            
            case 'REQUEST':
            default:
                $super = &$_REQUEST;
                break;
        }
        
        $var = $default;
        
        if (isset($super[$name]) && $super[$name] != NULL) {
            $var = $super[$name];
        }
        
        return self::clean($var);
    }
    
    protected function clean($var)
    {
        return $var;
    }
}

