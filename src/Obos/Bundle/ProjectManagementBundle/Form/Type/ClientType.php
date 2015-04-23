<?php

namespace Obos\Bundle\ProjectManagementBundle\Form\Type;

use Obos\Bundle\CoreBundle\Form\EventListener\DeleteButtonSubscriber;
use Obos\Bundle\CoreBundle\Form\Type\UserAwareType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Builder for the client form.
 */
class ClientType extends UserAwareType
{
    /**
     * {@inheritdoc}
     *
     * @param  FormBuilderInterface  $builder
     * @param  array                 $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Add fields
        $builder
            ->add('consultantID', 'hidden', [
                'mapped' => FALSE,
                'data'   => $options['consultantID']
            ])
            ->add('id', 'hidden')
            ->add('name', 'text')
            ->add('shortName', 'text', ['required' => false])
            ->add('website', 'url', ['required' => false])
            ->add('address1', 'text')
            ->add('address2', 'text', ['required' => false])
            ->add('city', 'text')
            ->add('state', 'text')
            ->add('zip', 'text');

        // Add submit button
        $builder
            ->add('submit', 'submit');

        $builder->addEventSubscriber(new DeleteButtonSubscriber());
    }

    /**
     * {@inheritdoc}
     *
     * @return  string
     */
    public function getName()
    {
        return 'client';
    }

    /**
     * Set default options for the form type.
     *
     * @param  OptionsResolverInterface  $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'consultantID' => $this->user->getId(),
        ]);
    }
}