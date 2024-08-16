<?php
    namespace app\utils;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

    class JWTHandler{

        private static $sec_key = 'iLoveJesus';
        private static $hash_code = 'HS256';


        public static function decodeHashCode(string $jwtHashCode){
            $decodeResult = JWT::decode($jwtHashCode, new Key(self::$sec_key, self::$hash_code));
            $resultInArray = json_decode(json_encode($decodeResult), true);
            return $resultInArray;
        }

        public static function encodePayload(array $hashData){
            $encode = JWT::encode($hashData, self::$sec_key, self::$hash_code);
            return $encode;
        }

    }

?>