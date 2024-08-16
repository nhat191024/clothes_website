<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Service\admin\CategoryService;
use App\Service\admin\SizeService;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    private $sizeService;
    //
    public function __construct(SizeService $sizeService)
    {
        $this->sizeService = $sizeService;
    }

    public function index()
    {
        $allSize = $this->sizeService->getAll();
        return view('admin.size.size', compact('allSize'));
    }

    public function showAddSize()
    {
        return view('admin.size.add_size');
    }

    public function addSize(Request $request)
    {
        $request->validate([
            'size_name' => 'required',
        ]);
        if($this->sizeService->checkHasName($request->size_name)) {
            return redirect()->back()->with('error', 'Tên size đã có trên hệ thống');
        }
        $this->sizeService->add($request->size_name);
        return redirect(route('admin.size.index'))->with('success', 'Thêm size thành công');
    }

    public function showEditSize(Request $request)
    {
        $id = $request->id;
        $sizeInfo = $this->sizeService->getById($id);
        return view('admin.size.edit_size', compact('id', 'sizeInfo'));
    }

    public function editSize(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'size_name' => 'required',
        ]);
        if($this->sizeService->checkHasName($request->size_name, $request->id)) {
            return redirect()->back()->with('error', 'Tên size đã có trên hệ thống');
        }
        // Public Folder
        $this->sizeService->edit($request->id, $request->size_name);
        return redirect(route('admin.size.index'))->with('success', 'Sửa size thành công');
    }

    public function deleteSize(Request $request)
    {
        $id = $request->id;
        $this->sizeService->delete($id);
        return redirect(route('admin.size.index'))->with('success', 'Ẩn size thành công');
    }

    public function restoreSize(Request $request)
    {
        $id = $request->id;
        $this->sizeService->restore($id);
        return redirect(route('admin.size.index'))->with('success', 'Khôi phục size thành công');
    }

}
