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
 * This class manage the CRUD category languages entity.
 */
class CategoryAdmin extends Admin {

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
                ->add('languages', 'sonata_type_collection', array(
                    'by_reference' => false,
                    'label' => 'languages'
                        ), array(
                    'edit' => 'inline',
                    'inline' => 'table'
                        )
                )
                ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureShowFields(ShowMapper $showMapper) {
        $showMapper
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
        $categories = $em->getRepository("StiwlPageBundle:Category")->findAllToSonataAdmin_query_language($query, $language);
        return $categories;
    }

    /**
     * {@inheritdoc}
     */
    public function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('languages', null, array('label' => 'languages', 'template' => 'StiwlPageBundle:Admin:List/languages.html.twig'))
                ->add('_action', null, array(
                    'actions' => array(
                        'edit' => array(),
                        'delete' => array(),
                        'view' => array()
                    ),
                    "label" => 'actions'
                ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $em = $this->getManager();
        $language = $this->getRequest()->getLocale();
        $categoriesLanguage = $em->getRepository("StiwlPageBundle:CategoryLanguage")->findAllFilterToSonataAdmin_language($language);
        $datagridMapper
                ->add('languages', null, array(
                    'label' => 'language'
                        ), null, array(
                    'choices' => $categoriesLanguage,
                    'property' => 'description',
                ))
        ;
    }

}