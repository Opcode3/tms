<?php

namespace app\controller;

use app\services\MediaService;
use app\services\ProjectService;

class ProjectController
{

    private $projectService;
    private $mediaService;

    function __construct()
    {
        $this->projectService = new ProjectService();
        $this->mediaService = new MediaService();
    }

    function addProject(array $payload)
    {
        return $this->projectService->setProject($payload);
    }

    function getCreatorProjects(int $id)
    {
        return $this->projectService->getCreatorsProject($id);
    }

    function getProjectBySlug(string $slug)
    {
        return $this->projectService->getProjectBySlug($slug);
    }

    function getAllProjects()
    {
        return $this->projectService->getProjects();
    }

    function getCount(int $id)
    {
        return $this->projectService->getProjectsCount($id);
    }

    function getCompleteCount(int $id)
    {
        return $this->projectService->getCompletedProjectsCount($id);
    }
    function modifyProjectInfo(array $payload, int $project_id, string $delist = "")
    {
        return $this->projectService->editProject($payload, $project_id, $delist);
    }


    function deleteProject(string $slug)
    {
        return $this->projectService->removeProject($slug);
    }


    function getProjectMembers(int $id)
    {
        return $this->projectService->getProjectMembers($id);
    }


    // Task

    function getProjectTasksById(int $_id): string
    {
        return $this->projectService->getProjectTasks($_id);
    }

    function getProjectTasksByProjectId(int $_id, int $user_id): string
    {
        return $this->projectService->getAssignedTasksByProjectId($_id, $user_id);
    }


    function addTaskToProject(array $payload, $files)
    {
        return $this->projectService->setTask($payload, $files);
    }

    function modifyTask(array $payload)
    {
        return $this->projectService->editTaskBySlug($payload);
    }

    function getTaskBySlug(string $slug)
    {
        return $this->projectService->getTaskBySlug($slug);
    }

    function getTaskCount(int $id)
    {
        return $this->projectService->getTasksCount($id);
    }

    function getAssignedTasks(int $id)
    {
        return $this->projectService->getAssignedTasks($id);
    }

    function getProjectAssignedTasks(int $id)
    {
        return $this->projectService->getAssignedProject($id);
    }




    // SubTask

    function getTaskSubTasksByParentId(int $_parent_id): string
    {
        return $this->projectService->getSubTaskByParentId($_parent_id);
    }

    function addSubTaskToTask(array $payload)
    {
        return $this->projectService->setSubTask($payload);
    }

    function modifySubTaskStatus(string $slug, int $status)
    {
        return $this->projectService->editSubTaskStatus($status, $slug);
    }



    // Comment 
    function getTaskCommentByTaskId(int $task_id): string
    {
        return $this->projectService->getTaskComments($task_id);
    }

    function makeTaskComment(array $payload)
    {
        return $this->projectService->makeComment($payload);
    }


    // Messages
    function getMessagesByTaskId(int $_parent_id): string
    {
        return $this->projectService->getTaskMessages($_parent_id);
    }

    function writeMessage(array $payload)
    {
        return $this->projectService->writeMessage($payload);
    }


    // Media

    function getTaskAttachments(int $id)
    {
        return $this->mediaService->getTaskAttachments($id);
    }
}
