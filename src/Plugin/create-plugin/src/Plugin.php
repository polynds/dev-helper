<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Plugin\CreatePlugin;

class Plugin
{
    protected string $path;

    protected string $pluginName;

    protected string $composerName;

    protected string $composerDesc;

    protected string $composerLicense;

    protected string $authorName;

    protected string $authorEmail;

    protected string $NameSpace;

    public function __construct()
    {
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function getPluginName(): string
    {
        return $this->pluginName;
    }

    public function setPluginName(string $pluginName): self
    {
        $this->pluginName = $pluginName;
        return $this;
    }

    public function getComposerName(): string
    {
        return $this->composerName;
    }

    public function setComposerName(string $composerName): self
    {
        $this->composerName = $composerName;
        return $this;
    }

    public function getComposerDesc(): string
    {
        return $this->composerDesc;
    }

    public function setComposerDesc(string $composerDesc): self
    {
        $this->composerDesc = $composerDesc;
        return $this;
    }

    public function getComposerLicense(): string
    {
        return $this->composerLicense;
    }

    public function setComposerLicense(string $composerLicense): self
    {
        $this->composerLicense = $composerLicense;
        return $this;
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function setAuthorName(string $authorName): self
    {
        $this->authorName = $authorName;
        return $this;
    }

    public function getAuthorEmail(): string
    {
        return $this->authorEmail;
    }

    public function setAuthorEmail(string $authorEmail): self
    {
        $this->authorEmail = $authorEmail;
        return $this;
    }

    public function getNameSpace(): string
    {
        return $this->NameSpace;
    }

    public function setNameSpace(string $NameSpace): self
    {
        $this->NameSpace = $NameSpace;
        return $this;
    }
}
