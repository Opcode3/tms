<?php

namespace app\utils;

class ImageHandler
{

    private $base_url = "../../public/resources/";
    private $valid_extension = array("png", "jpeg", "jpg");
    private $dest_url = null;
    private $set = false;

    function __construct($file)
    {
        $this->base_url = $this->base_url;

        if (!file_exists($this->base_url)) {
            mkdir($this->base_url, 0777, true);
        }
        $this->imageProcessor($file["tmp_name"], $file["name"]);
    }

    function getImageURI()
    {
        return $this->dest_url;
    }

    function isSet()
    {
        return $this->set;
    }

    // private function
    private function getImageExtension($image_file)
    {
        return strtolower(pathinfo($image_file, PATHINFO_EXTENSION));
    }

    private function generateName(): string
    {
        return "resource_" . uniqid(time());
    }

    private function imageProcessor($tmp, $file): void
    {
        $file_extension = $this->getImageExtension($file);
        $target_file = $this->base_url . "/" . $this->generateName() . "." . $file_extension;
        if (in_array($file_extension, $this->valid_extension)) {
            if (move_uploaded_file($tmp, $target_file)) {
                $this->dest_url = $target_file;
                $this->set = true;
            }
        }
    }
}
