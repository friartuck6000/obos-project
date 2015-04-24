<?php

namespace Obos\Bundle\ProjectManagementBundle\Form\Type;

use Obos\Bundle\CoreBundle\Form\EventListener\DeleteButtonSubscriber;
use Obos\Bundle\CoreBundle\Form\Type\UserAwareType;
use Obos\Bundle\ProjectManagementBundle\Manager\ClientManager;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Builder for the project form.
 */
class ProjectType extends UserAwareType
{
    /**
     * @var  ClientManager  The Client persistence manager.
     */
    protected $clientManager;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Set the ClientManager reference.
     *
     * @param   ClientManager  $manager
     * @return  $this
     */
    public function setClientManager(ClientManager $manager)
    {
        $this->clientManager = $manager;

        return $this;
    }

    // -----------------------------------------------------------------------------------------------------------------

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
                'mapped' => false,
                'data'   => $options['consultantID'],
            ])
            ->add('new', 'hidden', [
                'mapped' => false,
                'data'   => 1
            ])
            ->add('client', 'entity', [
                'class'         => 'ObosCoreBundle:Client',
                'query_builder' => $this->clientManager->getClientListBuilder(),
                'property'      => 'name',
            ])
            ->add('title', 'text')
            ->add('shortTitle', 'text', ['required' => false])
            ->add('dateDue', 'datetime', [
                'date_format' => 'MM-dd-yyyy',
                'date_widget' => 'choice',
            ])
            ->add('hourlyRate', 'money', ['currency' => 'USD'])
            ->add('autoBilled', 'checkbox', ['required' => false]);

        // Add submit button
        $builder
            ->add('submit', 'submit');

        // Register event subscriber to add delete button for existing projects
        $builder->addEventSubscriber(new DeleteButtonSubscriber());
    }

    /**
     * {@inheritdoc}
     *
     * @return  string
     */
    public function getName()
    {
        return 'project';
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
