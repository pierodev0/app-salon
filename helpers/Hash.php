<?php
namespace Helpers;
class Hash {
    public static function make($password){
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function check($password, $hash){
        return password_verify($password, $hash);
    }
}