<?php

namespace Stadline\DemoBundle\Service;

class SplitFile
{
    private $producer;
 
    public function __construct(\OldSound\RabbitMqBundle\RabbitMq\Producer $producer)
    {
        $this->producer = $producer;
    }
 
    public function process($path)
    {
        $xmlReader = new \XMLReader();
        $xmlReader->open($path);
        $itemCounter = 0;
 
        while ($xmlReader->read()) {
            if ((\XMLReader::ELEMENT === $xmlReader->nodeType) && ($xmlReader->name === 'item')) {
                $xml = '<?xml version="1.0"?>';
                $xml .= '<item>';
                $xml .= $xmlReader->readInnerXML();
                $xml .= '</item>';
 
//                $this->producer->publish($xml);
                $this->producer->publish($xml, 'queue.'.$itemCounter%2);
                $itemCounter++; 
            }
        }
 
        $xmlReader->close();
    }
}