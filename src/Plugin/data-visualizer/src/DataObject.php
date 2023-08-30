<?php

namespace DevHelper\Plugin\DataVisualizer;

class DataObject
{
    protected string $data = "";
    protected array $imageData = [];

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData(string $data): DataObject
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getImageData(): array
    {
        return $this->imageData;
    }

    /**
     * @param array $imageData
     * @return DataObject
     */
    public function setImageData(array $imageData): DataObject
    {
        $this->imageData = $imageData;
        return $this;
    }


    public function feed(): DataObject
    {
        $len = strlen($this->data);
        for ($i = 0; $i < $len; $i++) {
            $this->imageData[$i] = ord($this->data[$i]);
        }
        return $this;
    }
}
