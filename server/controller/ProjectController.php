<?php

namespace app\controller;

use app\services\ProjectService;

class ProjectController
{

    private $projectService;

    function __construct()
    {
        $this->projectService = new ProjectService();
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

    function getCount()
    {
        return $this->projectService->getProjectsCount();
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
}
