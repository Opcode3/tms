<?php

    namespace app\dto;

use app\utils\Validation;

    class UserDto{

        private $data;
        private $validationStatus = false;

        function __construct(array $userInfo)
        {
            $this->validation($userInfo);   
        }

        private function validation(array $user){
            if(
                count($user) == 6 &&
                Validation::isSize($user["username"], 4) &&
                Validation::isEmail($user["email"]) &&
                Validation::isSize($user["country"], 3) &&
                Validation::isSize($user["password"], 5) &&
                Validation::isSize($user["phone"], 5) &&
                (Validation::isSize($user["referredBy"], 5) || $user["referredBy"] == "nil" )
            ){
                $this->data["user_username"] = $user["username"];
                $this->data["user_email"] = $user["email"];
                $this->data["user_password"] = $user["password"];
                $this->data["user_country"] = $user["country"];
                $this->data["user_phone_number"] = $user["phone"];
                $this->data["user_referred_by"] = $user["referredBy"];
                $this->validationStatus = true;
            }
        }

        function isValid(): bool{
            return $this->validationStatus;
        }

        function get():array { return $this->data;}

    }

?>