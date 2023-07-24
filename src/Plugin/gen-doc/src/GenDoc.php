<?php

namespace DevHelper\Plugin\GenDoc;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class GenDoc
{

    protected string $path;

    /**
     * @param false|mixed|string|null $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    public function build()
    {
        $this->scan($this->path);
    }

    protected function scan(string $path)
    {
        $files = $this->getFilesInPath($path);
        var_dump($files);
        $docs = [];
        foreach ($files as $file) {
            $docComments = $this->getDocCommentsFromFile($file);

            foreach ($docComments as $docComment) {
                $docCommentContent = $this->parseDocComment($docComment);

                // 根据注释内容补充代码逻辑
                $docs[] = $this->addCodeBasedOnDocComment($docCommentContent);
            }
        }
    }

    private function getFilesInPath(string $path): array
    {
        $files = [];

        // 使用递归扫描指定路径下的所有文件
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                // 过滤/vendor
                if (str_contains($file->getPathname(), './vendor')) {
                    continue;
                }
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }

    private function getDocCommentsFromFile(string $file): array
    {
        $docComments = [];
        $tokens = token_get_all(file_get_contents($file));

        foreach ($tokens as $index => $token) {
            if ($token[0] === T_DOC_COMMENT) {
                $docComments[] = $token[1];
            }
        }

        return $docComments;
    }

    private function parseDocComment(string $docComment): array
    {
        // 解析注释内容，获取@doc标签的值
        preg_match_all('/@doc\s+(.+)/', $docComment, $matches);

        return $matches[1];
    }

    private function addCodeBasedOnDocComment(array $docCommentContent): array
    {
        // 根据注释内容补充代码逻辑
        // ...

        return [];
    }


    // 美化输出
    private function buttyCode(string $code): string
    {
        return $code;
    }


}
