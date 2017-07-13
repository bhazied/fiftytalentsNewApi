<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class avatarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private  $fileName;

    private $path;

    private $object;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileName, $path, $object)
    {
        $this->fileName = $fileName;
        $this->path = $path;
        $this->object = $object;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $thumbs = config('image.resolutions');
        $ext =  pathinfo($this->path.DIRECTORY_SEPARATOR.$this->fileName, PATHINFO_EXTENSION);
        //dd($this->path.DIRECTORY_SEPARATOR.$this->fileName);
        foreach ($thumbs as $key => $resolution){
            $savedPath = $this->path.DIRECTORY_SEPARATOR.$this->object->id.'-'.substr($key,0,1).'.'.$ext;
            Image::make($this->path.DIRECTORY_SEPARATOR.$this->fileName)
                ->fit($resolution[0], $resolution[1])
                ->save($savedPath);
        }
        File::delete($this->path.DIRECTORY_SEPARATOR.$this->fileName);
    }
}
