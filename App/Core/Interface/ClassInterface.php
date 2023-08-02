<?php
declare(strict_types=1);

namespace App\Core\Interface;

interface ClassInterface
{
    public function __get($key);
    public function __unset($key);
    public function __call(string $name, array $arguments);
    public static function __callStatic(string $name, array $arguments);
}