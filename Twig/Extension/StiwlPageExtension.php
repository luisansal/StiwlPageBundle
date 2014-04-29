<?php

namespace Stiwl\PageBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

class StiwlPageExtension extends \Twig_Extension {

    private $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function getGlobals() {
        $config = $this->container->getParameter('stiwl_page.config');
        return array(
            'stiwl_page_core' => $this->container->get('stiwl_page.core'),
            'stiwl_page_config' => $config,
        );
    }

    public function getFunctions() {
        return array(
            'implode_route_params' => new \Twig_Function_Method($this, 'implodeRouteParams'),
            'explode_route_params' => new \Twig_Function_Method($this, 'explodeRouteParams')
        );
    }

    public function implodeRouteParams($routeParams = array(), $glueImplode = ',', $glueSeparator = ";") {
        foreach ($routeParams as $routeParamK => $routeParamV) {
            $indexRoute[] = $routeParamK;
        }
        $index = implode($glueImplode, $indexRoute);
        $value = implode($glueImplode, $routeParams);
        return $index . $glueSeparator . $value;
    }

    public function explodeRouteParams($routeParams = array(), $glueExplode = ',', $glueSeparator = ";") {
        $indexValue = explode($glueSeparator, $routeParams);
        $indexes = explode($glueExplode, $indexValue[0]);
        $values = explode($glueExplode, $indexValue[1]);
        $parameters = array();
        foreach ($indexes as $indexK => $indexV) {
            $parameters[$indexV] = $values[$indexK];
        }
        return $parameters;
    }

    public function getName() {
        return "stiwl_page_extension";
    }

}

?>
