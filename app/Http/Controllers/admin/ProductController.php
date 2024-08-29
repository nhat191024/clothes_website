<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Service\admin\CategoryService;
use App\Service\admin\ColorService;
use App\Service\admin\PhotoService;
use App\Service\admin\ProductService;
use App\Service\admin\SizeService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;
    private $categoryService;
    private $sizeService;
    private $colorService;
    private $photoService;

    //
    public function __construct(ProductService $productService, CategoryService $categoryService, SizeService $sizeService, ColorService $colorService, PhotoService $photoService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->sizeService = $sizeService;
        $this->colorService = $colorService;
        $this->photoService = $photoService;
    }

    public function index()
    {
        $allProduct = $this->productService->getAll();
        return view('admin.product.product', compact('allProduct'));
    }

    public function showAddProduct()
    {
        $allCategory = $this->categoryService->getAll();
        $allSize = $this->sizeService->getAllWithoutTrash();
        $allColor = $this->colorService->getAllWithoutTrash();
        $allSize = $allSize->pluck('name', 'id')->toArray();
        $allColor = $this->colorService->getAll()->pluck('name', 'id')->map(function ($name, $id) use ($allColor) {
            $color = $allColor->find($id);
            return [
                'name' => $name,
                'color_hex' => $color ? $color->color_hex : null,
            ];
        })->toArray();
        return view('admin.product.add_product', compact('allCategory', 'allSize', 'allColor'));
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
        $imageName = str_replace(' ', '', time() . '_' . $request->product_image->getClientOriginalName());
        $sizeColors = $request->sizes;
        // Public Folder
        $request->product_image->move(public_path('img/product'), $imageName);
        $this->productService->add($categoryArray, $productName, $productPrice, $productDescription, $imageName, $sizeColors);
        return response()->json([
            'link' => route('admin.product.index')
        ], 200);

    }

    public function showEditProduct(Request $request)
    {
        $id = $request->id;
        $productDetails = $this->productService->getProductDetails($id);
        // dd($productDetails);
        $allCategory = $this->categoryService->getAll();
        $allSize = $this->sizeService->getAllWithoutTrash();
        $allColor = $this->colorService->getAllWithoutTrash();
        $allSize = $allSize->pluck('name', 'id')->toArray();
        $allColor = $this->colorService->getAll()->pluck('name', 'id')->map(function ($name, $id) use ($allColor) {
            $color = $allColor->find($id);
            return [
                'name' => $name,
                'color_hex' => $color ? $color->color_hex : null,
            ];
        })->toArray();
        return view('admin.product.edit_product', compact('productDetails', 'allCategory', 'allColor', 'allSize'));
    }

    public function editProduct(Request $request)
    {
        // Validate the request
        $request->validate([
            'id' => 'required',
            'category_id' => 'required',
            'product_name' => 'required',
            'product_price' => 'required',
            'sizes' => 'required',
        ]);

        $id = $request->id;
        $categoryArray = $request->category_id;
        $productName = $request->product_name;
        $productPrice = $request->product_price;
        $productDescription = $request->product_description ?? null;
        $imageName = null;

        // Find the existing product
        $product = Product::find($id);

        // Check if the request has a new image
        if ($request->hasFile('product_image')) {
            // Delete the old image if exists
            if ($product->img) {
                $oldImagePath = public_path('img/product/' . $product->img);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Save the new image
            $imageName = str_replace(' ', '', time() . '_' . $request->product_image->getClientOriginalName());
            $request->product_image->move(public_path('img/product/'), $imageName);
        } else {
            // If no new image, retain the old one
            $imageName = $product->img;
        }

        $sizeColors = $request->sizes;

        // Update the product
        $this->productService->edit($id, $categoryArray, $productName, $productPrice, $productDescription, $imageName, $sizeColors);

        return response()->json([
            'link' => route('admin.product.show_edit', ['id' => $id])
        ], 200);
    }

    public function deleteProduct(Request $request)
    {
        $id = $request->id;
        $this->productService->delete($id);
        return redirect(route('admin.product.index'))->with('success', 'Ẩn sản phẩm thành công');
    }

    public function restoreProduct(Request $request)
    {
        $id = $request->id;
        $this->productService->restore($id);
        return redirect(route('admin.product.index'))->with('success', 'Khôi phục sản phẩm thành công');
    }

    public function showPhoto(Request $request)
    {
        $id = $request->id;
        $productDetails = $this->productService->getById($id);
        $images = $this->photoService->getAll($id);
        return view('admin.product.photo', compact('images', 'productDetails'));
    }

    public function addPhoto(Request $request)
    {
        // Lấy danh sách các tệp ảnh từ yêu cầu
        $id = $request->id;
        $images = $request->file('images');

        // Kiểm tra xem có tệp ảnh được gửi lên không
        if ($request->hasFile('images')) {
            $this->photoService->addPhoto($id, $images);
        }

        return response()->json(['message' => 'Tải ảnh lên thành công']);
    }

    public function deletePhoto(Request $request)
    {
        $id = $request->id;
        $productId = $request->product_id;
        if ($id == 'all') {
            $this->photoService->deleteAllPhoto($productId);
        } else {
            $this->photoService->deleteOnePhoto($id);

        }
        $request->session()->flash('success', 'Xóa ảnh thành công');
        return redirect()->back();
    }
}
