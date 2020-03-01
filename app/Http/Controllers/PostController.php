<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\FileManager;

class PostController extends Controller
{
    public function index(Request $request){
        $path= $request ->input('path','/');
        $manager=new FileManager($path);
        return view('post.index',[
            'list'   => $manager->ls(),
            'nav'    => $manager->navigation(),
            'url'    => $manager->urls(),
        ]);
    }

    public function download(Request $request){
        $file = $request->input('file');
        $manager = new FileManager($file);
        return $manager->download();
    }
}
