<?php

namespace App\Traits;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use InterventionImage;

trait ImageTraits
{
    public function storeFile($typeFile, $value)
    {
        if ($typeFile == config('constants.PATH.IMAGES')) {
            return $this->storeImage($value);
        }

        return Storage::disk('public')->put($typeFile, $value);
    }

    public function storeImage($file)
    {
        $img = $this->resizeImage($file);
        $nameUnique = str_replace("/", "", Hash::make($img->__toString()) . '.jpg');
        Storage::put('/public/images/' . $nameUnique, $img->__toString());

        return 'images/' . $nameUnique;
    }

    public function resizeImage($image, $newWidth = null, $newHeight = null)
    {
        $infoImage = getimagesize($image);
        $newHeight = $newHeight ?? config('filesystems.images.max_width_upload') * ($infoImage[1]/$infoImage[0]);
        $img = InterventionImage::make($image->getRealPath());
        $img->resize($newWidth ?? config('filesystems.images.max_width_upload'), $newHeight)->encode('jpg');

        return $img;
    }

    function getPathFile($typeFile, $value)
    {
        if ($value) {
            return $this->storeFile($typeFile, $value);
        }

        return null;
    }

    public function getPathThumbnails($nameThumbnails, $thumbnails)
    {
        $nameThumbnail = [];
        foreach ($nameThumbnails as $key => $value) {
            if ($value) {
                $image = str_replace('data:image/png;base64,', '', $thumbnails[$key]);
                $image = str_replace(' ', '+', $image);
                $nameThumbnail[$key] = $this->getPathFile($value, base64_decode($image));
            }
        }

        return $nameThumbnail;
    }

    public function getPathImages($imageUpdate, $isUpdateImage)
    {
        $urlImage = [];
        if ($isUpdateImage) {
            foreach ($isUpdateImage as $key => $value) {
                if ($value) {
                    $urlImage['image' . ($key + 1)] = isset($imageUpdate[$key + 1])
                        ? $this->getPathFile(config('constants.PATH.IMAGES'), $imageUpdate[$key + 1])
                        : null;
                }
            }
        }

        return $urlImage;
    }

    public function getPathVideos($videos, $isUpdateVideo)
    {
        $urlVideo = [];
        if ($isUpdateVideo) {
            foreach ($isUpdateVideo as $key => $value) {
                if ($value) {
                    $urlVideo['video' . ($key + 1)] = isset($videos[$key + 1])
                        ? $this->getPathFile(config('constants.PATH.VIDEOS'), $videos[$key + 1])
                        : null;
                }
            }
        }

        return $urlVideo;
    }

    public function removeFileUpdate($urlFiles, $parkingLot)
    {
        $file = [];
        foreach ($urlFiles as $key => $urlFile) {
            $file[$key] = $parkingLot[$key . '_url'];
        }

        return $this->removeFile($file);
    }

    public function removeFileThumbnail($filesName, $thumbnailVideos)
    {
        $default = config('constants.PATH.IMAGES') . "/" . config('constants.IMAGES.DEFAULT') . config('constants.IMAGES.DEFAULT_TYPE');
        $nameThumbnails = [];
        $file = [];
        foreach ($filesName as $key => $fileName) {
            if ($fileName != config('constants.IMAGES.DEFAULT') || $fileName != '') {
                $file[$key] = $thumbnailVideos[config('constants.IMAGES.THUMBNAIL') . $key . config('constants.IMAGES.URL')];
            }
            if ($file[$key] != $default) $nameThumbnails[$key] = $file[$key];
        }

        return $this->removeFile($nameThumbnails);
    }

    public function removeFile($file)
    {
        return Storage::disk('public')->delete($file);
    }

    public function getNameThumbnails($urlVideos)
    {
        $thumbnailName = [];
        foreach ($urlVideos as $key => $url) {
            $key = ltrim($key, config('constants.KEY.VIDEO'));
            $thumbnailName[$key] = $this->getNameThumbnail($url);
        }

        return $thumbnailName;
    }

    function getNameThumbnail($url)
    {
        $thumbnailName = explode(".", ltrim($url, config('constants.PATH.VIDEOS') . "/"))[0];

        return $thumbnailName;
    }

    function getPrefixNameThumbnail($url)
    {
        $thumbnailName = explode(".", ltrim($url, config('constants.PATH.IMAGES') . "/"))[0];

        return $thumbnailName;
    }

    public function setNameThumbnail($nameThumbnails, $numberVideos, $thumbnailVideos = null)
    {
        for ($i = 1; $i <= $numberVideos; $i++) {
            $thumbnailVideo = isset($thumbnailVideos[config('constants.IMAGES.THUMBNAIL') . $i . config('constants.IMAGES.URL')]) ?
                $thumbnailVideos[config('constants.IMAGES.THUMBNAIL') . $i . config('constants.IMAGES.URL')] : null;

            if (!isset($nameThumbnails[$i]))
                $nameThumbnails[$i] = $thumbnailVideos ?
                    $this->getPrefixNameThumbnail($thumbnailVideo) : config('constants.IMAGES.DEFAULT');
            if ($nameThumbnails[$i] == '') $nameThumbnails[$i] = config('constants.IMAGES.DEFAULT');

            $nameThumbnails[$i] = config('constants.PATH.IMAGES') . "/" . $nameThumbnails[$i] . config('constants.IMAGES.DEFAULT_TYPE');
        }

        return $nameThumbnails;
    }

    public function getBlobImage($file)
    {
        $imgStamp = $this->resizeImage($file, config('filesystems.images.max_width_stamp'), config('filesystems.images.max_height_stamp'));

        return base64_encode($imgStamp);
    }
}
