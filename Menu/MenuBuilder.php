<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

/**
 * MenuBuilder
 * 
 * This class container the menu builder
 */
class MenuBuilder {

    protected $factory;
    protected $container;
    protected $translationDomain = 'StiwlPageBundle';

    /**
     * Set the construct
     * @param FactoryInterface $factory
     * @param Container $container  
     */
    public function __construct(FactoryInterface $factory, Container $container) {
        $this->factory = $factory;
        $this->container = $container;
    }

    /**
     * Get the child noder from parents menu
     * @param menu $menu
     * @param menu $subMenu
     * @param menu $parent
     */
    private function get_child_nodes($menu, $subMenu, $parent) {
        $parent = $parent === NULL ? NULL : $parent;
        foreach ($parent->getChildren() as $childrenV) {
            $languages = $childrenV->getLanguages();
            $subMenu = $menu->addChild($languages[0]->getName(), array(
                'route' => 'stiwl_pageB_page',
                'routeParameters' => array(
                    'menuId' => $childrenV->getId(),
                    'slug' => $languages[0]->getSlug()
                )
            ));
            if (count($childrenV->getChildren()) > 0) {
                $subMenu->setAttribute('class', 'has-sub')->setExtra('html', '<div class="arrow"></div>');
            }
            $this->get_child_nodes($subMenu, null, $childrenV);
        }
    }

    /**
     * This is the pag menu builder 
     * @param Request $request
     * @return type
     */
    public function pageMenu(Request $request) {

        $menu = $this->factory->createItem('menu_page');
        $menu->setCurrentUri($request->getRequestUri());
        $menus = $this->container->get('stiwl_page.core')->getMenus();
        foreach ($menus as $menuV) {
            if (!$menuV->getParent()) {
                $languages = $menuV->getLanguages();
                $parentMenu = $menu->addChild($languages[0]->getName(), array(
                    'route' => 'stiwl_pageB_page',
                    'routeParameters' => array(
                        'menuId' => $menuV->getId(),
                        'slug' => $languages[0]->getSlug()
                    )
                        ))
                ;
                if (count($menuV->getChildren()) > 0) {
                    $parentMenu->setAttribute('class', 'has-sub')->setExtra('html', '<div class="arrow"></div>');
                }
                $this->get_child_nodes($parentMenu, null, $menuV);
            }
        }

        return $menu;
    }
    
    public function pageMenuConfig(Request $request){
        $menuConfig = $this->factory->createItem('menu_page_config');
        $menuConfig->setCurrentUri($request->getRequestUri());
        $config = $this->container->getParameter('stiwl_page.config');
        foreach ($config['pages'] as $pageK => $pageV) {
            ${'label' . ucfirst($pageK)} = $this->container->get('translator')->trans($pageK, array(), $this->translationDomain);
            if (isset($pageV['enabled']) && $pageV['enabled']) {
                $menuConfig->addChild(${'label' . ucfirst($pageK)}, array('route' => 'stiwl_pageB_' . $pageK));
            }
            if ($pageK == 'fos_user') {
                foreach ($pageV as $fos_userK => $fos_userV) {
                    ${'label' . ucfirst($fos_userK)} = $this->container->get('translator')->trans($fos_userK, array(), $this->translationDomain);
                    if ($fos_userK == 'login') {
                        if ($fos_userV['visible']) {
                            if (!$this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
                                $menuConfig->addChild(${'label' . ucfirst($fos_userK)}, array('route' => 'fos_user_security_' . $fos_userK));
                            }
                        }
                    } else {
                        if ($fos_userV['enabled']) {
                            $menuConfig->addChild(${'label' . ucfirst($fos_userK)}, array('route' => 'fos_user_registration_' . $fos_userK));
                        }
                    }
                }
            }
        }

        if ($this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            $myAccount = $menuConfig->addChild($this->container->get('translator')->trans('my_account', array(), $this->translationDomain))->setAttribute('class', 'has-sub')->setExtra('html', '<div class="arrow"></div>');
            $myAccount->addChild($this->container->get('translator')->trans('administration', array(), $this->translationDomain), array(
                'route' => 'sonata_admin_dashboard')
            );
            $myAccount->addChild($this->container->get('translator')->trans('log_out', array(), $this->translationDomain), array(
                'route' => 'fos_user_security_logout'
            ));
        }

        foreach ($config['pages'] as $pageK => $pageV) {
            if ($pageK == "fos_user") {
                foreach ($pageV as $fosuserK => $fosuserV) {
                    if (isset($fosuserV['visible']) && !$fosuserV['visible']) {
                        
                    } else {
                        if ($fos_userV['enabled']) {
                            switch ($fosuserV['position']) {
                                default:
                                    $menuConfig[${'label' . ucfirst($fosuserK)}]->moveToPosition($fosuserV['position']);
                                    break;
                                case 'first':
                                    $menuConfig[${'label' . ucfirst($fosuserK)}]->moveToFirstPosition();
                                    break;
                                case 'last':
                                    $menuConfig[${'label' . ucfirst($fosuserK)}]->moveToLastPosition();
                                    break;
                            }
                        }
                    }
                }
            } else {
                if ($pageV['enabled']) {
                    switch ($pageV['position']) {
                        default:
                            $menuConfig[${'label' . ucfirst($pageK)}]->moveToPosition($pageV['position']);
                            break;
                        case 'first':
                            $menuConfig[${'label' . ucfirst($pageK)}]->moveToFirstPosition();
                            break;
                        case 'last':
                            $menuConfig[${'label' . ucfirst($pageK)}]->moveToLastPosition();
                            break;
                    }
                }
            }
        }

        if ($menuConfig[$this->container->get('translator')->trans('my_account', array(), $this->translationDomain)]) {
            $menuConfig[$this->container->get('translator')->trans('my_account', array(), $this->translationDomain)]->moveToLastPosition();
        }
        return $menuConfig;
    }

}