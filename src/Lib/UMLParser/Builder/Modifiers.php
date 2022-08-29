<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\UMLParser\Builder;

class Modifiers
{
    public const NONE = 0;

    public const MODIFIER_PUBLIC = 1;

    public const MODIFIER_PROTECTED = 2;

    public const MODIFIER_PRIVATE = 4;

    public const MODIFIER_STATIC = 8;

    public const MODIFIER_ABSTRACT = 16;

    public const MODIFIER_FINAL = 32;

    public const MODIFIER_READONLY = 64;

    private int $value = 0;

    public function __construct(int $value = 0)
    {
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function isFinal(): bool
    {
        return (bool) ($this->value & self::MODIFIER_FINAL);
    }

    public function isPublic(): bool
    {
        return (bool) ($this->value & self::MODIFIER_PUBLIC);
    }

    public function isProtected(): bool
    {
        return (bool) ($this->value & self::MODIFIER_PROTECTED);
    }

    public function isPrivate(): bool
    {
        return (bool) ($this->value & self::MODIFIER_PRIVATE);
    }

    public function isStatic(): bool
    {
        return (bool) ($this->value & self::MODIFIER_STATIC);
    }

    public function isAbstract(): bool
    {
        return (bool) ($this->value & self::MODIFIER_ABSTRACT);
    }

    public function isReadonly(): bool
    {
        return (bool) ($this->value & self::MODIFIER_READONLY);
    }
}
