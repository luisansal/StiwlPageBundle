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
 * This class manage the CRUD product languages entity.
 */
class ProductLanguageAdmin extends Admin {

    protected $maxPerPage = 10;
    protected $translationDomain = 'StiwlPageBundle';
    
    /**
     * {@inheritdoc}
     */
    public function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('language', null, array("label" => 'language'))
                ->add('name', null, array("label" => 'name'))
                ->add('description', null, array("label" => 'description'))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureFormFields(FormMapper $formMapper) {
        $languages = $this->getConfigurationPool()->getContainer()->get("stiwl_page.core")->getLanguages();
        foreach ($languages as $languageK => $language) {
            $choiceLanguages[$languageK] = $language;
        }
        $formMapper
                ->with('general')
                ->add('language', 'choice', array(
                    'label' => 'language',
                    'choices' => $choiceLanguages))
                ->add('name', null, array('label' => 'name'))
                ->add('description', 'ckeditor', array(
                    'label' => 'description',
                    'config_name' => 'advanced',
                    'config' => array(
                        'language' => $this->getRequest()->getLocale()
                    )
                ))
                ->end()
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('language', null, array("label" => 'language'))
                ->add('name', null, array("label" => 'name'))
                ->add('description', null, array("label" => 'description'))
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'edit' => array(),
                        'delete' => array(),
                        'view' => array()
                    )
                ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
//                ->add('language', null, array("label" => 'language'))
//                ->add('name', null, array("label" => 'name'))
//                ->add('description', null, array("label" => 'description'))
        ;
    }

}