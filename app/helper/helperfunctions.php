<?php

namespace App\Helper;
use App\Models\UserDetails;
use Illuminate\Http\Request;

class helperfunctions
{
    public static function saveIPInformation(Request $request)
    {
        $user = auth()->user();

        $ipInformation = new UserDetails([
            'user_id' => $user->id,
            'ip' => $request->ipinfo->ip,
            'city' => $request->ipinfo->city,
            'region' => $request->ipinfo->region,
            'location' => $request->ipinfo->loc,
            'postal' => $request->ipinfo->postal,
        ]);

        $ipInformation->save();
    }
}
