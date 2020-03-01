<?php

namespace App\Admin\Controllers;

use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Encore\Admin\Auth\Permission;
use App\Http\Controllers\Controller;

class StorageController extends Controller
{

    public function index(Request $request, $file_path)
    {
        if (!$request->is(['storage/share/*','storage/images/*'])){
            if (!Permission::check('file-manager')){
                abort('404');
            }
        }

        if (!Storage::disk('public')->exists($file_path)) {
            abort(404);
        }


        $local_path = config('filesystems.disks.public.root') . DIRECTORY_SEPARATOR . $file_path;
        return response()->file($local_path);

    }
}
