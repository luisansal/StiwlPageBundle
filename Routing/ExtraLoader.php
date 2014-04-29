<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\DependencyInjection\Container;

/**
 * ExtraLoader
 * 
 * This class contains the extra loader of page bundle
 */
class ExtraLoader extends Loader {

    protected $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load($resource, $type = null) {
        $collection = new RouteCollection();
        $config = $this->container->getParameter('stiwl_page.config');
        if ($config['pages']['fos_user']['register']['enabled']) {
            $resource = '@StiwlPageBundle/Resources/config/routing/register.yml';
            $type = "yaml";
            $importedRoutes = $this->import($resource, $type);
            $collection->addCollection($importedRoutes);
        }

        if ($config['pages']['news']['enabled']) {
            $resource = '@StiwlPageBundle/Resources/config/routing/news.yml';
            $type = "yaml";
            $importedRoutes = $this->import($resource, $type);
            $collection->addCollection($importedRoutes);
        }
        if ($config['pages']['contact_us']['enabled']) {
            $resource = '@StiwlPageBundle/Resources/config/routing/contact.yml';
            $type = "yaml";
            $importedRoutes = $this->import($resource, $type);
            $collection->addCollection($importedRoutes);
        }
        if ($config['pages']['products']['enabled']) {
            $resource = '@StiwlPageBundle/Resources/config/routing/product.yml';
            $type = "yaml";
            $importedRoutes = $this->import($resource, $type);
            $collection->addCollection($importedRoutes);
        }
        return $collection;
    }

    /**
     * {@inheritDoc}
     */
    public function supports($resource, $type = null) {
        return 'stiwl_page' === $type;
    }

}