<?php
declare(strict_types=1);

namespace App\Core\Interface;

/**
 *
 * @author ctyrka
 */
interface InstanceInterface 
{
    public static function instance();
    public function getInstanceId();
}
