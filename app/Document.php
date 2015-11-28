<?php

namespace App;

use Storage;
use Config;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return $this->getFileUrl($this->attributes['file']);
    }

    public function requestPreview()
    {
        $fp = app('FilePreviews');

        $options = [
            'metadata' => ['checksum', 'ocr'],
            'data' => [
                'document_id' => $this->attributes['id']
            ]
        ];

        $url = $this->getFileUrl($this->attributes['file']);

        return $fp->generate($url, $options);
    }

    private function getFileUrl($key) {
        $s3 = Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $bucket = Config::get('filesystems.disks.s3.bucket');

        $command = $client->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key' => $key
        ]);

        $request = $client->createPresignedRequest($command, '+20 minutes');

        return (string) $request->getUri();
    }
}
