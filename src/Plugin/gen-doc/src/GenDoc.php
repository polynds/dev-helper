<?php

namespace DevHelper\Plugin\GenDoc;

class GenDoc
{

    /**
     * @param false|mixed|string|null $path
     */
    public function __construct($path)
    {
    }

    public function build()
    {

    }

    public function scan(string $path)
    {
        $files = $this->getFilesInPath($path);

        foreach ($files as $file) {
            $docComments = $this->getDocCommentsFromFile($file);

            foreach ($docComments as $docComment) {
                $docCommentContent = $this->parseDocComment($docComment);

                // 根据注释内容补充代码逻辑
                $this->addCodeBasedOnDocComment($docCommentContent);
            }
        }
    }

    private function getFilesInPath(string $path): array
    {
        $files = [];

        // 使用递归扫描指定路径下的所有文件
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

        foreach ($iterator as $file) {
            if ($file->isFile()) {
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

    private function addCodeBasedOnDocComment(array $docCommentContent)
    {
        // 根据注释内容补充代码逻辑
        // ...
    }

}