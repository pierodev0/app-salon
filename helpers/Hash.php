<?php
namespace Helpers;
class Hash {
    public static function make($password){
        return password_hash($password, PASSWORD_BCRYPT);
    }
}