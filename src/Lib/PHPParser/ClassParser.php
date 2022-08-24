<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\PHPParser;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\ParserFactory;

class ClassParser
{
    protected \PhpParser\Parser  $astParser;

    public function __construct()
    {
        $parserFactory = new ParserFactory();
        $this->astParser = $parserFactory->create(ParserFactory::ONLY_PHP7);
    }

    public function parse(string $code): ?array
    {
        return $this->astParser->parse($code);
    }

    public function parseClassByStmts(array $stmts): array
    {
        $data = [];
        foreach ($stmts as $stmt) {
            if ($stmt instanceof Namespace_ && $stmt->name) {
                $namespace = $stmt->name->toString();
                $className = $interface = '';
                foreach ($stmt->stmts as $node) {
                    if ($node instanceof Class_ && $node->name) {
                        $className = $node->name->toString();
                        break;
                    }
                    if ($node instanceof Interface_ && $node->name) {
                        $interface = $node->name->toString();
                        break;
                    }
                }

                if (empty($className) && empty($interface)) {
                    continue;
                }

                $data[$namespace][] = [
                    'namespace' => $namespace,
                    'class' => $className,
                    'interface' => $interface,
                ];
            }
        }
        return $data;
    }
}
