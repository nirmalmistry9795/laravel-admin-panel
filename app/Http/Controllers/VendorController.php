<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorBankDetails;
use App\Models\VendorBusinessDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Contracts\Role;
use Illuminate\Http\UploadedFile;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:vendor-list|vendor-create|vendor-edit|vendor-delete', ['only' => ['index']]);
        $this->middleware('permission:vendor-create', ['only' => ['create', 'store', 'updateStatus']]);
        $this->middleware('permission:vendor-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:vendor-delete', ['only' => ['delete']]);
        // $this->middleware('permission:import-users', ['only' => ['importUsers']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::paginate(50);
        return view("vendors.index", ['vendors' => $vendors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendors.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
            'mobile_number' => 'required|numeric|digits:10|unique:users,mobile_number',
            // 'role_id' => 'required|exists:roles,id',
            'status' => 'required|numeric|in:0,1',
            'address' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'pincode_id' => 'required',

            'account_holder_name' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
            'bank_ifsc_code' => 'required',

            'shop_name' => 'required',
            'shop_address' => 'required',
            'shop_city_id' => 'required',
            'shop_state_id' => 'required',
            'shop_country_id' => 'required',
            'shop_pincode_id' => 'required',

            'shop_mobile' => 'required|unique:vendors_business_details,shop_mobile',
            'shop_website' => 'required',
            'shop_email' => 'required|unique:vendors_business_details,shop_email',
            'address_proof' => 'required',
            'address_proof_image' => 'required',
            'business_license_number' => 'required',
            'gst_number' => 'required',
            'pan_number' => 'required'

        ]);

        DB::beginTransaction();
        try {

            // Store Data
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'role_id' => 3,
                'status' => $request->status,
                'password' => Hash::make($request->first_name . '@' . $request->mobile_number)
            ]);

            // Delete Any Existing Role
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();

            // Assign Role To User
            $user->assignRole($user->role_id);

            $vendor = Vendor::create([
                'user_id' => $user->id,
                'address' => $request->address,
                'city_id' => $request->city_id,
                'state_id' => $request->state_id,
                'country_id' => $request->country_id,
                'pincode_id' => $request->pincode_id
            ]);

            $vendor_bank_details = VendorBankDetails::create([
                'vendor_id' => $vendor->id,
                'account_holder_name' => $request->account_holder_name,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'bank_ifsc_code' => $request->bank_ifsc_code
            ]);

            $address_proof_image = '';
            if ($request->hasFile('address_proof_image')) {

                $image = $request->file('address_proof_image');
                $filename = $user->id . '_' . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/vendor/image');
                $image->move($destinationPath, $filename);

                $address_proof_image = $filename;
            }

            $vendors_business_details = VendorBusinessDetails::create([
                'vendor_id' => $vendor->id,
                'shop_name' => $request->shop_name,
                'shop_address' => $request->shop_address,
                'city_id' => $request->shop_city_id,
                'state_id' => $request->shop_state_id,
                'country_id' => $request->shop_country_id,
                'pincode_id' => $request->shop_pincode_id,
                'shop_mobile' => $request->shop_mobile,
                'shop_website' => $request->shop_website,
                'shop_email' => $request->shop_email,
                'address_proof' => $request->address_proof,
                'address_proof_image' => $address_proof_image,
                'business_license_number' => $request->business_license_number,
                'gst_number' => $request->gst_number,
                'pan_number' => $request->pan_number
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('vendors.index')->with('success', 'Vendor Created Successfully.');

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        // return $vendor;
        return view('vendors.edit', ['vendor' => $vendor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request;
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,' . $request->user_id,
            'mobile_number' => 'required|numeric|digits:10|unique:users,mobile_number,' . $request->user_id,
            // 'role_id' => 'required|exists:roles,id',
            'status' => 'required|numeric|in:0,1',
            'address' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'pincode_id' => 'required',

            'account_holder_name' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
            'bank_ifsc_code' => 'required',

            'shop_name' => 'required',
            'shop_address' => 'required',
            'shop_city_id' => 'required',
            'shop_state_id' => 'required',
            'shop_country_id' => 'required',
            'shop_pincode_id' => 'required',

            'shop_mobile' => 'required|unique:vendors_business_details,shop_mobile,' . $id,
            'shop_website' => 'required',
            'shop_email' => 'required|unique:vendors_business_details,shop_email,' . $id,
            'address_proof' => 'required',
            // 'address_proof_image' => 'required',
            'business_license_number' => 'required',
            'gst_number' => 'required',
            'pan_number' => 'required'

        ]);

        DB::beginTransaction();
        try {

            // Store Data
            $user = User::findOrFail($request->user_id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->mobile_number = $request->mobile_number;
            $user->status = $request->status;
            $user->save();

            // Delete Any Existing Role
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();

            // Assign Role To User
            $user->assignRole($user->role_id);

            $vendor = Vendor::findOrFail($id);
            $vendor->address = $request->address;
            $vendor->city_id = $request->city_id;
            $vendor->state_id = $request->state_id;
            $vendor->country_id = $request->country_id;
            $vendor->pincode_id = $request->pincode_id;
            $vendor->save();

            $vendor_bank_details = VendorBankDetails::findOrFail($request->vendor_bank_details_id);
            $vendor_bank_details->account_holder_name = $request->account_holder_name;
            $vendor_bank_details->bank_name = $request->bank_name;
            $vendor_bank_details->account_number = $request->account_number;
            $vendor_bank_details->bank_ifsc_code = $request->bank_ifsc_code;
            $vendor_bank_details->save();

            $vendors_business_details = VendorBusinessDetails::findOrFail($request->vendor_business_details_id);

            $address_proof_image = $vendors_business_details->address_proof_image;
            if ($request->hasFile('address_proof_image')) {

                $image = $request->file('address_proof_image');
                $filename = $user->id . '_' . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/vendor/image');
                $image->move($destinationPath, $filename);

                $address_proof_image = $filename;
            }

            $vendors_business_details->shop_name = $request->shop_name;
            $vendors_business_details->shop_address = $request->shop_address;
            $vendors_business_details->city_id = $request->shop_city_id;
            $vendors_business_details->state_id = $request->shop_state_id;
            $vendors_business_details->country_id = $request->shop_country_id;
            $vendors_business_details->pincode_id = $request->shop_pincode_id;
            $vendors_business_details->shop_mobile = $request->shop_mobile;
            $vendors_business_details->shop_website = $request->shop_website;
            $vendors_business_details->shop_email = $request->shop_email;
            $vendors_business_details->address_proof = $request->address_proof;
            $vendors_business_details->address_proof_image = $address_proof_image;
            $vendors_business_details->business_license_number = $request->business_license_number;
            $vendors_business_details->gst_number = $request->gst_number;
            $vendors_business_details->pan_number = $request->pan_number;
            $vendors_business_details->save();

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('vendors.index')->with('success', 'Vendor Updated Successfully.');

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateStatus($user_id, $status)
    {
        // Validation
        $validate = Validator::make([
            'user_id' => $user_id,
            'status' => $status
        ], [
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:0,1',
        ]);

        // If Validations Fails
        if ($validate->fails()) {
            return redirect()->route('users.index')->with('error', $validate->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Update Status
            User::whereId($user_id)->update(['status' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('vendors.index')->with('success', 'Vendor Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
