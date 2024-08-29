<?php

namespace app\utils;

class Helper
{



    public static function getInitialNames($name)
    {
        $names = explode(' ', $name);
        if (count($names) >= 2) {
            return substr($names[0], 0, 1) . substr($names[1], 0, 1);
        }
        return substr($names[0], 0, 2);
    }


    public static function getPercentage($total, $value)
    {
        return (int)  (($value / $total) * 100);
    }


    public static function loadImage($url)
    {
        if ($url != null && strlen(trim($url)) > 8) {
            // TODO: also check if the image link isn't broken
            return $url;
        }
        return "../static/images/no-image.png";
    }

    public static function formatDate($timestamp)
    {
        $_date = strtotime($timestamp);

        return date('d-M', $_date);
    }

    public static function getTaskStatus($status)
    {
        switch ((int) $status) {
            case 1:
                return "In Progress";
            case 2:
                return "Completed";
            case 3:
                return "Finished";
            default:
                return "Unstarted";
        }
    }

    public static function getTaskAction($status)
    {
        switch ((int) $status) {
            case 0:
                return "In-Progress";
            case 1:
                return "Completed";
            case 3:
                return "Finished";
            default:
                return "In-Progress";
        }
    }


    static function convertTime($time, $ago = true)
    {
        // REDO:: Leter
        if ($ago) {
            $date = strtotime($time);
            return date('d', $date) . " days";
        }
    }







    // Remover Down Part

    function getEmailOTP()
    {
        $randomNumber = rand(100000, 999999);
        return $randomNumber;
    }

    public static function getFirstImage($urls)
    {
        if (isset($urls) && is_string($urls) && strlen(trim($urls)) > 10) {
            return explode(",", $urls)[0];
        }
        return "../../assets/images/no-image.png";
    }

    public static function getImages($urls)
    {
        if (isset($urls) && is_string($urls) && strlen(trim($urls)) > 10) {
            return explode(",", $urls);
        }
        return [
            "../../assets/images/no-image.png"
        ];
    }

    public static function setDesc(array $data)
    {
        if (count($data) > 0) {
            $base = "";
            foreach ($data as $key => $p) {
                $base .= "<p>" . ucfirst($p) . "</p>";
            }
            return $base;
        }
        return "<p></p>";
    }
}
