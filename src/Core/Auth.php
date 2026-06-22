<?php

namespace Src\Core;

class Auth
{
    /**
     * Temporary role simulation
     * Later this will come from JWT / session / database
     */
    public static function userRole(): string
    {
        return "admin";
    }

    public static function isAdmin(): bool
    {
        return self::userRole() === "admin";
    }

    public static function isManager(): bool
    {
        return self::userRole() === "manager";
    }

    public static function isAnalyst(): bool
    {
        return self::userRole() === "analyst";
    }
}
