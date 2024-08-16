<?php

namespace app\services\impl;

interface ProjectServiceImpl
{
    function setProject(array $data): string;
    function getProjects(): string;
    // function getProjectsCount(): int;
    function getProjectBySlug(string $slug): string;
    // function editProject(array $data): string;
    function removeProject(string $slug): string;
}
