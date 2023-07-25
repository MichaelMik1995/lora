<?php
declare(strict_types=1);

namespace App\Core\Interface;

interface MiddlewareInterface
{
    public function process();
    public function error(): Array;
    public function return(): Bool;
}