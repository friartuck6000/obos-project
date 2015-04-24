<?php

namespace Obos\Bundle\ProjectManagementBundle\Form\Type;

use Obos\Bundle\CoreBundle\Entity\ProjectTask;
use Obos\Bundle\CoreBundle\Form\EventListener\DeleteButtonSubscriber;
use Obos\Bundle\CoreBundle\Form\Type\UserAwareType;
use Obos\Bundle\ProjectManagementBundle\Manager\ProjectManager;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class TaskType extends UserAwareType
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
                'property'      => 'shortTitle',
            ])
            ->add('name', 'text')
            ->add('description', 'textarea', ['required' => false])
            ->add('dateDue', 'datetime', [
                'date_format' => 'MM-dd-yyyy',
                'date_widget' => 'choice',
            ])
            ->add('category', 'choice', [
                'choices' => array_combine(
                    ProjectTask::getCategoryOptions(),
                    ProjectTask::getCategoryOptions()
                    )
            ]);

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
        return 'task';
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
