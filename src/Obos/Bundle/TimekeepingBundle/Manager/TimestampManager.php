<?php

namespace Obos\Bundle\TimekeepingBundle\Manager;

use Doctrine\ORM\Query\Expr\Join;
use Obos\Bundle\CoreBundle\Entity\Project;
use Obos\Bundle\CoreBundle\Entity\Timestamp;
use Obos\Bundle\CoreBundle\Exception\InvalidArgumentException;
use Obos\Bundle\CoreBundle\Manager\AbstractPersistenceManager;
use Obos\Bundle\CoreBundle\Manager\UserDependentTrait;
use Symfony\Component\Form\Form;


class TimestampManager extends AbstractPersistenceManager
{
    use UserDependentTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Finds an open timestamp for the current user, if there is one.
     *
     * @return  NULL|Timestamp
     */
    public function getOpenTimestamp()
    {
        // Get the user's projects
        $projects = $this->user->getAllProjects();

        // Loop through the projects and look for an open timestamp; break on the first one we find.
        $openTimestamp = null;
        /** @var  Project  $project */
        foreach ($projects as $project) {
            if (($openTimestamp = $project->getOpenTimestamp())) {
                break;
            }
        }

        return $openTimestamp;
    }

    /**
     * Load all the timestamps that belong to the current user.
     *
     * @return Timestamp[]
     */
    public function getAllUserTimestamps()
    {
        $builder = $this->entityManager->createQueryBuilder();
        $builder->select(['ts'])
            ->from('ObosCoreBundle:Timestamp', 'ts')
            ->join('ts.project', 'p')
            ->where('p.consultant = ?1')
            ->orderBy('ts.startStamp', 'DESC')
            ->addOrderBy('ts.stopStamp', 'DESC')
            ->setParameter(1, $this->user);

        return $builder->getQuery()->getResult();
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Open a new timestamp for the given project.
     *
     * @param   Project  $project
     * @return  bool
     */
    public function punchIn(Project $project)
    {
        if ($this->getOpenTimestamp()) {
            throw new InvalidArgumentException('Attempted to open a new timestamp while an existing one '
                .'is open.');
        }

        // Create the new timestamp
        $timestamp = new Timestamp();
        $timestamp->setProject($project)
            ->setStartStamp();

        // Persist it
        try {
            $this->entityManager->persist($timestamp);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            // Add error message if the database transaction failed
            $this->addFlash('danger', 'Timestamp could not be opened because of a database error.');

            return false;
        }

        // Add confirmation message
        $this->addFlash('success', sprintf(
            'You are now punched in on the <b>%s</b> project.',
            $project->getTitle()
        ));

        return true;
    }

    /**
     * Close the open timestamp for a user.
     *
     * @return  bool
     */
    public function punchOut()
    {
        if (!($timestamp = $this->getOpenTimestamp())) {
            throw new InvalidArgumentException('Attempted to close a timestamp when none is open.');
        }

        // Close the timestamp
        $timestamp->close();

        // Save changes
        try {
            $this->entityManager->persist($timestamp);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            // Add error message if the database transaction failed
            $this->addFlash('danger', 'Timestamp could not be closed because of a database error.');

            return false;
        }

        // Add confirmation message
        $this->addFlash('success', 'You have been punched out.');

        return true;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param   Timestamp  $timestamp
     * @param   Form       $form
     * @return  bool
     */
    public function saveTimestamp(Timestamp $timestamp, Form $form)
    {
        // Validate user association
        if (!$this->userMatches($form->get('consultantID'))) {

            // Add an error message if the association isn't valid
            $this->addFlash('danger', 'Timestamp could not be saved.');

            return false;
        }

        // Save the timestamp
        try {
            $this->entityManager->persist($timestamp);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            $this->addFlash('danger', 'The timestamp could not be saved because of a database error.');

            return false;
        }

        // Add confirmation message
        $this->addFlash('success', 'The timestamp was saved successfully.');

        return true;
    }

    /**
     * @param   Timestamp  $timestamp
     * @return  bool
     */
    public function deleteTimestamp(Timestamp $timestamp)
    {
        if ($this->entityManager->contains($timestamp)) {
            try {
                $this->entityManager->remove($timestamp);
                $this->entityManager->flush();
            } catch(\Exception $e) {
                $this->addFlash('danger', 'The timestamp could not be removed because of a database error.');

                return false;
            }
        }

        $this->addFlash('success', 'The timestamp was removed successfully.');

        return true;
    }

    /**
     * @param   Timestamp  $timestamp
     * @param   Form       $form
     * @return  bool
     */
    public function saveOrDeleteTimestamp(Timestamp $timestamp, Form $form)
    {
        $action = $form->getClickedButton();
        if ($action) {
            if ($action->getName() == 'delete') {
                return $this->deleteTimestamp($timestamp);
            } else {
                return $this->saveTimestamp($timestamp, $form);
            }
        }

        return false;
    }
}
