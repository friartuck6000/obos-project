<?php

namespace Obos\Bundle\BillingBundle\Form\Type;

use Obos\Bundle\BillingBundle\Manager\InvoiceManager;
use Obos\Bundle\CoreBundle\Form\EventListener\DeleteButtonSubscriber;
use Obos\Bundle\CoreBundle\Form\Type\UserAwareType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class PaymentType extends UserAwareType
{
    /**
     * @var  InvoiceManager
     */
    protected $invoiceManager;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Set invoice manager reference.
     *
     * @param   InvoiceManager  $manager
     * @return  $this
     */
    public function setInvoiceManager(InvoiceManager $manager)
    {
        $this->invoiceManager = $manager;

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
            ->add('invoice', 'entity', [
                'class'         => 'ObosCoreBundle:Invoice',
                'query_builder' => $this->invoiceManager->getInvoiceListBuilder(false),
            ])
            ->add('datePaid', 'datetime', [
                'date_format' => 'MM-dd-yyyy',
                'date_widget' => 'choice',
            ])
            ->add('amountPaid', 'money', ['currency' => 'USD']);

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
        return 'payment';
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