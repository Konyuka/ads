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
        $ad = Ad::where('url',$url)->select('product_name', 'id', 'price', 'type', 'amenities', 'bedrooms', 'bathrooms', 'garadge', 'size', 'stories', 'type', 'description', 'map')->first();
        // return dd($ad);
        $relatedAds = Ad::where('type',$ad->type)->select('id', 'product_name', 'location', 'price', 'url')->get();
        $images = Image::where('productID',$ad->id)->get();

        $relatedAdsImages = [];        
        foreach ($relatedAds as $key => $value) {
            $relatedAdsArray = Image::where('productID',$value->id)->select('productID', 'file_name')->distinct('productID')->first();
            array_push($relatedAdsImages, $relatedAdsArray);
        }
        return Inertia::render('Welcome', [
            'ad' => $ad,
            'images' => $images,
            'relatedAds' => $relatedAds,
            'relatedAdsImages' => $relatedAdsImages,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function mail(Request $request)
    {
        return dd($request);
        $data = $request->validate([        
            'fname' => 'required',        
            'lname', 
            'email',
            'phone' => 'required',
            'message',
        ]);

        Mail::to('michaelsaiba84@gmail.com')->send(new ContactFormMail($data));
        return response()->json(['message' => 'Email sent!']);

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
