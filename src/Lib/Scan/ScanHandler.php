<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\Scan;

class ScanHandler
{
    protected string $dirPath;

    public function __construct(string $dirPath)
    {
        $this->dirPath = $dirPath;
    }

    public function scan(string $path = '')
    {
        $result = [];
        $hander = scandir($path);
        foreach ($hander as $key => $v) {
            if (in_array($v, ['.', '..'])) {
                continue;
            }
            $path = $path . DIRECTORY_SEPARATOR . $v;
            if (is_dir($path)) {
                $result[$key]['type'] = 'dir';
                $result[$key]['name'] = $v;
                $result[$key]['files'] = $this->scan($path);
            } else {
                $result[$key] = [
                    'type' => 'file',
                    'name' => $v,
                    'path' => $path,
                ];
            }
        }
        return $result;
    }
}
