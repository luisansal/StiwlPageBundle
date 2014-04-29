<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * ContactType
 * 
 * This class contains the contact form
 */
class ContactType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $collectionConstraint = new Collection(array(
            'name' => array(new NotBlank(), new Length(array('min' => 5))),
            'email' => array(new Email(), new NotBlank()),
            'subject' => new NotBlank(),
            'message' => array(new NotBlank(), new Length(array('min' => 5)))
        ));

        $resolver->setDefaults(array(
            'validation_constraint' => $collectionConstraint,
            'translation_domain' => "StiwlPageBundle"
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', null, array('label' => 'name'))
                ->add('email', 'email', array('label' => 'email'))
                ->add('subject', null, array('label' => 'subject'))
                ->add('message', 'textarea', array('label' => 'message'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'stiwl_pageB_contact';
    }

}