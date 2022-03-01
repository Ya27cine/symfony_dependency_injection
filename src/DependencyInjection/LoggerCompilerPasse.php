<?php 

namespace App\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class LoggerCompilerPasse implements CompilerPassInterface{
    public function process(ContainerBuilder $container)
    {
        $defs = $container->getDefinitions();
        //var_dump($defs);
        foreach($defs as $id => $def){
            if( $id === 'texter.sms' || $id === 'mailer.gmail'){
                $def->addMethodCall('setLogger', [ new Reference('logger')]);
            }
        }
    }
}
?>