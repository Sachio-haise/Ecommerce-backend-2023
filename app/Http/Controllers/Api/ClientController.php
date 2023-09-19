<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ClientRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{

    public function __construct()
    {
        // $this->imagUrl = 'http://localhost:8000/storage/profile/';
    }


    public function updateProfile(Request $request)
    {

        try {
            $imageUrl = '';
            $name = $request->name;
            $email = $request->email;
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $fileName = $file->getClientOriginalName();
                $filePath = 'profile/' . $fileName;

                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $imageUrl = Storage::disk('s3')->url($filePath);
            }

            $user =   User::where('email', $email)->first();
            User::where('email', $email)->update([
                'name' => $name,
                'email' => $email,
                'avatar' => $imageUrl === '' ? $user->avatar : $imageUrl
            ]);
            return response()->noContent();
        } catch (Exception $e) {
            return $e;
        }
    }
}
