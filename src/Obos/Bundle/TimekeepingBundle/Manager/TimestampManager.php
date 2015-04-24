<?php

namespace Obos\Bundle\TimekeepingBundle\Manager;

use Obos\Bundle\CoreBundle\Entity\Project;
use Obos\Bundle\CoreBundle\Entity\Timestamp;
use Obos\Bundle\CoreBundle\Exception\InvalidArgumentException;
use Obos\Bundle\CoreBundle\Manager\AbstractPersistenceManager;
use Obos\Bundle\CoreBundle\Manager\UserDependentTrait;


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
}
