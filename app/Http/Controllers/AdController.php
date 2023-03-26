<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Image;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use App\Mail\FormMail;
use Illuminate\Support\Facades\Cache;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($url)
    {
        $cacheDuration = env('CACHE_DURATION', 3600);


        $ad = Cache::remember('ad'. $url, $cacheDuration, function () use ($url) {
            return Ad::where('url',$url)->select('product_name', 'id', 'price', 'type', 'amenities', 'bedrooms', 'bathrooms', 'garadge', 'size', 'stories', 'type', 'description', 'map')->first();
        });

        $relatedAds = Cache::remember('relatedAds' .$ad, $cacheDuration, function () use ($ad){
            return Ad::where('type',$ad->type)->select('id', 'product_name', 'location', 'price', 'url')->get();
        });

        $images = Cache::remember('images' .$ad, $cacheDuration, function () use ($ad){
            return Image::where('productID',$ad->id)->get();
        });


        $relatedAdsImages = [];        
        foreach ($relatedAds as $key => $value) {

            $relatedAdsArray = Cache::remember('relatedAdsArray' .$value, $cacheDuration, function () use ($value){
                return Image::where('productID',$value->id)->select('productID', 'file_name')->distinct('productID')->first();
            });
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
       
        
        $fname = $request->fname;
        $lname = $request->lname;
        $phone = $request->phone;
        $email = $request->email;
        $messageContent = $request->message;
        Mail::to('michaelsaiba84@gmail.com')->send(new FormMail($fname, $lname, $phone, $email,  $messageContent));
        return redirect()->back()->with('success', 'Enquiry Sent Successfully');
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
