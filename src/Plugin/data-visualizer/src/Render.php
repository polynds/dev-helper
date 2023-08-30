<?php

namespace DevHelper\Plugin\DataVisualizer;

use DevHelper\Plugin\DataVisualizer\Canvas\GD;
use DevHelper\Plugin\DataVisualizer\Canvas\Draw\DrawInterface;
use DevHelper\Plugin\DataVisualizer\Canvas\Draw\DrawMode;
use DevHelper\Plugin\DataVisualizer\Canvas\Draw\Random;
use DevHelper\Plugin\DataVisualizer\Canvas\Draw\Sequence;

class Render
{
    protected int $width = 300;

    protected int $height = 300;

    protected ?DataObject $object = null;

    protected ?string $outputPath = null;

    //    protected DrawInterface $pencil;

    public function __construct()
    {
        //        $this->pencil = new Random();
    }

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

    //    public function setPencil(string $drawMode): Render
    //    {
    //        switch ($drawMode) {
    //            case DrawMode::SEQUENCE:
    //                $this->pencil = new Sequence();
    //                break;
    //            case DrawMode::RANDOM:
    //                $this->pencil = new Random();
    //                break;
    //            default:
    //                throw new InvalidArgumentException("Unknown draw mode: $drawMode");
    //        }
    //
    //        return $this;
    //    }


    public function build(): string
    {
        $canvas = new GD();
        $canvas->init($this->width, $this->height);
        //        $canvas->pencil($this->pencil);
        $canvas->draw($this->object);
        return $canvas->output($this->outputPath);
    }
}
