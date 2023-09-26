<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Lib\Exception;

class PathNotFoundException extends \Exception
{
    public function __construct(string $path)
    {
        parent::__construct(sprintf('Path %s does not exist', $path));
    }
}
