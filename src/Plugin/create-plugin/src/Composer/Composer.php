<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Plugin\CreatePlugin\Composer;

class Composer
{
    public string $name;

    public string $description = '';

    public string $license = '';

    /**
     * @var string[]
     */
    public array $keywords = [];

    /**
     * @var string[]
     */
    public array $require = [];

    /**
     * @var Authors[]
     */
    public array $authors = [];

    /**
     * psr-4.
     */
    public array $autoload = [];

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setLicense(string $license): self
    {
        $this->license = $license;
        return $this;
    }

    /**
     * @param string[] $keywords
     */
    public function setKeywords(array $keywords): self
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * @param string[] $require
     */
    public function setRequire(array $require): self
    {
        $this->require = $require;
        return $this;
    }

    /**
     * @param Authors[] $authors
     */
    public function setAuthors(array $authors): self
    {
        $this->authors = $authors;
        return $this;
    }

    public function setAutoload(string $namespace, string $path = 'src/'): self
    {
        $namespace = str_replace('\\', '\\', $namespace);
        $namespace .= '\\';
        $this->autoload['psr-4'][$namespace] = $path;
        return $this;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'license' => $this->license,
            'keywords' => $this->keywords,
            'require' => $this->require,
            'authors' => $this->authors,
            'autoload' => $this->autoload,
        ];
    }
}
