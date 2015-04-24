<?php

namespace Obos\Bundle\ProjectManagementBundle\Manager;

use Obos\Bundle\CoreBundle\Entity\ProjectTask;
use Obos\Bundle\CoreBundle\Manager\AbstractPersistenceManager;
use Obos\Bundle\CoreBundle\Manager\UserDependentTrait;
use Symfony\Component\Form\Form;


class TaskManager extends AbstractPersistenceManager
{
    use UserDependentTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param   ProjectTask  $task
     * @param   Form         $form
     * @return  bool
     */
    public function saveTask(ProjectTask $task, Form $form)
    {
        // Validate the user association
        if (!$this->userMatches($form->get('consultantID'))) {

            // If the association isn't valid, add an error message
            $this->addFlash('danger', sprintf(
                'The task <b>%s</b> could not be saved because there was an error '
                .'linking it to your account; please try again.',
                $task->getName()
            ));

            return false;
        }

        // Bump the mod date
        $task->update();

        // Bump the mod date on the project too
        $project = $task->getProject()->update();

        // Save the project
        try {
            $this->entityManager->persist($project);
            $this->entityManager->persist($task);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            // Add error message if the database transaction failed
            $this->addFlash('danger', sprintf(
                'The task <b>%s</b> could not be saved because of a database error: %s.',
                $task->getName(),
                $e->getMessage()
            ));

            return false;
        }

        // Add confirmation message
        $this->addFlash('success', sprintf(
            'The task <b>%s</b> was successfully saved.',
            $task->getName()
        ));

        return true;
    }

    /**
     * @param   ProjectTask  $task
     * @return  bool
     */
    public function deleteTask(ProjectTask $task)
    {
        if ($this->entityManager->contains($task)) {

            // Ping the project modification date
            $project = $task->getProject()->update();

            try {
                $this->entityManager->persist($project);
                $this->entityManager->remove($task);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                // Add error message if the database transaction failed
                $this->addFlash('danger', sprintf(
                    'The task <b>%s</b> could not be removed because of a database error.',
                    $task->getName()
                ));

                return false;
            }
        }

        // Add confirmation message
        $this->addFlash('success', sprintf(
            'The task <b>%s</b> was successfully deleted.',
            $task->getName()
        ));

        return true;
    }

    /**
     * @param   ProjectTask  $task
     * @param   Form         $form
     * @return  bool
     */
    public function saveOrDeleteTask(ProjectTask $task, Form $form)
    {
        $action = $form->getClickedButton();
        if ($action) {
            if ($action->getName() == 'delete') {
                return $this->deleteTask($task);
            } else {
                return $this->saveTask($task, $form);
            }
        }

        // Return false if neither of the above was performed
        return false;
    }

    /**
     * @param   ProjectTask  $task
     * @return  bool
     */
    public function completeTask(ProjectTask $task)
    {
        try {
            $task->setStatus(ProjectTask::STATUS_COMPLETE);
            $this->entityManager->persist($task);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            // Add error message if the database transaction failed
            $this->addFlash('danger', sprintf(
                'The status for task <b>%s</b> could not be updated because of a database error.',
                $task->getName()
            ));

            return false;
        }

        // Add confirmation message
        $this->addFlash('success', sprintf(
            'The task <b>%s</b> has been completed.',
            $task->getName()
        ));

        return true;
    }
}