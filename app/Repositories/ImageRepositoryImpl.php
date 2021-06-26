<?php


namespace App\Repositories;


use App\Image;

class ImageRepositoryImpl extends GenericRepositoryImpl implements IImageRepository
{
    public function __construct()
    {
        $this-> model = new Image();
    }
}
