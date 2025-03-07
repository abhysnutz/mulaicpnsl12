<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $provinces = Province::orderBy('name','ASC')->get();

        return view('frontend.profile', compact('user','provinces'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {   
        \Log::info($request->all());
        if($request->type == "akun"){
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'lowercase',
                    'email',
                    'max:255',
                    Rule::unique(User::class)->ignore(Auth::id()) // Use Auth::id(),
                ],
            ]);

            $request->user()->fill($validated);

            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }
    
            $request->user()->save();
    
            return Redirect::route('profile.edit')->with('status', 'account-updated');
        }else{
            UserDetail::updateOrCreate (
                ['id' => Auth::id(),'user_id' => Auth::id()],
                [
                    'phone' => $request?->phone ?? NULL,
                    'birth' => $request?->birth ?? NULL,
                    'province_id' => $request?->province_id ?? NULL,
                    'city_id' => $request?->city_id ?? NULL,
                    'address' => $request?->address ?? NULL,
                    'education' => $request?->education ?? NULL,
                    'major' => $request?->major ?? NULL,
                ]
            );
    
            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        }
        
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function city(Request $request){
        $result = [];
        $result['status'] = 0;
        $result['data'] = [];
        if($request->province_id){
            $cities = City::where('province_id', $request->province_id)->orderBy('name','ASC')->get();
            if($cities->count()){
                $result['status'] = 1;
                $result['data'] = $cities->toArray();
            }
        }

        return response()->json($result,200);
    }
}
