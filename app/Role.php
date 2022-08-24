<?php


namespace App;


class Role
{
    const ADMIN = 'Admin';
    const SUPER_ADMIN = 'Super admin';

    public static function roles()
    {
        return [self::ADMIN, self::SUPER_ADMIN];
    }
}