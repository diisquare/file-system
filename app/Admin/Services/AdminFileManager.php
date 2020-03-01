<?php

namespace App\Admin\Services;

use Encore\Admin\Extension;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Plugin\ListWith;
use App\Http\Services\FileManager;

class AdminFileManager extends Extension
{


    public $name = 'file-manager';

    public $views = __DIR__ . '/../resources/views';



    public $menu = [
        'title' => 'FileManager',
        'path' => 'file-manager',
        'icon' => 'fa-file',
    ];


    public $fileManager;
    public $disk;
    public $path;
    public $storage;

    public function __construct($path = '/')
    {
        $this->path = $path;

        $this->disk = config('diisquare.Admin.disk');

        $this->storage = Storage::disk($this->disk);

        $this->fileManager=new FileManager($path,$this->disk);
    }


    public function download()
    {
        return $this->fileManager->download();
    }

    public function upload($files = [])
    {
        foreach ($files as $file) {
            $this->storage->putFile($this->path, $file);
        }

        return true;
    }


    public function exists()
    {
        return $this->storage->exists($this->path);
    }

    public function newFolder($name)
    {
        $path = rtrim($this->path, '/') . '/' . trim($name, '/');

        return $this->storage->makeDirectory($path);

    }

    public function delete($path)
    {
        $paths = is_array($path) ? $path : func_get_args();
        foreach ($paths as $path) {
            if (File::isDirectory( 'storage/'.$path)){

                $this->storage->deleteDirectory($path);

            }else{
                $this->storage->delete($path);
            }

        };

        return true;
    }

    public function move($new)
    {
        return $this->storage->move($this->path, $new);
    }


    public function ls()
    {
        return $this->fileManager->ls();
    }

    public function navigation()
    {
        return $this->fileManager->navigation();
    }

    public function urls()
    {
        return [
            'path' => $this->path,
            'index' => route('file-manager-index'),
            'move' => route('file-manager-move'),
            'delete' => route('file-manager-delete'),
            'upload' => route('file-manager-upload'),
            'new-folder' => route('file-manager-new-folder'),
        ];
    }
}
