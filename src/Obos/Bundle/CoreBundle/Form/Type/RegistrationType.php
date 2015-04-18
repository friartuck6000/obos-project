<?php

namespace Obos\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * The builder for the registration form.
 *
 */
class RegistrationType extends AbstractType
{
    /**
     * Build the form.
     *
     * @param  FormBuilderInterface  $builder
     * @param  array                 $options
     */
    public function buildForm(FormBuilderInterface $builder, $options = [])
    {
        // Add fields
        $builder
            ->add('email', 'email', ['required' => TRUE])
            ->add('password', 'password')
            ->add('firstName', 'text')
            ->add('lastName', 'text')
            ->add('title', 'text', ['required' => FALSE])
            ->add('industry', 'text', ['required' => FALSE]);

        // Add submit button
        $builder
            ->add('submit', 'submit');

    }

    /**
     * Name the form type.
     *
     * @return  string
     */
    public function getName()
    {
        return 'registration';
    }

    /**
     * Set default options for the form type.
     *
     * @param  OptionsResolverInterface  $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Obos\Bundle\CoreBundle\Entity\Consultant'
        ]);
    }
}
