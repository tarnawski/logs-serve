<?php

namespace LogsServeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition;
use Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('logs_serve');


        $rootNode
                ->children()
                    ->arrayNode('logs')
                        ->useAttributeAsKey('log')
                            ->normalizeKeys(false)
                            ->prototype('array')
                            ->append($this->getPath())
                            ->append($this->getLines())
                        ->end()
                    ->end()
                ->append($this->getSecretKey())
            ->end();

        return $treeBuilder;
    }

    private function getPath()
    {
        $node = new ScalarNodeDefinition('path');
        $node
            ->defaultValue(null)
            ->end();

        return $node;
    }

    private function getLines()
    {
        $node = new IntegerNodeDefinition('lines');

        $node
            ->defaultValue(100)
            ->end();

        return $node;
    }

    private function getSecretKey()
    {
        $node = new ScalarNodeDefinition('secret_key');

        $node
            ->defaultValue(null)
            ->end();

        return $node;
    }
}
