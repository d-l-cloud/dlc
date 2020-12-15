<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Intervention\Image\Facades\Image;

class ResizeUploadedImage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $image = Image::make($event->path());

        if($image->width() <= 1100) {
            return;
        }
        $image->resize(1000, null, function ($constraint) {
            $constraint->aspectRatio();
        })
            ->save();
    }
}
