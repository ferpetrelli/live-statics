<?php

namespace Petrelli\LiveStatics\Traits\Twill;


/**
 *
 * Used to emulate Twill functions to yield image URL's
 *
 * The trait used in models is HasImage. Please check Twill's codebase
 * for more information
 *
 */

trait HasImages
{


    // Memoize image URL one time per call
    protected $memory = [];



    /**
     *
     * Image function extracted from Twill HasImage trait.
     *
     * It will just ignore all parameters except [width], [height]
     *
     */
    public function image($role = "main", $crop = "default", $params = [], $has_fallback = false, $cms = false, $media = null)
    {

        if (isset($this->memory['images'][$role][$crop])) {
            if (!$this->memory['images'][$role][$crop]) {
                return false;
            }
        } else {

            $width  = $params['width']  ?? config('live-statics.twill.default_width');
            $height = $params['height'] ?? config('live-statics.twill.default_height');

            $this->memory['images'][$role][$crop] = app('faker')->imageUrl($width, $height, $params['extra'] ?? null);

        }

        return $this->memory['images'][$role][$crop];

    }

    /**
     *
     *
     * Twill function to check if we have an image. Here we use memoization
     * to disable certain images assigning them a null value using
     * `disableImage` and `disableImageRandomly`
     *
     */
    public function hasImage($role = "main", $crop = "default")
    {

        if (isset($this->memory['images'][$role][$crop])) {
            return !empty($this->memory['images'][$role][$crop]);
        } else {
            return true;
        }

    }


    /**
     *
     * Disable Image for a specific role and crop
     *
     */
    public function disableImage($role, $crop)
    {

        $this->memory['images'][$role][$crop] = false;

        return $this;

    }


    /**
     *
     * Randomly disable an Image for a specific role and crop
     * Use this one when you don't need to be deterministic9
     *
     */
    public function disableImageRandomly($role, $crop, $percentage = 50)
    {

        if ($percentage <= rand(0, 100)) {
            $this->disableImage($role, $crop);
        }

        return $this;

    }


    /**
     *
     * Return an array with all image information
     *
     */
    public function imageAsArray($role, $crop = "default", $params = [], $media = null)
    {

        return [
            'src'     => $this->image(...func_get_args()),
            'width'   => $params['width']  ?? config('live-statics.twill.default_width'),
            'height'  => $params['height'] ?? config('live-statics.twill.default_height'),
            'alt'     => $this->imageCaption($role, $media),
            'caption' => $this->imageCaption($role, $media),
        ];

    }


    /**
     *
     * Return image caption
     *
     */
    public function imageCaption($role, $media = null)
    {

        return app('faker')->sentence(rand(5,10));

    }


    /**
     *
     * Return image alternative text
     *
     */
    public function imageAltText($role, $media = null)
    {

        return app('faker')->sentence(rand(5,10));

    }


    /**
     *
     * Return an image low quality placeholder
     *
     */
    public function lowQualityImagePlaceholder($role, $crop = 'default')
    {

        return 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';

    }


}
