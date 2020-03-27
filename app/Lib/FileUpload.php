<?php
namespace App\Lib;

use Intervention\Image\ImageManagerStatic as Image;
use Ramsey\Uuid\Uuid;

class FileUpload
{
    protected $file;
    protected $container;
    protected $fullPath;
    protected $fileName;
    protected $resizes = [];
    protected $fileUploaded = null;
    protected $dates = true;
    protected $originalSave = true;
    protected $private = false;
    protected $maxWidth = 1000;
    protected $maxHeight = 1000;

    public function __construct($file, $path = 'files/', $container = 'asset')
    {
        $this->file = $file;
        $this->container = $container;
        $this->path = $path;
    }

    /**
     * Enable or disable original Save
     */
    public function setOriginalSave($bool = true)
    {
        $this->originalSave = $bool;
    }

    /**
     * Add Resizes
     * @param $prefix
     * @param null $width
     * @param null $height
     */
    public function addResize($prefix, $width = null, $height = null)
    {
        $this->resizes[$prefix] = [
            'width'     => $width,
            'height'    => $height
        ];
    }

    public function setPrivate($bool = true)
    {
        $this->private = $bool;
    }

    public function uploadImageSave($private = false)
    {
        $fileName = Uuid::uuid4()->toString().'.'.$this->file->extension();
        $dates = $this->dates ? Date('Y-m-d').'/' : '';

        if(!$private) {
            $this->path = $this->path.$dates;
        }
        $this->fileName = $this->path.$fileName;

        $path = $private ? 'storage_path' : 'public_path';

        $this->fullPath = $path($this->path);

        //Creando carpetas en caso no existan
        $division = explode('/', $this->path);
        $base = $division[0];
        for($i=1; $i < count($division); $i++) {
            if(!is_dir($path($base))) {
                mkdir($path($base));
            }

            $base .= '/'.$division[$i];
        }

        //Creando directorio

        //Resizes
        $img = Image::make($this->file->getRealPath());

        //Llenando datos de file uploaded
        $this->fileUploaded['filesize'] = $img->filesize();
        $this->fileUploaded['width'] = $img->width();
        $this->fileUploaded['height'] = $img->height();
        $this->fileUploaded['originalName'] = $this->file->getClientOriginalName();
        $this->fileUploaded['extension'] = $this->file->getClientOriginalExtension();
        $this->fileUploaded['mime'] = $this->file->getMimeType();
        if(!$private) {
            $this->fileUploaded['url'] = asset($this->fileName);
        } else {
            $this->fileUploaded['url'] = route('file.private', $fileName);
        }

        //Cargando resizes
        $this->imageResizes($img, $fileName);

        //Guardando Imagen
        $this->imageSave($img, $fileName);
    }

    public function setDates($bool)
    {
        $this->dates = $bool;
    }

    public function getResizes()
    {
        return $this->resizes;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function getFileUploaded()
    {
        return $this->fileUploaded;
    }

    /**
     * @param \Intervention\Image\Image $img
     * @param string $fileName
     */
    protected function imageSave(\Intervention\Image\Image $img, string $fileName): void
    {
        if ($this->originalSave) {

            if ($this->fileUploaded['width'] > $this->maxWidth || $this->fileUploaded['height'] > $this->maxHeight) {
                if ($this->fileUploaded['width'] > $this->fileUploaded['height']) {
                    $img->resize($this->maxWidth, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else {
                    $img->resize(null, $this->maxHeight, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }

                $img->save($this->fullPath . $fileName);
            } else {
                $this->file->move($this->fullPath, $fileName);
            }
        } else {
            if (file_exists($this->file->getRealPath())) {
                unlink($this->file->getRealPath());
            }
        }
    }

    /**
     * @param \Intervention\Image\Image $img
     * @param string $fileName
     */
    protected function imageResizes(\Intervention\Image\Image $img, string $fileName): void
    {
        foreach ($this->resizes as $prefix => $res) {
            $img->resize($res['width'], $res['height'], function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($this->fullPath . $prefix . '_' . $fileName);
            $this->resizes[$prefix]['url'] = asset($this->path . $prefix . '_' . $fileName);
        }
    }
}