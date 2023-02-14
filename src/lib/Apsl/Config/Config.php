<?php

namespace Apsl\Config;

class Config
{
    protected array $config = [];

    public function __construct(string $file)
    {
        $this->config = require $file;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function getValue(string $name)
    {
        return ($this->config[$name] ?? null);
    }
}
