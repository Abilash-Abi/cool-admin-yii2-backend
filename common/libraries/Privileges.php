<?php
namespace common\libraries;

class Privileges {
    public static function permissions() {
        return [
            MANAGE_USER_ROLES  => ['view','add','edit','delete'],
            MANAGE_ADMIN_USERS  => ['view','add','edit','delete'],
        ];
    }
}