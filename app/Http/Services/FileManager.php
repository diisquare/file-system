<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class FileManager
{
    protected $fileTypes = [
        'image' => 'png|jpg|jpeg|tmp|gif',
        'word' => 'doc|docx',
        'ppt' => 'ppt|pptx',
        'excel' => 'xls|xlsx',
        'pdf' => 'pdf',
        'code' => 'php|js|java|python|ruby|go|c|cpp|sql|m|h|json|html|aspx',
        'zip' => 'zip|tar\.gz|rar|rpm',
        'txt' => 'txt|pac|log|md',
        'audio' => 'mp3|wav|flac|3pg|aa|aac|ape|au|m4a|mpc|ogg',
        'video' => 'mkv|rmvb|flv|mp4|avi|wmv|rm|asf|mpeg',
    ];

    public $path;
    private $disk;
    private $storage;
    private $sharedDisk='share';//这是一个很不好的写法，暂时没有想到解决方案;

    public function __construct($path='/',$disk='share')
    {
        $this->path=$path;
        $this->disk=$disk;
        $this->storage=Storage::disk($this->disk);
    }

    // show all file and directories under $path
    public function ls(){
        $files= $this->storage->files($this->path);
        $directories =$this->storage->directories($this->path);

        return array_merge($this->formatDirectories($directories),$this->formatFiles($files));
    }


    private function formatDirectories($dirs){
        $dirsInfo=[];
        foreach ($dirs as $dir){
            $url  = $this->storage->url($dir);
            $link = route(Request::route()->getName(),['path'=>'/'.trim($dir,'/')]);
            $preview="<a href=\"$link\"><span class=\"file-icon text-aqua\"><i class=\"fa fa-folder\"></i></span></a>";
            array_push($dirsInfo,array(
                'download'=>'',
                'name'=>$dir,
                'isDir'=>true,
                'url'=>$url,
                'link'=>$link,
                'preview'=>$preview,
                'time'=>'',
                'icon'=>'',
                'size'=>''
            ));
        }
        return $dirsInfo;
    }

    private function formatFiles($files=[])
    {
        $filesInfo=[];
        foreach ($files as $file){
            $url  = $this->storage->url($file);
            $preview=$this->getFilePreview($file);

            if ($this->disk==$this->sharedDisk){
                $download= route('post-download',['file'=>$file]);
            }else{
                $download= route('file-manager-download',['file'=>$file]);
            }
            array_push($filesInfo,[
                'download'=>$download,
                'name'=>$file,
                'isDir'=>false,
                'url'=>$url,
                'link'=>$url,
                'preview'=>$preview,
                'time'=>'',
                'icon'=>'',
                'size'=>$this->fileSize($file)
            ]);
    }
        return $filesInfo;
    }

    public function navigation(){
        $folders = explode('/', $this->path);

        $folders = array_filter($folders);

        $path = '';

        $navigation = [];

        foreach ($folders as $folder) {
            $path = rtrim($path, '/') . '/' . $folder;

            $navigation[] = [
                'name' => $folder,
                'url' => route(Request::route()->getName(), ['path' => $path]),
            ];
        }

        return $navigation;
    }

    public function urls(){
        return [
            'path' => $this->path,
        ];
    }

    public function fileSize($file)
    {
        return human_fileSize($this->storage->size($file));
    }

    protected function detectFileType($file)
    {
        $extension = File::extension($file);

        foreach ($this->fileTypes as $type => $regex) {
            if (preg_match("/^($regex)$/i", $extension) !== 0) {
                return $type;
            }
        }
        return false;
    }

    private function getFilePreview($file)
    {
        switch ($this->detectFileType($file)) {
            case 'image':
                $url = $this->storage->url($file);
                if ($url) {
                    $preview = "<span class=\"file-icon has-img\"><img src=\"$url\" alt=\"Attachment\"></span>";
                } else {
                    $preview = '<span class="file-icon"><i class="fa fa-file-image-o"></i></span>';
                }

                break;
            case 'pdf':
                $preview = '<span class="file-icon"><i class="fa fa-file-pdf-o"></i></span>';
                break;

            case 'zip':
                $preview = '<span class="file-icon"><i class="fa fa-file-zip-o"></i></span>';
                break;

            case 'word':
                $preview = '<span class="file-icon"><i class="fa fa-file-word-o"></i></span>';
                break;

            case 'ppt':
                $preview = '<span class="file-icon"><i class="fa fa-file-powerpoint-o"></i></span>';
                break;

            case 'excel':
                $preview = '<span class="file-icon"><i class="fa fa-file-excel-o"></i></span>';
                break;

            case 'txt':
                $preview = '<span class="file-icon"><i class="fa fa-file-text-o"></i></span>';
                break;

            case 'code':
                $preview = '<span class="file-icon"><i class="fa fa-code"></i></span>';
                break;

            case 'audio':
                $preview = '<span class="file-icon"><i class="fa fa-file-audio-o"></i></span>';
                break;
            case 'video':
                $preview = '<span class="file-icon"><i class="fa fa-file-video-o"></i></span>';
                break;

            default:
                $preview = '<span class="file-icon"><i class="fa fa-file"></i></span>';
        }
        return $preview;
    }

    public function download(){
//        return $this->storage->download($this->path);
        $path_parts = pathinfo($this->path);
        $filename = $path_parts['basename'];
        $temp_file = tempnam(sys_get_temp_dir(), $filename);
        copy($this->storage->url($this->path), $temp_file);
        return response()->download($temp_file, $filename);
    }
}
