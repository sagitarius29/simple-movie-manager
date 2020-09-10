<?php

namespace App\Lib;

class SourcesGenerator
{
    /**
     * @var string
     */
    private $url;
    private $proxyDomain = 'http://proxy.cpanels.us';

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function generateSources(): string
    {
        preg_match('/https?:\/\/(?:www\.)?(?:drive|docs)\.google\.com\/(?:file\/d\/|open\?id=)?([a-z0-9A-Z_-]+)(?:\/.+)?/is', $this->url, $id);

        return file_get_contents( $this->proxyDomain . '/link/?driveId=' . $id[1]);
    }
}
