<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\Console\Command\CreatePlugin\Composer;

class Composer
{
    protected string $name;

    protected string $description = '';

    protected string $license = '';

    /**
     * @var string[]
     */
    protected array $keywords = ['php'];

    /**
     * @var string[]
     */
    protected array $require = [
        'php' => '>=7.4',
    ];

    /**
     * @var Authors[]
     */
    protected array $authors = [];

    /**
     * psr-4.
     */
    protected array $autoload = [];

    /**
     * extra.
     */
    protected array $extra = [];

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

    public function setKeywords(string $keywords): self
    {
        $this->keywords[] = $keywords;
        return $this;
    }

    public function setRequire(string $key, string $require): self
    {
        $this->require[$key] = $require;
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

    public function setExtra(string $namespace): self
    {
        $this->extra['devHelper']['config'] = str_replace('\\', '\\', $namespace . '\ConfigProvider');
        return $this;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'license' => $this->license,
            'keywords' => $this->keywords,
            'require' => $this->require,
            'authors' => $this->authors,
            'autoload' => $this->autoload,
            'extra' => $this->extra,
        ];
    }
}
