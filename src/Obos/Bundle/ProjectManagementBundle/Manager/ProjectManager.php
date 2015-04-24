<?php

namespace Obos\Bundle\ProjectManagementBundle\Manager;

use Obos\Bundle\CoreBundle\Entity\Project;
use Obos\Bundle\CoreBundle\Manager\AbstractPersistenceManager;
use Obos\Bundle\CoreBundle\Manager\UserDependentTrait;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\Form;


/**
 * Persistence manager for Projects.
 */
class ProjectManager extends AbstractPersistenceManager
{
    use UserDependentTrait;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Generate a QueryBuilder instance that loads projects for the current user.
     *
     * @return  QueryBuilder
     */
    public function getProjectListBuilder()
    {
        $builder = $this->entityManager->createQueryBuilder()
            ->select('p')
            ->from('ObosCoreBundle:Project', 'p')
            ->where('p.consultant = ?1')
            ->orderBy('p.dateDue', 'ASC')
            ->addOrderBy('p.dateModified', 'DESC')
            ->addOrderBy('p.title', 'ASC')
            ->setParameter(1, $this->user);

        return $builder;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Create or update a project in persistence.
     *
     * @param   Project  $project
     * @param   Form     $form
     * @return  bool
     */
    public function saveProject(Project $project, Form $form)
    {
        // Set a flag indicating whether the entity is new
        $new = !($project->getId() > 0 && $this->entityManager->contains($project));

        // Validate the user association
        if (!$this->userMatches($form->get('consultantID'))) {

            // If the association isn't valid, add an error message
            $this->addFlash('danger', sprintf(
                'The project <b>%s</b> could not be saved because there was an error '
                .'linking it to your account; please try again.',
                $project->getTitle()
            ));

            return false;
        }

        // If the entity is new, link the user
        if ($new) {
            $project->setConsultant($this->user);
        }

        // Bump the mod date
        $project->update();

        // Save the project
        try {
            $this->entityManager->persist($project);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            // Add error message if the database transaction failed
            $this->addFlash('danger', sprintf(
                'The project <b>%s</b> could not be saved because of a database error: %s.',
                $project->getTitle(),
                $e->getMessage()
            ));

            return false;
        }

        // Add confirmation message
        $this->addFlash('success', sprintf(
            'The project <b>%s</b> was successfully saved.',
            $project->getTitle()
        ));

        return true;
    }

    /**
     * Delete a project.
     *
     * @param   Project $project
     * @return  bool
     */
    public function deleteProject(Project $project)
    {
        if ($this->entityManager->contains($project)) {
            try {
                $this->entityManager->remove($project);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                // Add error message if the database transaction failed
                $this->addFlash('danger', sprintf(
                    'The project <b>%s</b> could not be removed because of a database error.',
                    $project->getTitle()
                ));

                return false;
            }
        }

        // Add confirmation message
        $this->addFlash('success', sprintf(
            'The project <b>%s</b> was successfully deleted.',
            $project->getTitle()
        ));

        return true;
    }
}