<?php
/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com> 
 */

namespace Stiwl\PageBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * This class manage the CRUD header image languages entity.
 */
class HeaderImageAdmin extends Admin {

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

    /**
     * {@inheritdoc}
     */
    public function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with('general')
                ->add('image', 'sonata_type_model_list', array('label' => 'image'), array(
                    'link_parameters' => array('context' => 'default'
                    )
                ))
                ->add('position', null, array('label' => 'position'))
                ->add('languages', 'sonata_type_collection', array(
                    'label' => 'languages',
                    'by_reference' => false
                        ), array(
                    'edit' => 'inline',
                    'inline' => 'table'
                ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('image', null, array(
                    'label' => 'image',
                    'template' => 'SonataMediaBundle:MediaAdmin:show_image.html.twig'
                ))
                ->add('position', null, array('label' => 'position'))
                ->add('languages', null, array(
                    'label' => 'languages',
                    'template' => 'StiwlPageBundle:Admin:Show/languages.html.twig'
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
        $headerImages = $em->getRepository('StiwlPageBundle:HeaderImage')->findAllToSonataAdmin_query_language($query, $language);
        return $headerImages;
    }

    /**
     * {@inheritdoc}
     */
    public function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('image', null, array(
                    "label" => 'image',
                    'template' => 'SonataMediaBundle:MediaAdmin:list_image.html.twig'
                ))
                ->add('position', null, array('label' => 'position'))
                ->add('languages', null, array(
                    'label' => 'languages',
                    'template' => 'StiwlPageBundle:Admin:List/languages.html.twig'
                ))
                ->add('_action', null, array(
                    'label' => 'actions',
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
//                ->add('image', null, array('label' => 'image'))
//                ->add('position', null, array('label' => 'position'))
//                ->add('languages', null, array('label' => 'languages'))
        ;
    }

}