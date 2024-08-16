<?php

namespace app\services;

use app\config\MysqlDBH;
use app\dto\ResponseDto;
use app\model\Project;
use app\model\ProjectUser;
use app\services\impl\ProjectServiceImpl;
use app\utils\MediaFileHandler;

class ProjectService implements ProjectServiceImpl
{

    private $model;
    private $userService;
    private $modelPU;

    function __construct()
    {
        $connector = new MysqlDBH();
        $this->model = new Project($connector);
        $this->modelPU = new ProjectUser($connector);
        $this->userService = new UserService();
    }

    function setProject(array $payload): string
    {
        // Validate User
        $members = $this->userService->filterValidMembers(explode(',', $payload['_members']));
        // Insert Project
        array_pop($payload);


        $response = $this->model->insertProject($payload);

        if (is_int($response)) {
            if ($response > 0) {
                //  Insert Project User
                $done = true;
                foreach ($members as $key => $member) {
                    $request = array(
                        '_project_id' => $response,
                        '_member' => $member
                    );
                    $res = $this->modelPU->insertProjectUser($request);
                    if ($res == false) $done = false;
                }

                if ($done) return ResponseDto::json("Project has been created successfully!", 201);
            }
            return ResponseDto::json("An error was encountered while trying to create project!", 500);
        }
        return ResponseDto::json("This project name already exist in our system!", 422);
    }

    function getCreatorsProject(int $_id): string
    {
        $response = $this->model->fetchProjectByCreator($_id);
        return ResponseDto::json($response);
    }



    function getProjects(): string
    {
        $response = $this->model->fetchProjects();
        return ResponseDto::json($response);
    }

    function getProjectBySlug(string $slug): string
    {
        $response = $this->model->fetchProjectBySlug($slug);
        return ResponseDto::json($response, 200);
    }


    function getProjectsCount(): int
    {
        $response = $this->model->fetchProjects();
        return count($response);
    }


    function editProject(array $payload, int $project_id, string $delist): string
    {
        $members = $this->userService->filterValidMembers(explode(',', $payload['_members']));

        // Insert Project
        array_pop($payload);


        $response = $this->model->updateProject($payload);

        if (is_bool($response)) {
            if ($response) {
                //  Insert Project User
                $done = true;
                $de_done = true;
                foreach ($members as $key => $member) {
                    $request = array(
                        '_project_id' => $project_id,
                        '_member' => $member
                    );
                    $res = $this->modelPU->insertProjectUser($request);
                    if ($res == "exist") {
                        $res = $this->modelPU->updateMemberStatus($request["_member"], 0);
                        continue;
                    }
                    if ($res == false) $done = false;
                }


                if (strlen(trim($delist)) > 2) {
                    // Remove Delisting Members
                    $delistmembers = $this->userService->filterValidMembers(explode(',', $delist));

                    foreach ($delistmembers as $key => $member) {
                        $res = $this->modelPU->updateMemberStatus($member);
                        if ($res == false) $de_done = false;
                    }

                    if ($done && $de_done) return ResponseDto::json("Project has been updated successfully!", 200);
                    if ($done) return ResponseDto::json("Project has been updated without removing delisted members!", 200);
                } else {
                    if ($done) return ResponseDto::json("Project has been updated successfully!", 200);
                }

                return ResponseDto::json("Project has been updated without updating the members list!", 422);
            }
            return ResponseDto::json("An error was encountered while trying to update this project!", 500);
        }
        return ResponseDto::json("Oooooops; We are unable to update this project at this time. please try again later or contact developer!", 422);
    }

    function removeProject(string $slug): string
    {
        $response = $this->model->deleteProject($slug);
        if ($response)
            return ResponseDto::json("Project was deleted successfully", 200);
        return ResponseDto::json("We are unable to delete this project at the moment. Please try again!");
    }


    // PU


    function getProjectMembers(int $project_id): string
    {
        $response = $this->modelPU->fetchProjectMembers($project_id);
        return ResponseDto::json($response);
    }




    // function removeProject(string $images, int $id): string
    // {
    //     $response = $this->model->deleteProject($id);
    //     if ($response) {
    //         $media = new MediaFileHandler();
    //         if ($media->deleteFiles($images)) {
    //             return ResponseDto::json("Project was deleted successfully", 200);
    //         }
    //         return ResponseDto::json("Project has been deleted; but we are unable to delete it's resources entirely!");
    //     }
    //     return ResponseDto::json("We are unable to delete this project at the moment. Please try again!");
    // }
}
