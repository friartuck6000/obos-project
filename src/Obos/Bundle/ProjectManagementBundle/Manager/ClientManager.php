<?php

namespace Obos\Bundle\ProjectManagementBundle\Manager;

use Obos\Bundle\CoreBundle\Entity\Client;
use Obos\Bundle\CoreBundle\Manager\AbstractPersistenceManager;
use Obos\Bundle\CoreBundle\Manager\UserDependentTrait;
use Symfony\Component\Form\Form;


/**
 * The persistence manager for Clients.
 *
 */
class ClientManager extends AbstractPersistenceManager
{
    use UserDependentTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Generate a QueryBuilder instance that loads all clients for the current user.
     * Primarily used for the toolbar form on the project manager root screen.
     *
     * @return  \Doctrine\ORM\QueryBuilder
     */
    public function getClientListBuilder()
    {
        $builder = $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from('ObosCoreBundle:Client', 'c')
            ->where('c.consultant = ?1')
            ->setParameter(1, $this->user);

        return $builder;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Save the client (whether new or existing) to the database.
     *
     * @param   Client  $client
     * @param   Form    $form
     * @return  bool
     */
    public function saveClient(Client $client, Form $form)
    {
        // Set a flag indicating whether the entity is new
        $new = !($client->getId() > 0 && $this->entityManager->contains($client));

        // Validate the user association
        if (!$this->userMatches($form->get('consultantID'))) {

            // If the association isn't valid, add an error message
            $this->addFlash('danger', sprintf(
                'The client <b>%s</b> could not be saved because there was an error '
                .'linking it to your account; please try again.',
                $client->getName()
            ));

            return false;
        }

        // If the entity is new, link the user
        if ($new) {
            $client->setConsultant($this->user);
        }

        // Save the user
        try {
            $this->entityManager->persist($client);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            // Add error message if the database transaction failed
            $this->addFlash('danger', sprintf(
                'The client <b>%s</b> could not be saved because of a database error.',
                $client->getName()
            ));

            return false;
        }

        // Add confirmation message
        $this->addFlash('success', sprintf(
            'The client <b>%s</b> was successfully saved.',
            $client->getName()
        ));

        return true;
    }

    public function deleteClient(Client $client)
    {
        if ($this->entityManager->contains($client)) {
            try {
                $this->entityManager->remove($client);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                // Add error message if the database transaction failed
                $this->addFlash('danger', sprintf(
                    'The client <b>%s</b> could not be removed because of a database error.',
                    $client->getName()
                ));

                return false;
            }
        }

        // Add confirmation message
        $this->addFlash('success', sprintf(
            'The client <b>%s</b> was successfully deleted.',
            $client->getName()
        ));

        return true;
    }
}
