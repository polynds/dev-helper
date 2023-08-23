<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Lib\UMLParser\Builder;

use DevHelper\Lib\UMLParser\Builder;

abstract class Definition implements Builder
{
    public function addStmts(array $stmts)
    {
        foreach ($stmts as $stmt) {
            $this->addStmt($stmt);
        }

        return $this;
    }

    abstract public function addStmt($stmt);
}
