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
 * This class manage the CRUD product entity.
 */
class ProductAdmin extends Admin {

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

    public function getCategoryByLanguage($language) {
        $em = $this->getManager();
        $categories = $em->getRepository("StiwlPageBundle:Category")->findAll_language($language);
        return $categories;
    }

    /**
     * {@inheritdoc}
     */
    public function configureFormFields(FormMapper $formMapper) {
        $pageConfig = $this->getConfigurationPool()->getContainer()->get('service_container')->getParameter('stiwl_page.config');
        $language = $this->getRequest()->getLocale();
        $formMapper
                ->add('category', null, array(
                    'label' => 'category',
                    'required' => true,
                    'choices' => $this->getCategoryByLanguage($language),
                    'property' => 'languages.values[0].name'
                ))
                ->add('price', null, array('label' => $this->getTranslator()->trans('price', array(), "StiwlPageBundle") . ' ' . $pageConfig['enterprise']['money']))
                ->add('image', 'sonata_type_model_list', array('label' => 'image'), array(
                    'link_parameters' => array('context' => 'default')))
                ->add('languages', 'sonata_type_collection', array(
                    'by_reference' => false,
                    'label' => 'languages'
                        ), array(
                    'edit' => 'inline',
                    'inline' => 'table'
                        )
                )
        //                ->add('stock', null, array('label' => 'Stock'))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureShowFields(ShowMapper $showMapper) {
        $pageConfig = $this->getConfigurationPool()->getContainer()->get('service_container')->getParameter('stiwl_page.config');
        $showMapper
                ->add('category', null, array(
                    'label' => 'category',
                    'template' => 'StiwlPageBundle:Admin:Show/type.html.twig'
                ))
                ->add('price', null, array('label' => $this->getTranslator()->trans('price', array(), "StiwlPageBundle") . ' ' . $pageConfig['enterprise']['money']))
                ->add('image', null, array(
                    'label' => 'image',
                    'template' => 'SonataMediaBundle:MediaAdmin:show_image.html.twig'
                ))
                ->add('languages', null, array(
                    'label' => 'languages',
                    'template' => 'StiwlPageBundle:Admin:Show/languages.html.twig'
                ))
//                ->add('stock', null, array('label' => 'Stock'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list') {
        $query = parent::createQuery($context);
        $em = $this->getManager();
        $language = $this->getRequest()->getLocale();
        $products = $em->getRepository('StiwlPageBundle:Product')->findAllToSonataAdmin_query_language($query, $language);
        return $products;
    }

    /**
     * {@inheritdoc}
     */
    public function configureListFields(ListMapper $listMapper) {
        $pageConfig = $this->getConfigurationPool()->getContainer()->get('service_container')->getParameter('stiwl_page.config');
        $listMapper
                ->add('category', null, array(
                    'label' => 'category',
                    'template' => 'StiwlPageBundle:Admin:List/type.html.twig'
                ))
                ->add('price', null, array('label' => $this->getTranslator()->trans('price', array(), "StiwlPageBundle") . ' ' . $pageConfig['enterprise']['money']))
                ->add('image', null, array(
                    "label" => 'image',
                    'template' => 'SonataMediaBundle:MediaAdmin:list_image.html.twig'
                ))
                ->add('languages', null, array(
                    'label' => 'languages',
                    'template' => 'StiwlPageBundle:Admin:List/languages.html.twig'
                ))
                ->add('_action', null, array(
                    'actions' => array(
                        'edit' => array(),
                        'delete' => array(),
                        'view' => array()
                    ),
                    'label' => 'actions'
                ))
//                ->add('stock', null, array('label' => 'Stock'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $pageConfig = $this->getConfigurationPool()->getContainer()->get('service_container')->getParameter('stiwl_page.config');
        $datagridMapper
//                ->add('category', null, array('label' => 'category'))
//                ->add('price', null, array('label' => $this->getTranslator()->trans('price',array(),"StiwlPageBundle") . ' ' . $pageConfig['enterprise']['money']))
//                ->add('image', null, array('label' => 'image'))
//                ->add('languages', null, array('label' => 'languages'))
//                ->add('stock', null, array('label' => 'Stock'))
        ;
    }

}