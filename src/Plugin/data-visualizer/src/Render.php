<?php

namespace DevHelper\Plugin\DataVisualizer;

class Render
{
    protected int $width = 0;

    protected int $height = 0;

    protected DataObject $object;

    protected ?string $outputPath = null;

    /**
     * @param int $width
     * @return Render
     */
    public function setWidth(int $width): Render
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @param int $height
     * @return Render
     */
    public function setHeight(int $height): Render
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @param string|null $outputPath
     * @return Render
     */
    public function setOutputPath(?string $outputPath): Render
    {
        $this->outputPath = $outputPath;
        return $this;
    }

    /**
     * @param DataObject $object
     * @return Render
     */
    public function setObject(DataObject $object): Render
    {
        $this->object = $object;
        return $this;
    }


    public function build(): string
    {
        $canvas = new GD();
        $canvas->init($this->width, $this->height);
        $canvas->draw($this->object);
        return $canvas->output($this->outputPath);
    }
}
