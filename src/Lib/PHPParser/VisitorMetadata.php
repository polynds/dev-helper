<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Lib\PHPParser;

use PhpParser\Node;

class VisitorMetadata
{
    public bool $hasConstructor = false;

    public ?Node\Stmt\ClassMethod $constructorNode = null;

    public ?bool $hasExtends = null;

    /**
     * The class name of \PhpParser\Node\Stmt\ClassLike.
     */
    public ?string $classLike = null;

    public string $className;

    public function __construct(string $className = '')
    {
        $this->className = $className;
    }
}
