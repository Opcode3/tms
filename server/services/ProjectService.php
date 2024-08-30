<?php

namespace app\services;

use app\config\MysqlDBH;
use app\dto\ResponseDto;
use app\model\Comment;
use app\model\Message;
use app\model\Project;
use app\model\ProjectUser;
use app\model\SubTask;
use app\model\Task;
use app\services\impl\ProjectServiceImpl;
use app\utils\MediaFileHandler;

class ProjectService implements ProjectServiceImpl
{

    private $model;
    private $userService;
    private $modelPU;
    private $modelTask;
    private $modelSubTask;
    private $modelComment;
    private $modelMessage;


    // Status 0 = uncomplted, 1 = completed

    function __construct()
    {
        $connector = new MysqlDBH();
        $this->model = new Project($connector);
        $this->modelPU = new ProjectUser($connector);
        $this->modelSubTask = new SubTask($connector);
        $this->modelTask = new Task($connector);
        $this->userService = new UserService();
        $this->modelComment = new Comment($connector);
        $this->modelMessage = new Message($connector);
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
        if (count($response) > 0) {
            $res = [];
            foreach ($response as $key => $project) {
                $_res = $this->modelTask->fetchTaskByProject((int) $project["project_id"]);
                $project["task_count"] = count($_res);
                array_push($res, $project);
            }
            return ResponseDto::json($res, 200);
        }
        return ResponseDto::json($response, 200);
    }

    function getProjects(): string
    {
        $response = $this->model->fetchProjects();
        return ResponseDto::json($response);
    }

    function getProjectBySlug(string $slug): string
    {
        $response = $this->model->fetchProjectBySlug($slug);
        if (count($response) > 0) {
            $_res = $this->modelTask->fetchTaskByProject((int) $response["project_id"]);
            $response["tasks"] = $_res;
        }
        return ResponseDto::json($response, 200);
    }

    function getProjectsCount(int $id): int
    {
        $response = $this->model->fetchProjectByCreator($id);
        return count($response);
    }

    function getCompletedProjectsCount(int $id): int
    {
        $response = $this->model->fetchProjectByStatus($id, 1);
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

    function markProjectAsComplete(string $slug): string
    {
        $response = $this->model->updateProjectStatus($slug);
        if ($response)
            return ResponseDto::json("Project has been marked completed.", 200);
        return ResponseDto::json("We are unable to process this request. Please try again!");
    }


    // PU
    function getProjectMembers(int $project_id): string
    {
        $response = $this->modelPU->fetchProjectMembers($project_id);
        return ResponseDto::json($response);
    }



    // Task

    function getProjectTasks(int $_id): string
    {
        $response = $this->modelTask->fetchTaskByProject($_id);
        return ResponseDto::json($response);
    }


    function setTask(array $payload, $files): string
    {
        $media = new MediaFileHandler();

        if ($media->multipleFileUpload($files) == true) {
            $response = $this->modelTask->createTask($payload);
            if (is_int($response) && $response > 0) {
                $res = $media->sealUpload($response);
                return $res ? ResponseDto::json("Task was created successfully!", 201) :
                    ResponseDto::json("An error was encountered while trying to create task!", 500);
            } else if (is_bool($response)) {
                return ResponseDto::json("An error was encountered while trying to create task!", 500);
            } else if ($response == "exist") {
                return ResponseDto::json("This exact task title already exist in this project!", 422);
            } else {
                return ResponseDto::json($response, 422);
            }
        }
        return ResponseDto::json("An issue was encountered while trying to upload the media!", 422);
    }

    function editTaskBySlug(array $payload): string
    {
        $response = $this->modelTask->updateTask($payload);
        if ($response) {
            return ResponseDto::json("Task information was updated accordingly!", 200);
        }
        return ResponseDto::json("We are unable to process this update. Please try again!");
    }

    function editTaskStatusBySlug(string $slug, int $status): string
    {
        $response = $this->modelTask->updateTaskStatus($slug, $status);
        if ($response) {
            return ResponseDto::json("Task status was updated!", 200);
        }
        return ResponseDto::json("We are unable to process this update. Please try again!");
    }

    function getTaskBySlug(string $slug): string
    {
        $response = $this->modelTask->fetchTaskBySlug($slug);
        return ResponseDto::json($response, 200);
    }

    function getTasksCount(int $id): int
    {
        $response = $this->modelTask->fetchTaskByCreator($id);
        return count($response);
    }

    function getAssignedTasks(int $id): string
    {
        $response = $this->modelTask->fetchMyAssignedTask($id);
        return ResponseDto::json($response, 200);
    }

    function getAssignedTasksByProjectId(int $id, $user_id): string
    {
        $response = $this->modelTask->fetchMyAssignedTaskByProjectId($id, $user_id);
        return ResponseDto::json($response, 200);
    }


    function getAssignedProject(int $id): string
    {
        $response = $this->modelTask->fetchMyAssignedTask($id);
        if (count($response) > 0) {
            $res = [];
            $visited_ids = [];
            foreach ($response as $key => $task) {
                if (in_array($task["task_project_id"], $visited_ids) == false) {
                    $_res = $this->model->fetchProjectById((int) $task["task_project_id"]);
                    $_res["task_count"] = 0;
                    array_push($res, $_res);
                }
            }
            return ResponseDto::json($res, 200);
        }
        return ResponseDto::json($response, 200);
    }


    function removeTask(string $slug): string
    {
        $response = $this->modelTask->deleteTask($slug);
        if ($response)
            return ResponseDto::json("Task was deleted successfully", 200);
        return ResponseDto::json("We are unable to delete this task at the moment. Please try again!");
    }


    // SubTask

    function getSubTaskByParentId(int $_parent_id): string
    {
        $response = $this->modelSubTask->fetchSubTaskByParentTaskId($_parent_id);
        return ResponseDto::json($response, 200);
    }

    function setSubTask(array $payload): string
    {

        $res = $this->modelSubTask->createSubTask($payload);

        if (is_bool($res)) {
            return $res ? ResponseDto::json("SubTask was created successfully!", 201) :
                ResponseDto::json("An error was encountered while trying to create subtask!", 500);
        }
        return ResponseDto::json("This exact subtask already exist with this task!", 422);
    }


    function editSubTaskStatus(int $status, string $slug): string
    {
        $response = $this->modelSubTask->updateSubTaskStatus($slug, $status);
        return ResponseDto::json($response, 200);
    }


    // Comment

    function getTaskComments(int $_task_id): string
    {
        $response = $this->modelComment->fetchCommentByTask($_task_id);
        return ResponseDto::json($response, 200);
    }

    function makeComment(array $payload): string
    {

        $res = $this->modelComment->insertComment($payload);

        if (is_bool($res)) {
            return $res ? ResponseDto::json("Comment was created successfully!", 201) :
                ResponseDto::json("An error was encountered while trying to create comment!", 500);
        }
        return ResponseDto::json("This comment has already been made by you!", 422);
    }

    // Message

    function getTaskMessages(int $_task_id): string
    {
        $response = $this->modelMessage->fetchMessageByTask($_task_id);
        return ResponseDto::json($response, 200);
    }

    function writeMessage(array $payload): string
    {

        $res = $this->modelMessage->insertMessage($payload);

        if (is_bool($res)) {
            return $res ? ResponseDto::json("Message was created successfully!", 201) :
                ResponseDto::json("An error was encountered while trying to add the message!", 500);
        }
        return ResponseDto::json("This message has already been made by you!", 422);
    }
}
