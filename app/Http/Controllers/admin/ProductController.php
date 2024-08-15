<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Service\admin\CategoryService;
use App\Service\admin\ColorService;
use App\Service\admin\ProductService;
use App\Service\admin\SizeService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;
    private $categoryService;
    private $sizeService;
    private $colorService;

    // 
    public function __construct(ProductService $productService, CategoryService $categoryService, SizeService $sizeService, ColorService $colorService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->sizeService = $sizeService;
        $this->colorService = $colorService;
    }

    public function index()
    {
        $allProduct = $this->productService->getAll();
        return view('admin.product.product', compact('allProduct'));
    }

    public function showAddProduct()
    {
        $allCategory = $this->categoryService->getAll();
        $allSize = $this->sizeService->getAll();
        $allColor = $this->colorService->getAll();
        $allSize = $allSize->pluck('name', 'id')->toArray(); // Giả sử bảng size có cột 'name' và 'id'
        $allColor = $this->colorService->getAll()->pluck('name', 'id')->map(function ($name, $id) use ($allColor) {
            return [
                'name' => $name,
                'color_hex' => $allColor->find($id)->color_hex // hoặc trường dữ liệu HEX của bạn
            ];
        })->toArray();
        return view('admin.product.add_product', compact('allCategory', 'allSize', 'allColor'));
    }

    public function showDetail(Request $request)
    {
        $id = $request->id;
        $productInfo = $this->productService->getById($id);
        $allVariations = $this->variationService->getAll();
        return view('admin.product.detail', compact('id', 'productInfo', 'allVariations'));
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'product_name' => 'required',
            'product_price' => 'required',
            'product_image' => 'required',
            'sizes' => 'required',
        ]);
        $categoryArray = $request->category_id;
        $productName = $request->product_name;
        $productPrice = $request->product_price;
        $productDescription = $request->product_description ?? null;
        $imageName = time() . '_' . $request->product_image->getClientOriginalName();
        $sizeColors = $request->sizes;
        // Public Folder
        $request->product_image->move(public_path('img/client/shop'), $imageName);
        $this->productService->add($categoryArray, $productName, $productPrice, $productDescription, $imageName, $sizeColors);
        return response()->json([
            'link' => route('admin.product.index')
        ], 200);

    }

    public function showEditProduct(Request $request)
    {
        $id = $request->id;
        $allCategory = $this->categoryService->getAll();
        $productInfo = $this->productService->getById($id);
        $allVariations = $this->variationService->getAll();
        return view('admin.product.edit_product', compact('id', 'productInfo', 'allCategory', 'allVariations'));
    }

    public function showEditDetail(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'product_id' => 'required',
        ]);
        $id = $request->id;
        $productId = $request->product_id;
        $productVariatonInfo = $this->productService->getDetailById($id);
        return view('admin.product.edit_detail', compact('id', 'productVariatonInfo', 'productId'));
    }

    public function editProduct(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'category_id' => 'required',
            'product_name' => 'required',
            'product_name_en' => 'required',
        ]);
        $id = $request->id;
        $categoryId = $request->category_id;
        $productName = $request->product_name;
        $productNameEn = $request->product_name_en;
        $productPrice = $request->product_price;
        $productDescription = $request->product_description ?? null;
        $productDescriptionEn = $request->product_description_en ?? null;
        if ($request->product_image && $request->product_image != 'undefined') {
            $imageName = time() . '_' . $request->product_image->getClientOriginalName();
            $request->product_image->move(public_path('img/client/shop'), $imageName);
            $oldImagePath = $this->productService->getById($request->id)->image;
            if (file_exists(public_path('img/client/shop') . '/' . $oldImagePath)) {
                unlink(public_path('img/client/shop') . '/' . $oldImagePath);
            }
        }
        return $this->productService->edit($id, $categoryId, $productName, $productNameEn, $productPrice, $productDescription, $productDescriptionEn, $imageName ?? null);
    }

    public function editDetail(Request $request)
    {
        $request->validate([
            'product_price' => 'required',
            'id' => 'required',
            'product_id' => 'required',
        ]);
        $id = $request->id;
        $productId = $request->product_id;
        $productPrice = $request->product_price;
        $this->productService->editDetail($id, $productPrice);
        return redirect(route('admin.product.show_detail', ['id' => $productId]))->with('success', 'Sửa biến thể thành công');
    }

    public function deleteProduct(Request $request)
    {
        $id = $request->id;
        $this->productService->delete($id);
        return redirect(route('admin.product.index'))->with('success', 'Ẩn thực phẩm thành công');
    }

    public function restoreProduct(Request $request)
    {
        $id = $request->id;
        $this->productService->restore($id);
        return redirect(route('admin.product.index'))->with('success', 'Khôi phục thực phẩm thành công');
    }

    public function deleteDetail(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'product_id' => 'required',
        ]);
        $id = $request->id;
        $productId = $request->product_id;
        if ($this->productService->deleteDetail($id, $productId)) {
            return redirect(route('admin.product.show_detail', ['id' => $productId]))->with('success', 'Xóa biến thể thành công');
        }
        return redirect(route('admin.product.show_detail', ['id' => $productId]))->with('error', 'Biến thể không thể ít hơn 1 !!!!');

    }
}
