<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Image;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($url)
    {
        $ad = Ad::where('url',$url)->first();
        $relatedAds = Ad::where('type',$ad->type)->get();
        $images = Image::where('productID',$ad->id)->get();

        $relatedAdsImages = [];        
        foreach ($relatedAds as $key => $value) {
            $relatedAdsArray = Image::where('productID',$ad->id)->select('productID', 'file_name')->get();
            $firstImage = $relatedAdsArray[0]; 
            array_push($relatedAdsImages, $relatedAdsArray);
        }
        // return dd($images);
        return Inertia::render('Welcome', [
            'ad' => $ad,
            'images' => $images,
            'relatedAds' => $relatedAds,
            // 'relatedAdsImages' => $firstImage,
            'relatedAdsImages' => $relatedAdsImages,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ad $ad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ad $ad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ad $ad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $ad)
    {
        //
    }
}
