<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebSettingModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class WebSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $website = WebSettingModel::first();
        return view('panel.content.web_settings', compact('website'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'web_name' => 'required',
            'deskripsi' => 'required',
        ],[
            'web_name.required' => 'Website name is required',
            'deskripsi.required' => 'Deskripsi is required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $website = WebSettingModel::first();
        $logo = $request->file('logo');
        $favicon = $request->file('favicon');
        if ($logo) {
            $validatorLogo = Validator::make($request->all(), [
                'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:204800',
            ],[
                'logo.image' => 'Logo harus berupa gambar',
                'logo.mimes' => 'Logo harus berupa file dengan tipe: jpeg, png, jpg, gif, svg',
                'logo.max' => 'Logo harus kurang dari 200MB',
            ]);

            if ($validatorLogo->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            

            $originalName = $logo->getClientOriginalName();
            $extension = $logo->getClientOriginalExtension();
            $logoName = 'logo.' . $extension;
            $logo->move(public_path('logo'), $logoName);
            $website->logo = 'logo/' . $logoName;
        }

        if ($favicon) {
            $validatorLogo = Validator::make($request->all(), [
                'favicon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:204800',
            ],[
                'favicon.image' => 'Logo harus berupa gambar',
                'favicon.mimes' => 'Logo harus berupa file dengan tipe: jpeg, png, jpg, gif, svg',
                'favicon.max' => 'Logo harus kurang dari 200MB',
            ]);

            if ($validatorLogo->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            

            $originalName = $favicon->getClientOriginalName();
            $extension = $favicon->getClientOriginalExtension();
            $logoName = 'favicon.' . $extension;
            $favicon->move(public_path('logo'), $logoName);
            $website->favicon = 'logo/' . $logoName;
        }

        $website->name = $request->web_name;
        $website->deskripsi = $request->deskripsi;
        $website->save();
        
        return redirect()->route('website')->with('alert', [
            'title' => 'Berhasil',
            'description' => 'Website settings updated successfully',
            'type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
