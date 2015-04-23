<?php

namespace Obos\Bundle\CoreBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


/**
 * This subscriber will check whether the subscribing form is handling a new or
 * existing entity; if the entity is _not_ new, it will add a "Delete" button to
 * the form.
 *
 */
class DeleteButtonSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     *
     * @return  array
     */
    public static function getSubscribedEvents()
    {
        return [FormEvents::PRE_SET_DATA => 'maybeAddDeleteButton'];
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Add a delete button to the form if it's managing an existing (persisted) entity.
     *
     * @param  FormEvent  $event
     */
    public function maybeAddDeleteButton(FormEvent $event)
    {
        // Get the form and the entity it's managing.
        $form = $event->getForm();
        $entity = $event->getData();

        // Since we don't know for sure the content of $entity, we'll use reflection
        // to be safe
        $idReflector = new \ReflectionProperty(get_class($entity), 'id');
        $idReflector->setAccessible(true);

        // Check the entity state; if it can be determined that it's not a new entity,
        // add the Delete button
        if ($entity && $idReflector->getValue($entity)) {
            $form->add('delete', 'submit');
        }
    }
}
