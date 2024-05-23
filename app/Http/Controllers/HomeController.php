<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Pincode;
use App\Models\State;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * User Profile
     * @param Nill
     * @return View Profile
     * @author Shani Singh
     */
    public function getProfile()
    {
        return view('profile');
    }

    /**
     * Update Profile
     * @param $profileData
     * @return Boolean With Success Message
     * @author Shani Singh
     */
    public function updateProfile(Request $request)
    {
        #Validations
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required|numeric|digits:10',
        ]);

        try {
            DB::beginTransaction();

            #Update Profile Data
            User::whereId(auth()->user()->id)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile_number' => $request->mobile_number,
            ]);

            #Commit Transaction
            DB::commit();

            #Return To Profile page with success
            return back()->with('success', 'Profile Updated Successfully.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Change Password
     * @param Old Password, New Password, Confirm New Password
     * @return Boolean With Success Message
     * @author Shani Singh
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        try {
            DB::beginTransaction();

            #Update Password
            User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

            #Commit Transaction
            DB::commit();

            #Return To Profile page with success
            return back()->with('success', 'Password Changed Successfully.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required'

        ]);
        // return $request;
        DB::beginTransaction();
        try {

            if ($request->search_for == 'user') {

                $users = User::
                    where('first_name', 'like', '%' . $request->search . '%')
                    ->paginate(50);

                DB::commit();
                return view("users.index", ['users' => $users]);
            }

            if ($request->search_for == 'vendor') {

                $vendors = Vendor::select('vendors.*')
                    ->leftJoin('users', 'users.id', '=', 'vendors.user_id')->
                    where('users.first_name', 'like', '%' . $request->search . '%')
                    ->where('users.role_id', 3)->paginate(50);

                DB::commit();
                return view("vendors.index", ['vendors' => $vendors]);
            }

            if ($request->search_for == 'city') {

                $cities = City::
                    where('name', 'like', '%' . $request->search . '%')
                    ->paginate(50);

                DB::commit();
                return view("cities.index", ['cities' => $cities]);
            }

            if ($request->search_for == 'country') {

                $countries = Country::
                    where('country_name', 'like', '%' . $request->search . '%')
                    ->paginate(50);

                DB::commit();
                return view("country.index", ['countries' => $countries]);
            }

            if ($request->search_for == 'state') {

                $states = State::
                    where('name', 'like', '%' . $request->search . '%')
                    ->paginate(50);

                DB::commit();
                return view("states.index", ['states' => $states]);
            }

            if ($request->search_for == 'pincode') {

                $pincodes = Pincode::
                    where('pincode', 'like', '%' . $request->search . '%')
                    ->paginate(50);

                DB::commit();
                return view("pincodes.index", ['pincodes' => $pincodes]);
            }

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->back();

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }
}
