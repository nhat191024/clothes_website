<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Service\admin\ColorService;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    private $colorService;
    //
    public function __construct(ColorService $colorService)
    {
        $this->colorService = $colorService;
    }

    public function index()
    {
        $allColor = $this->colorService->getAll();
        return view('admin.color.color', compact('allColor'));
    }

    public function showAddColor()
    {
        return view('admin.color.add_color');
    }

    public function addColor(Request $request)
    {
        $request->validate([
            'color_name' => 'required',
            'color_hex' => 'required',
        ]);
        if($this->colorService->checkHasName($request->color_name)) {
            return redirect()->back()->with('error', 'Tên màu đã có trên hệ thống');
        }
        $this->colorService->add($request->color_name, $request->color_hex);
        return redirect(route('admin.color.index'))->with('success', 'Thêm màu thành công');
    }

    public function showEditColor(Request $request)
    {
        $id = $request->id;
        $colorInfo = $this->colorService->getById($id);
        return view('admin.color.edit_color', compact('id', 'colorInfo'));
    }

    public function editColor(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'color_name' => 'required',
            'color_hex' => 'required',
        ]);
        if($this->colorService->checkHasName($request->color_name, $request->id)) {
            return redirect()->back()->with('error', 'Tên màu đã có trên hệ thống');
        }
        // Public Folder
        $this->colorService->edit($request->id, $request->color_name, $request->color_hex);
        return redirect(route('admin.color.index'))->with('success', 'Sửa màu thành công');
    }

    public function deleteColor(Request $request)
    {
        $id = $request->id;
        if($this->colorService->checkHasChildren($id)) {
            return redirect(route('admin.color.index'))->with('success', 'Ẩn màu thất bại, màu đang tồn tại trong sản phẩm');
        }
        $this->colorService->delete($id);
        return redirect(route('admin.color.index'))->with('success', 'Ẩn màu thành công');
    }

    public function restoreColor(Request $request)
    {
        $id = $request->id;
        $this->colorService->restore($id);
        return redirect(route('admin.color.index'))->with('success', 'Khôi phục màu thành công');
    }

}
