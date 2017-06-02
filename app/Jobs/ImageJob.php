<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var string
     */
    private $fileName;
    /**
     * @var string
     */
    private $entity;

    private $object;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileName, $entity, $object)
    {
        $this->fileName = $fileName;
        $this->entity = $entity;
        $this->object = $object;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $thumbs = config('image.thumbs');
        File::makeDirectory(public_path('uploads/countries/'.$this->object->id));
        foreach ($thumbs as $key => $format) {
            $savedpath = public_path('uploads/countries/'.$this->object->id.'/'.$key.'_'.pathinfo($this->fileName, PATHINFO_FILENAME).'.jpg');
            Image::make($this->fileName)
                ->fit($format, $format)
                ->save($savedpath);
        }
    }
}
