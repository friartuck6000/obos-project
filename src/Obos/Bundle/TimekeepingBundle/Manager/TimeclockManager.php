<?php

namespace Obos\Bundle\TimekeepingBundle\Manager;

use Obos\Bundle\CoreBundle\Manager,
    Obos\Bundle\CoreBundle\Exception\InvalidArgumentException,
    Obos\Bundle\CoreBundle\Entity\Timestamp,
    Obos\Bundle\CoreBundle\Entity\Project,
    DateTime;



class TimeclockManager extends Manager\AbstractPersistenceManager
{
    use Manager\UserDependentTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Open a new timestamp for a project.
     *
     * Note that this method, as well as the clockOut() method expect a Project as an argument,
     * rather than a Timestamp directly. Here, this is because to open a timestamp, we need a project
     * to assign it to.
     *
     * @see clockOut()
     *
     * @param  Project  $project
     */
    public function clockIn(Project $project)
    {
        // This shouldn't happen, but if, for some reason, we're trying to clock in with
        // an open timestamp, we'll make sure to close it first.
        if (($timestamp = $project->getOpenTimestamp()))
        {
            $timestamp->setStopStamp(new DateTime());
            $this->entityManager->persist($timestamp);
        }

        // Now we'll generate the new timestamp
        $timestamp = new Timestamp();
        $timestamp->setProject($project)
            ->setStartStamp(new DateTime());
        $this->entityManager->persist($timestamp);

        // Run a database transaction to save changes
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    /**
     * Close the open timestamp for a project.
     *
     * Note that this method, as well as the clockOut() method expect a Project as an argument,
     * rather than a Timestamp directly. Here, this is because the project already contains a
     * reference to the open timestamp, so we can access it directly from there.
     *
     * The ultimate idea with both the clockIn() and clockOut() methods is that only a project reference should
     * be necessary to facilitate the timecard mechanism.
     *
     * @see clockIn()
     *
     * @param  Project  $project
     */
    public function clockOut(Project $project)
    {
        // Get the open timestamp
        if (!($timestamp = $project->getOpenTimestamp()) instanceof Timestamp)
        {
            throw new InvalidArgumentException('Project does not have an open timestamp.');
        }

        // Close it
        $timestamp->setStopStamp(new DateTime());
        $this->entityManager->persist($timestamp);

        // Run a database transaction to save changes
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    /**
     * Add a manual timestamp with user-specified start/stop times.
     *
     * @param  Project   $project
     * @param  DateTime  $start
     * @param  DateTime  $end
     */
    public function addTimestamp(Project $project, DateTime $start, DateTime $end)
    {
        $timestamp = new Timestamp();
        $timestamp->setProject($project)
            ->setStartStamp($start)
            ->setStopStamp($end);
        $this->entityManager->persist($timestamp);

        $this->entityManager->flush();
        $this->entityManager->clear();
    }
}
