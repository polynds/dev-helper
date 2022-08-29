#!/usr/bin/env php
<?php
/**
 * happy coding!!!
 */

var_dump(gettype(DevHelper\Lib\UMLParser\BuilderFactory::class));

$hosts = '';
$urls = [
        'www.google.com.hk',
        'www.google.cn',
        'www.google.com',
    'alive.github.com', 'live.github.com', 'github.githubassets.com', 'central.github.com', 'desktop.githubusercontent.com', 'assets-cdn.github.com', 'camo.githubusercontent.com', 'github.map.fastly.net', 'github.global.ssl.fastly.net', 'gist.github.com', 'github.io', 'github.com', 'github.blog', 'api.github.com', 'raw.githubusercontent.com', 'user-images.githubusercontent.com', 'favicons.githubusercontent.com', 'avatars5.githubusercontent.com', 'avatars4.githubusercontent.com', 'avatars3.githubusercontent.com', 'avatars2.githubusercontent.com', 'avatars1.githubusercontent.com', 'avatars0.githubusercontent.com', 'avatars.githubusercontent.com', 'codeload.github.com', 'github-cloud.s3.amazonaws.com', 'github-com.s3.amazonaws.com', 'github-production-release-asset-2e65be.s3.amazonaws.com', 'github-production-user-asset-6210df.s3.amazonaws.com', 'github-production-repository-file-5c1aeb.s3.amazonaws.com', 'githubstatus.com', 'github.community', 'github.dev', 'collector.github.com', 'pipelines.actions.githubusercontent.com', 'media.githubusercontent.com', 'cloud.githubusercontent.com', 'objects.githubusercontent.com', 'vscode.dev',
];
foreach ($urls as $url) {
    $ip = gethostbyname($url);
    if (! empty($ip)) {
        $hosts .= sprintf('%s %s', $ip, $url) . PHP_EOL;
        var_dump(sprintf('%s %s', $ip, $url));
    }
}

file_put_contents('urls.txt', $hosts);
var_dump(11);
