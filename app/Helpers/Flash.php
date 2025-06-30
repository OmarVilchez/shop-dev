<?php

namespace App\Helpers;

class Flash
{
    /**
     * Flash a success message.
     */
    public static function success(string $message): void
    {
        session()->flash('success', $message);
    }

    /**
     * Flash an error message.
     */
    public static function error(string $message): void
    {
        session()->flash('error', $message);
    }

    /**
     * Flash a warning message.
     */
    public static function warning(string $message): void
    {
        session()->flash('warning', $message);
    }

    /**
     * Flash an info message.
     */
    public static function info(string $message): void
    {
        session()->flash('info', $message);
    }
}
