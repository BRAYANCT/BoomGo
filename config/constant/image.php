<?php

return [

    'allowed_extensions'=> ['jpg','jpeg', 'png', 'gif'],
    'max_size'=>1024*10,
    'max_image_upload'=> 54,// imagenes a cargar en la galeria

    'quality'=>50,
    'max_width'=>1200,
    'max_height'=>1200,

    'storage_public' => 'public',

    'user' => [
        'storage'=>'profile',
        'width'=>300,
        'height'=>300,
        'default'=>''
    ],

    'business' => [
        'storage'=>'business',
        'width'=>300,
        'height'=>300,
        'default'=>''
    ],

    'category' => [
        'storage'=>'category',
        'width'=>300,
        'height'=>300,
        'default'=>''
    ],

    'product' => [
        'storage'=>'product',
        'width'=>300,
        'height'=>300,
        'default'=>''
    ],

    'editor' => [
        'storage'=>'editor',
        'width'=>300,
        'height'=>300,
        'default'=>''
    ],

    'general' => [
        'storage'=>'/',
        'width'=>300,
        'height'=>300,
        'default'=>'',

        'thumbnail_width'=> 150,
        'thumbnail_height'=> 150,
        'medium_width'=> 400,
        'medium_height'=> 400,

        'large_width'=> 800,
        'large_height'=> 800,

    ],



];
