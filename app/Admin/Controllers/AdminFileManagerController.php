<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Admin\Services\AdminFileManager;
use Illuminate\Http\Request;
use Encore\Admin\Layout\Content;

class AdminFileManagerController extends Controller
{
    public function index(Request $request, Content $content)
    {
        $path = $request->input('path', '/');
        $view = $request->input('view', 'list');
        $manager = new AdminFileManager($path);
        return $content
            ->header('File Manager')
            ->body(view("Admin.fileManager.$view", [
                'list' => $manager->ls(),
                'nav' => $manager->navigation(),
                'url' => $manager->urls(),
            ]));
    }

    public function download(Request $request)
    {
        $file = $request->input('file');
        $manager = new AdminFileManager($file);

        return $manager->download();
    }

    public function upload(Request $request)
    {
        $files = $request->file('files');
        $dir = $request->input('dir', '/');

        $manager = new AdminFileManager($dir);

        try {
            if ($manager->upload($files)) {
                admin_toastr(trans('admin.upload_succeeded'));
            }
        } catch (\Exception $e) {
            admin_toastr($e->getMessage(), 'error');
        }

        return back();
    }

    public function delete(Request $request)
    {
        $files = $request->input('files');
        $manager = new AdminFileManager();


        try {
            if ($manager->delete($files)) {
                return response()->json([
                    'status' => true,
                    'message' => trans('admin.delete_succeeded'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function move(Request $request)
    {
        $path = $request->input('path');
        $new = $request->input('new');

        $manager = new AdminFileManager($path);

        try {
            if ($manager->move($new)) {
                return response()->json([
                    'status' => true,
                    'message' => trans('admin.move_succeeded'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function newFolder(Request $request)
    {
        $dir = $request->input('dir');
        $name = $request->input('name');

        $manager = new AdminFileManager($dir);

        try {
            if ($manager->newFolder($name)) {
                return response()->json([
                    'status' => true,
                    'message' => trans('admin.move_succeeded'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
