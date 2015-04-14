<?php 

namespace Stadline\DemoBundle\Command;

use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use XMLWriter;
 
class CreateFileCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('reader:create-file')
                ->addArgument(
                'number',
                InputArgument::REQUIRED,
                'PathFile?'
            );
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $faker = Factory::create();
        
        $number = $input->getArgument('number');
        
        $xmlWriter = new XMLWriter();
        $xmlWriter->openUri('/home/fabien/workspace/rabbit/web/'.$number.'_test.xml');

        $xmlWriter->startDocument("1.0");
        $xmlWriter->startElement('items');
        
        for($i = 0; $i <= $number; $i++) {
            $xmlWriter->startElement('item');
            
                $xmlWriter->startElement('title');
                    $xmlWriter->text($faker->name);
                $xmlWriter->endElement(); //Finish item
                
                $xmlWriter->startElement('email');
                    $xmlWriter->text($faker->email);
                $xmlWriter->endElement(); //Finish item
                
            $xmlWriter->endElement(); //Finish item
        }
        
        $xmlWriter->endElement(); //Finish items
        $xmlWriter->endDocument();

    }
}

/*
<items>
  <item>
    <title>First Blood</title>
    <email>john.doe@example.com</email>
  </item>
</items>
*/
