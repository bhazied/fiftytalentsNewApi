<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',
    'path' => 'uploads',
    'real_path' => 'data',
    'resolutions' => [
        'small' => array('150', '150'),
        'medium' => array('300', '300'),
        'large' => array('500', '500')
        ],

);
