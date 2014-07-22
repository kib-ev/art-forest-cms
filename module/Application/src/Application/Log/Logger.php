<?php

namespace Application\Log;

class Logger
{
    public static function __callStatic($method, $args)
    {
        $logger = new \Zend\Log\Logger();
        $filename = 'log_' . date('d-F-Y') . '.txt';
        $writer = new \Zend\Log\Writer\Stream('data/logs/' . $filename);
        $logger->addWriter($writer);
        return $logger->$method($args[0]);
    }

}