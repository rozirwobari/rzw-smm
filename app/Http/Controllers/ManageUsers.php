<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Models\WebSettingModel;
use Illuminate\Support\Facades\Hash;


class ManageUsers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $website = WebSettingModel::first();
        return view('panel.content.Users.index', compact('users', 'website'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function profile()
    {
        $user = Auth::user();
        $website = WebSettingModel::first();
        return view('panel.content.Users.profile', compact('user', 'website'));
    }

    public function profileSaved(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $rules = [
            'name' => 'required|string|max:255',
        ];
        if ($request->filled('oldpassword')) {
            $rules['oldpassword'] = 'required';
            $rules['newpassword'] = 'required|min:8';
        }

        $request->validate($rules);
        $user->name = $request->name;

        if ($request->filled('oldpassword')) {
            if (!Hash::check($request->oldpassword, $user->password)) {
                return back()
                    ->withInput()
                    ->withErrors(['oldpassword' => 'Password lama tidak sesuai']);
            }

            $user->password = Hash::make($request->newpassword);
        }

        $user->save();
        return redirect()
            ->back()
            ->with('alert', [
                'type' => 'success',
                'description' => 'Data Berhasil Di Update',
                'title' => 'Berhasil'
            ]);
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
        $user = User::find($id);
        $website = WebSettingModel::first();
        return view('panel.content.Users.edit', compact('user', 'website'));
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
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->saldo = $request->saldo;
        $user->save();
        return redirect()->route('users.manage')->with('alert', [
            'type' => 'success',
            'description' => 'Data User ' . $user->name . ' Berhasil Diubah',
            'title' => 'Berhasil'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.manage')->with('alert', [
            'type' => 'success',
            'description' => 'Data User ' . $user->name . ' Berhasil Dihapus',
            'title' => 'Berhasil'
        ]);
    }
}
