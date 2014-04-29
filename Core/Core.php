<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Core;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Core
 * 
 * This class contains the core options of the page bundle
 */
class Core {

    protected $em;
    protected $container;
    protected $translator;

    /**
     * Set the constructor
     * @param EntityManager $em
     * @param ContainerInterface $container
     */
    public function __construct(EntityManager $em, ContainerInterface $container) {
        $this->em = $em;
        $this->container = $container;
        $this->translator = $container->get('translator');
    }

    /**
     * Get all pages's menus
     * @return mixed
     */
    public function getMenus() {
        $language = $this->container->get('request')->getLocale();
        $menus = $this->em->getRepository('StiwlPageBundle:Menu')->findAllOrdered_language($language);
        return $menus;
    }

    /**
     * Get header images
     * @return mixed
     */
    public function getHeadersImages() {
        $language = $this->container->get('request')->getLocale();
        $headersImages = $this->em->getRepository('StiwlPageBundle:HeaderImage')->findAllOrdered_language($language);
        return $headersImages;
    }

    /**
     * Get all languages availables
     * @return array
     */
    public function getLanguages() {
//        $finder = new Finder();
//        $languages = $finder->directories()->depth("0")->in("../app/Resources/translations/");
//        return $languages;
        $languages['es'] = $this->translator->trans('spanish', array(), 'StiwlPageBundle');
        $languages['en'] = $this->translator->trans('english', array(), 'StiwlPageBundle');
        $languages['fr'] = $this->translator->trans('french', array(), 'StiwlPageBundle');
        return $languages;
    }

    /**
     * Get a dropdown box of languages
     * @return html
     */
    public function ddlbLanguage() {
        $html = '';
        $html .= '<select name="ddlbLanguage">';
        foreach ($this->getLanguages() as $languageK => $language) {
            $selected = ($languageK == $this->container->get('request')->getLocale()) ? "selected='selected'" : '';
            $html .= '<option value="' . $languageK . '"' . $selected . '>' . $language . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

}
