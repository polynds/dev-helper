<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
function getFileName(): array
{
    $f = fopen('./11', 'r');
    $data = [];
    while ($line = fgets($f)) {
        $data[] = trim($line);
    }
    var_dump($data);
    fclose($f);
    return $data;
}

$names = getFileName();
var_dump($names);

function moveFile(array $names, string $src, string $desc)
{
    if (!is_dir($src)) {
        return false;
    }
    if (!is_dir($desc)) {
        mkdir($desc);
    }
    $f = scandir($src);
    foreach ($f as $file) {
        if ($file != '.' && $file != '..') {
            $s1 = explode('(', $file);
            $s2 = explode(')', $s1[1]);
            $newName = $names[$s2[0]] . $s2[1];
            $to = $desc . DIRECTORY_SEPARATOR . $newName;
            $from = $src . DIRECTORY_SEPARATOR . $file;
            if (!copy($from, $to)) {
                echo "failed to copy $from...\n";
            }
//            file_put_contents($p1, file_get_contents($p2));
            var_dump('完成移动文件：' . $from . '到' . $to);
        }
    }
}

moveFile($names, 'D:\course\blender', 'D:\course\threeJSJourney');
