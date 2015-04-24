<?php

namespace Obos\Bundle\ProjectManagementBundle\Controller;

use Obos\Bundle\CoreBundle\Entity\Project;
use Obos\Bundle\CoreBundle\Entity\ProjectTask;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Task management controller.
 *
 * @Route("/projects")
 */
class TaskController extends Controller
{
    /**
     * Create a new task.
     *
     * @param   Request  $request
     * @param   Project  $project
     * @return  Response
     *
     * @Route("/{project}/add-task", name="tasks.add")
     * @ParamConverter("project", class="ObosCoreBundle:Project", options={"id" = "project"})
     */
    public function createTaskAction(Request $request, Project $project)
    {}

    /**
     * Update or remove a task.
     *
     * @param   Request      $request
     * @param   ProjectTask  $task
     * @return  Response
     *
     * @Route("/tasks/{task}/edit", name="tasks.edit")
     * @ParamConverter("task", class="ObosCoreBundle:ProjectTask", options={"id" = "task"})
     */
    public function editTaskAction(Request $request, ProjectTask $task)
    {}

    /**
     * Mark a task completed.
     *
     * @param   Request      $request
     * @param   ProjectTask  $task
     * @return  Response
     *
     * @Route("/tasks/{task}/complete", name="tasks.complete")
     * @ParamConverter("task", class="ObosCoreBundle:ProjectTask", options={"id" = "task"})
     */
    public function completeTaskAction(Request $request, ProjectTask $task)
    {}
}