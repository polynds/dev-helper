<?php

namespace DevHelper\Plugin\DataVisualizer;

ini_set('memory_limit', '2048M');

class DataVisualizer
{
    protected int $width = 100;
    protected int $height = 100;
    protected int $channels = 4; // RGBA

    protected $image;

    public function __construct(
        protected string $data
    ) {
        $this->image = imagecreatetruecolor($this->width, $this->height);
    }

    /**
     * 使用图形库将数据转换为图像
     */
    public function generate(): static
    {
        $data = $this->feed();
        $this->render($data);
        return $this;
    }


    protected function feed(): array
    {
        $len = strlen($this->data);
        $imageData = array_fill(0, $this->width * $this->height * $this->channels, null);

        for ($i = 0; $i < $len; $i++) {
            $imageData[$i] = ord($this->data[$i]);
        }
        return $imageData;
    }

    protected function render(array $imageData): void
    {
        $i = 0;
        for ($y = 0; $y < $this->height; $y++) {
            for ($x = 0; $x < $this->width; $x++) {
                $rgba = array();
                $rgba['red'] = $imageData[$i + 0] ?? rand(0, 255);
                $rgba['green'] = $imageData[$i + 1] ?? rand(0, 255);
                $rgba['blue'] = $imageData[$i + 2] ?? rand(0, 255);
                $i += 3;
                $color = imagecolorallocate($this->image, $rgba['red'], $rgba['green'], $rgba['blue']);
                imagesetpixel($this->image, $x, $y, $color);
            }
        }
    }

    public function save(?string $path = null): void
    {
        $file = $path ?? md5(time()) . '.png';
        imagepng($this->image, $file);
    }
}
