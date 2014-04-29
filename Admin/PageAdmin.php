<?php
/**
 * @author Luis Sánchez <luis.sanchez.saldana@gmail.com> 
 */

namespace Stiwl\PageBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * This class manage the CRUD page entity.
 */
class PageAdmin extends Admin {

    protected $maxPerPage = 10;
//  Default load messages translations.
    protected $translationDomain = 'StiwlPageBundle';
    protected $options;
    protected $container;
    protected $em;

    public function getContainer() {
        $this->container = $this->getConfigurationPool()->getContainer();
        return $this->container;
    }

    public function getManager() {
        $this->em = $this->getContainer()->get('doctrine')->getManager();
        return $this->em;
    }

    public function getAllMenuNoRepeatedInPage($language, $menuId = null) {
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $menus = $em->getRepository('StiwlPageBundle:Menu')->findAllNoRepeatedInPage_language_id($language, $menuId);
        return $menus;
    }

    /**
     * {@inheritdoc}
     */
    public function configureFormFields(FormMapper $formMapper) {
        $page = $this->getSubject();
        $menuId = ($page->getMenu()) ? $page->getMenu()->getId() : null;
        $language = $this->getRequest()->getLocale();
        $formMapper
                ->with('General')
                ->add('menu', null, array(
                    'label' => 'menu',
                    'required' => true,
                    'choices' => $this->getAllMenuNoRepeatedInPage($language, $menuId),
                    'property' => 'languages.values[0].name'
                ))
                ->add('languages', 'sonata_type_collection', array(
                    'by_reference' => false,
                    'label' => 'languages'
                        ), array(
                    'edit' => 'inline',
                    'inline' => 'table'
                        )
                )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('menu', null, array(
                    'label' => 'menu',
                    'template' => 'StiwlPageBundle:Admin:Show/type.html.twig'
                ))
                ->add('languages', null, array(
                    'label' => 'languages',
                    'template' => 'StiwlPageBundle:Admin:Show/pageLanguages.html.twig'
                ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list') {
        $query = parent::createQuery($context);
        $em = $this->getManager();
        $language = $this->getRequest()->getLocale();
        $pages = $em->getRepository('StiwlPageBundle:Page')->findAllToSonataAdmin_query_language($query, $language);
        return $pages;
    }

    /**
     * {@inheritdoc}
     */
    public function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('menu', null, array(
                    'label' => 'menu',
                    'template' => 'StiwlPageBundle:Admin:List/type.html.twig'
                ))
                ->add('languages', null, array(
                    'label' => 'languages',
                    'template' => 'StiwlPageBundle:Admin:List/pageLanguages.html.twig'
                ))
                ->add('_action', null, array(
                    'actions' => array(
                        'edit' => array(),
                        'view' => array(),
                        'delete' => array()
                    )
                ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
//                ->add('menu', null, array('label' => 'Menú'))
//                ->add('title', null, array('label' => 'Título'))
//                ->add('content', null, array('label' => 'Contenido'))
        ;
    }

}