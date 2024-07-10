<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAdmin;
use App\Models\Banner;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductDetail;
use App\Models\ProductImg;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Category;
use App\Models\ContactInfo;
use App\Models\ContactUs;
use App\Models\CustomerRequest;
use App\Models\Img;
use App\Models\Promotion;
use App\Models\Size;
use App\Models\Voucher;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $jsonFilePath = "./database/seeders/data.json";
        $jsonContent = file_get_contents($jsonFilePath);
        $dataArray = json_decode($jsonContent, true);

        foreach ($dataArray['users'] as $row) {
            User::create([
                "username" => $row['username'],
                "password" => Hash::make($row['password']),
                "email" => $row['email'],
                "address" => $row['address'],
                "phone" => $row['phone'],
                "role" => $row['role'],
                "status" => $row['status'],
            ]);
        }

        foreach ($dataArray['user_admins'] as $row) {
            UserAdmin::create([
                "username" => $row['username'],
                "password" => Hash::make($row['password']),
                "email" => $row['email'],
                "status" => $row['status'],
            ]);
        }

        foreach ($dataArray['vouchers'] as $row) {
            Voucher::create($row);
        }

        foreach ($dataArray['banners'] as $row) {
            Banner::create($row);
        }

        foreach ($dataArray['contact_infos'] as $row) {
            ContactInfo::create($row);
        }

        foreach ($dataArray['contact_us'] as $row) {
            ContactUs::create($row);
        }

        foreach ($dataArray['imgs'] as $row) {
            Img::create($row);
        }

        foreach ($dataArray['colors'] as $row) {
            Color::create($row);
        }

        foreach ($dataArray['sizes'] as $row) {
            Size::create($row);
        }

        foreach ($dataArray['customer_requests'] as $row) {
            CustomerRequest::create($row);
        }

        foreach ($dataArray['categories'] as $row) {
            Category::create($row);
        }

        foreach ($dataArray['bills'] as $row) {
            Bill::create($row);
        }

        foreach ($dataArray['products'] as $row) {
            Product::create($row);
        }

        foreach ($dataArray['product_categories'] as $row) {
            ProductCategory::create($row);
        }

        foreach ($dataArray['promotions'] as $row) {
            Promotion::create($row);
        }

        foreach ($dataArray['product_imgs'] as $row) {
            ProductImg::create($row);
        }

        foreach ($dataArray['product_details'] as $row) {
            ProductDetail::create($row);
        }

        foreach ($dataArray['bill_details'] as $row) {
            BillDetail::create($row);
        }
    }
}
