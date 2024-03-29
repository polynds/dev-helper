<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Lib\PHPParser;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Property;
use PhpParser\ParserFactory;

class ClassParser
{
    protected \PhpParser\Parser $astParser;

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
        var_dump($stmts);
        $data = [];
        foreach ($stmts as $stmt) {
            if ($stmt instanceof Namespace_) {
                $classes = $interfaces = [];
                //                dd($stmt->name->toString());
                $namespaceName = $stmt->name->toString();
                $namespace = [
                    'name' => $namespaceName,
                ];
                foreach ($stmt->stmts as $node) {
                    if ($node instanceof Class_) {
                        if ('DotGitIgnore' == $node->name->name) {
                            var_dump($stmt);
                            die();
                        }
                        $constants = $propertes = $methods = [];
                        foreach ($node->stmts as $nodeStmts) {
                            if ($nodeStmts instanceof ClassConst) {
                                foreach ($nodeStmts->consts as $const) {
                                    $constants[] = [
                                        'flags' => $nodeStmts->flags,
                                        'name' => $const->name->name,
                                        'value' => $const->value->value,
                                    ];
                                }
                            }
                            if ($nodeStmts instanceof Property) {
                                $propertes[] = [
                                    'flags' => $nodeStmts->flags,
                                    'name' => $nodeStmts->props[0]->name->toString(),
                                    'type' => $nodeStmts->type->name ?? '',
                                ];
                            }
                            if ($nodeStmts instanceof ClassMethod) {
                                $params = [];
                                foreach ($nodeStmts->getParams() as $param) {
                                    $params[] = [
                                        'type' => $param->type->name ?? '',
                                        'name' => $param->var->name,
                                    ];
                                }
                                $methods[] = [
                                    'flags' => $nodeStmts->flags,
                                    'name' => $nodeStmts->name->toString(),
                                    'params' => $params,
                                ];
                            }
                        }

                        $classes[] = [
                            'name' => $node->name->toString(),
                            'constants' => $constants,
                            'propertes' => $propertes,
                            'methods' => $methods,
                        ];
                    }
                    if ($node instanceof Interface_) {
                        $constants = $methods = [];
                        foreach ($node->stmts as $nodeStmts) {
                            if ($nodeStmts instanceof ClassConst) {
                                foreach ($nodeStmts->consts as $const) {
                                    $constants[] = [
                                        'flags' => $nodeStmts->flags,
                                        'name' => $const->name->name,
                                        'value' => $const->value->value,
                                    ];
                                }
                            }

                            if ($nodeStmts instanceof ClassMethod) {
                                $params = [];
                                foreach ($nodeStmts->getParams() as $param) {
                                    $params[] = [
                                        'type' => $param->type->name ?? '',
                                        'name' => $param->var->name,
                                    ];
                                }
                                $methods[] = [
                                    'flags' => $nodeStmts->flags,
                                    'name' => $nodeStmts->name->toString(),
                                    'params' => $params,
                                ];
                            }
                        }

                        $interfaces[] = [
                            'name' => $node->name->toString(),
                            'constants' => $constants,
                            'methods' => $methods,
                        ];
                    }
                }

                if (empty($classes) && empty($interfaces)) {
                    continue;
                }

                $data[$namespaceName][] = [
                    'namespace' => $namespace,
                    'classes' => $classes,
                    'interfaces' => $interfaces,
                ];
            }
        }
        return $data;
    }
}
