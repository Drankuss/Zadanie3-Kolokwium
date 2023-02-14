<?php

namespace Apsl\Session;


class Session
{
    const DEFAULT_SESSION_NAME = 'session';
    const DEFAULT_SESSION_LIFETIME = 60 * 60;

    protected string $name;
    protected int $lifetime;

    public function __construct(string $name = self::DEFAULT_SESSION_NAME, int $lifetime = self::DEFAULT_SESSION_LIFETIME)
    {
        $this->name = $name;
        $this->lifetime = $lifetime;

        $this->start();
    }

    public function start(bool $forceCreateNew = false)
    {
        if ($forceCreateNew && (session_status() === PHP_SESSION_ACTIVE)) {
            session_destroy();
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_name($this->name);
            session_start([
                'gc_maxlifetime' => $this->lifetime,
                'cookie_lifetime' => $this->lifetime
            ]);
        }
    }

    public function destroy()
    {
        session_destroy();
    }

    public function getValue(string $name)
    {
        return ($_SESSION[$name] ?? null);
    }

    public function setValue(string $name, $value)
    {
        $_SESSION[$name] = $value;
    }
}
