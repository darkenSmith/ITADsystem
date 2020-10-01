<?php


namespace App\Helpers;

/**
 * Interface TemplateInterface
 * @package App\Helpers
 */
interface TemplateInterface
{
    public function view(string $template, array $vars = []): void;
}
