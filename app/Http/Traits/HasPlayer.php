<?php

namespace App\Http\Traits;

use App\Lib\Packer\Packer;
use App\Lib\SourcesGenerator;

trait HasPlayer
{
    public function toPlayer(string $url, string $cover)
    {
        $sources = false;

        if(strpos($url, 'drive.google.com') !== false) {
            $url = (new SourcesGenerator($url))->generateSources();
            $sources = true;
        } elseif(!preg_match('/\.mp4$/i', $url)) {
            return redirect($url);
        }

        $packer = $this->packer($url, $cover, $sources);

        return view('layouts.videoplayer')->with([
            'packer' => $packer
        ]);
    }

    protected function packer(string $videoUrl, string $image, bool $sources)
    {
        $data = "const player = jwplayer('player').setup({
    ".$this->sourcesOrFile($videoUrl, $sources).",
    image: '".$image."',
    type: 'mp4',
    width: '100%',
    aspectratio: '16:9',
    stretching: 'fill',
    primary: 'html5',
    preload: 'auto',
    autostart: false,
  });";
        $packer = new Packer($data, 'Normal', true, false, true);
        return $packer->pack();
    }

    protected function sourcesOrFile($videoUrl, $sources)
    {
        if($sources) {
            return 'sources: '.$videoUrl;
        }

        return "file: '".$videoUrl."'";
    }
}
