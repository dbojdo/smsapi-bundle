<?php

namespace Webit\Bundle\SmsApiBundle\DependencyInjection;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface {
	/**
	 * {@inheritDoc}
	 */
	public function getConfigTreeBuilder() {
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root('webit_smsapi');

		$rootNode->
			children()
				->scalarNode('username')->cannotBeEmpty()->end()
				->scalarNode('password')->cannotBeEmpty()->end()
				->scalarNode('testmode')->defaultValue(1)->end()
				->arrayNode('request_defaults')
					->addDefaultsIfNotSet()
					->children()
						->scalarNode('from')->defaultNull()->end()
						->scalarNode('test')->defaultValue(1)->end()
						->scalarNode('eco')->defaultValue(1)->end()
				->end()
			->end()
		->end();
		
		// Here you should define the parameters that are allowed to
		// configure your bundle. See the documentation linked above for
		// more information on that topic.

		return $treeBuilder;
	}
}
?>
