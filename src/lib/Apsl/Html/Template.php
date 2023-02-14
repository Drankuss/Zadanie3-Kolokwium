<?php

namespace Apsl\Html;


class Template
{
    protected string $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function render(array $data = [])
    {
        ob_start();

        foreach ($data as $varName => $varValue) {
            $$varName = $varValue;
        }

        include $this->file;

        return ob_get_clean();
    }
}
