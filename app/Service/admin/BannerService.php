<?php

namespace App\Service\admin;

use App\Models\Banner;

class BannerService
{
    public function getAll()
    {
        $banner = Banner::all();
        return $banner;
    }

    public function getById($id) {
        return Banner::where('id', $id)->first();
    }

    public function add($bannerTitle, $bannerContent, $imageName,$link)
    {
        Banner::create([
            'title' => $bannerTitle,
            'subtitle' => $bannerContent,
            'image' => $imageName,
            'link' => $link,
        ]);
    }

    public function edit($id, $bannerTitle, $bannerContent, $imageName, $link)
    {
        $banner = Banner::where('id', $id)->first();
        $banner->title = $bannerTitle;
        $banner->subtitle = $bannerContent;
        if ($imageName != null) {
            $banner->image = $imageName;
        }
        $banner->link = $link;
        $banner->save();
    }

    public function delete($id) {
        $banner = Banner::destroy($id);
    }
}
