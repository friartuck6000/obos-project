<?php

namespace Obos\Bundle\TimekeepingBundle\Form\Type;

use Obos\Bundle\CoreBundle\Form\EventListener\DeleteButtonSubscriber;
use Obos\Bundle\CoreBundle\Form\Type\UserAwareType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class TimestampType extends UserAwareType
{
    /**
     * @var  ProjectManager
     */
    protected $projectManager;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Set project manager reference.
     *
     * @param   ProjectManager  $manager
     * @return  $this
     */
    public function setProjectManager(ProjectManager $manager)
    {
        $this->projectManager = $manager;

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
            ->add('project', 'entity', [
                'class'         => 'ObosCoreBundle:Project',
                'query_builder' => $this->projectManager->getProjectListBuilder(),
                'property'      => 'name',
            ])
            ->add('startStamp', 'datetime', [
                'date_format' => 'MM-dd-yyyy',
                'date_widget' => 'choice',
            ])
            ->add('stopStamp', 'datetime', [
                'date_format' => 'MM-dd-yyyy',
                'date_widget' => 'choice',
            ])
            ->add('description', 'textarea', ['required' => false]);

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
        return 'timestamp';
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
