<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Service\admin\AboutUsService;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    private $aboutUsService;
    //
    public function __construct(AboutUsService $aboutUsService)
    {
        $this->aboutUsService = $aboutUsService;
    }

    public function index()
    {
        $aboutInfo = $this->aboutUsService->getAll();
        return view('admin.about.about', compact('aboutInfo'));
    }

    public function showEditBanner(Request $request)
    {
        $id = $request->id;
        $aboutInfo = $this->aboutUsService->getById($id);
        return view('admin.about.edit_about', compact('id', 'aboutInfo'));
    }

    public function editBanner(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'type' => 'required',
        ]);
        $id = $request->id;
        $name = $request->name;
        $type = $request->type;
        $this->aboutUsService->edit($id, $name, $type);
        return redirect(route('admin.about.index'))->with('success', 'Sửa about thành công');
    }
}
