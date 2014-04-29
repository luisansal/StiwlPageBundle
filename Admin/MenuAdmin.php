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
 * This class manage the CRUD menu entity.
 */
class MenuAdmin extends Admin {

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
     * Get all menus except self by id
     * @param type $language
     * @param type $menuId
     * @return object
     */
    public function getAllNotSelf($language, $menuId = null) {
        $em = $this->getManager();
        $parent = $em->getRepository('StiwlPageBundle:Menu')->findAllNotSelf_language_id($language, $menuId);
        return $parent;
    }

    /**
     * {@inheritdoc}
     */
    public function configureFormFields(FormMapper $formMapper) {
        $language = $this->getRequest()->getLocale();
        $menu = $this->getSubject();
        $formMapper
                ->with('general')
                ->add('parent', null, array(
                    'label' => 'parent',
                    'choices' => $this->getAllNotSelf($language, $menu->getId()),
                    'property' => 'languages[0].name'
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
                ->add('parent', null, array(
                    'label' => 'parent',
                    'template' => 'StiwlPageBundle:Admin:Show/type.html.twig'
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
        $menus = $em->getRepository('StiwlPageBundle:Menu')->findAllToSonataAdmin_query_language($query, $language);
        return $menus;
    }

    /**
     * {@inheritdoc}
     */
    public function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('parent', null, array(
                    'label' => 'parent',
                    'template' => 'StiwlPageBundle:Admin:List/type.html.twig'
                ))
                ->add('position', null, array('label' => 'position'))
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
                    "label" => 'actions'
                ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
//                ->add('parent', null, array('label' => 'parent'))
//                ->add('position', null, array('label' => 'position'))
//                ->add('languages', null, array('label' => 'languages'))
        ;
    }

}