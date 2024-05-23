@extends('layouts.app')

@section('title', 'Add Vendors')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Vendors</h1>
            <a href="{{ route('vendors.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                title="Back"><i class="fas fa-arrow-left m-2"></i> </a>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add New User</h6>
            </div>
            <form method="POST" action="{{ route('vendors.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group row">

                        {{-- First Name --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>First Name</label>
                            <input type="text"
                                class="form-control form-control-user @error('first_name') is-invalid @enderror"
                                id="exampleFirstName" placeholder="First Name" name="first_name"
                                value="{{ old('first_name') }}">

                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Last Name --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Last Name</label>
                            <input type="text"
                                class="form-control form-control-user @error('last_name') is-invalid @enderror"
                                id="exampleLastName" placeholder="Last Name" name="last_name"
                                value="{{ old('last_name') }}">

                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Email</label>
                            <input type="email"
                                class="form-control form-control-user @error('email') is-invalid @enderror"
                                id="exampleEmail" placeholder="Email" name="email" value="{{ old('email') }}">

                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Mobile Number --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Mobile Number</label>
                            <input type="text"
                                class="form-control form-control-user @error('mobile_number') is-invalid @enderror"
                                id="exampleMobile" placeholder="Mobile Number" name="mobile_number"
                                value="{{ old('mobile_number') }}">

                            @error('mobile_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-3 mb-sm-0 mt-3">
                            <span style="color:red;">*</span>Country Name</label>
                            <select class="form-control form-control-user @error('country_id') is-invalid @enderror"
                                name="country_id" id="country-id">
                                <option selected disabled>Select Country Name</option>
                            </select>
                            @error('country_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mt-3 mb-sm-0 ">
                            <span style="color:red;">*</span>State Name</label>
                            <select class="form-control form-control-user @error('state_id') is-invalid @enderror"
                                name="state_id" id="state-id">
                                <option selected disabled>Select State Name</option>
                            </select>
                            @error('state_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>City Name</label>
                            <select class="select2 form-control form-control-user @error('city_id') is-invalid @enderror"
                                name="city_id" id="city-id">
                                <option selected disabled>Select City Name</option>
                            </select>
                            @error('city_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-3 mb-sm-0 mt-3">
                            <span style="color:red;">*</span>Pincode</label>
                            <select class="select2 form-control form-control-user @error('pincode_id') is-invalid @enderror"
                                name="pincode_id" id="pincode-id">
                                <option selected disabled>Select Pincode</option>
                            </select>
                            @error('pincode_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Address</label>
                            <textarea class="form-control form-control-user @error('address') is-invalid @enderror" id="exampleAddress"
                                placeholder="Address" name="address">{{ old('address') }}</textarea>

                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Status</label>
                            <select class="form-control form-control-user @error('status') is-invalid @enderror"
                                name="status">
                                <option selected disabled>Select Status</option>
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
                            <h4>Business Information</h4>
                        </div>
                        <hr>

                        {{-- Shop Name --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Shop Name</label>
                            <input type="text"
                                class="form-control form-control-user @error('shop_name') is-invalid @enderror"
                                id="exampleShopName" placeholder="Shop Name" name="shop_name"
                                value="{{ old('shop_name') }}">

                            @error('shop_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Shop Email --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Shop Email</label>
                            <input type="email"
                                class="form-control form-control-user @error('shop_email') is-invalid @enderror"
                                id="exampleShopEmail" placeholder="Shop Email" name="shop_email"
                                value="{{ old('shop_email') }}">

                            @error('shop_email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Shop Mobile --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Shop Mobile</label>
                            <input type="text"
                                class="form-control form-control-user @error('shop_mobile') is-invalid @enderror"
                                id="exampleShopMobile" placeholder="Shop Mobile" name="shop_mobile"
                                value="{{ old('shop_mobile') }}">

                            @error('shop_mobile')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-3 mb-sm-0 mt-3">
                            <span style="color:red;">*</span>Shop Country Name</label>
                            <select class="form-control form-control-user @error('shop_country_id') is-invalid @enderror"
                                name="shop_country_id" id="shop-country-id">
                                <option selected disabled>Select Country Name</option>
                            </select>
                            @error('shop_country_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mt-3 mb-sm-0 ">
                            <span style="color:red;">*</span>Shop State Name</label>
                            <select class="form-control form-control-user @error('shop_state_id') is-invalid @enderror"
                                name="shop_state_id" id="shop-state-id">
                                <option selected disabled>Select State Name</option>
                            </select>
                            @error('shop_state_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Shop City Name</label>
                            <select
                                class="select2 form-control form-control-user @error('shop_city_id') is-invalid @enderror"
                                name="shop_city_id" id="shop-city-id">
                                <option selected disabled>Select City Name</option>
                            </select>
                            @error('shop_city_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-3 mb-sm-0 mt-3">
                            <span style="color:red;">*</span>Shop Pincode</label>
                            <select
                                class="select2 form-control form-control-user @error('shop_pincode_id') is-invalid @enderror"
                                name="shop_pincode_id" id="shop-pincode-id">
                                <option selected disabled>Select Pincode</option>
                            </select>
                            @error('shop_pincode_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Shop Address --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Shop Address</label>
                            <textarea class="form-control form-control-user @error('shop_address') is-invalid @enderror" id="exampleShopAddress"
                                placeholder="Shop Address" name="shop_address">{{ old('shop_address') }}</textarea>

                            @error('shop_address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Shop Website --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Shop Website</label>
                            <input type="text"
                                class="form-control form-control-user @error('shop_website') is-invalid @enderror"
                                id="exampleFShopWebsite" placeholder="Shop Website" name="shop_website"
                                value="{{ old('shop_website') }}">

                            @error('shop_website')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Business License Number --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Business License Number</label>
                            <input type="text"
                                class="form-control form-control-user @error('business_license_number') is-invalid @enderror"
                                id="exampleBusinessLicenseNumber" placeholder="Business License Number"
                                name="business_license_number" value="{{ old('business_license_number') }}">

                            @error('business_license_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- GST Number --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>GST Number</label>
                            <input type="text"
                                class="form-control form-control-user @error('gst_number') is-invalid @enderror"
                                id="exampleGSTNumber" placeholder="GST Number" name="gst_number"
                                value="{{ old('gst_number') }}">

                            @error('gst_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- PAN Number --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>PAN Number</label>
                            <input type="text"
                                class="form-control form-control-user @error('pan_number') is-invalid @enderror"
                                id="examplePANNumber" placeholder="PAN Number" name="pan_number"
                                value="{{ old('pan_number') }}">

                            @error('pan_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Address Proof --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Address Proof</label>
                            <input type="text"
                                class="form-control form-control-user @error('address_proof') is-invalid @enderror"
                                id="exampleAddressProof" placeholder="Address Proof" name="address_proof"
                                value="{{ old('address_proof') }}">

                            @error('address_proof')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Address Proof Image --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Address Proof Image</label>
                            <input type="file"
                                class="form-control form-control-user @error('address_proof_image') is-invalid @enderror"
                                id="exampleAddressProofImage" placeholder="Address Proof Image"
                                name="address_proof_image" value="{{ old('address_proof_image') }}"
                                accept="image/png, image/gif, image/jpeg">

                            @error('address_proof_image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
                            <h4>Bank Information</h4>
                        </div>
                        <hr>

                        {{-- Account Holder Name --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Account Holder Name</label>
                            <input type="text"
                                class="form-control form-control-user @error('account_holder_name') is-invalid @enderror"
                                id="exampleAccountHolderName" placeholder="Account Holder Name"
                                name="account_holder_name" value="{{ old('account_holder_name') }}">

                            @error('account_holder_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Bank Name --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Bank Name</label>
                            <input type="text"
                                class="form-control form-control-user @error('bank_name') is-invalid @enderror"
                                id="exampleBankName" placeholder="Bank Name" name="bank_name"
                                value="{{ old('bank_name') }}">

                            @error('bank_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Account Number --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Account Number</label>
                            <input type="text"
                                class="form-control form-control-user @error('account_number') is-invalid @enderror"
                                id="exampleAccountNumber" placeholder="Account Number" name="account_number"
                                value="{{ old('account_number') }}">

                            @error('account_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Bank IFSC Code --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Bank IFSC Code</label>
                            <input type="text"
                                class="form-control form-control-user @error('bank_ifsc_code') is-invalid @enderror"
                                id="exampleBankIFSCCode" placeholder="Bank IFSC Code" name="bank_ifsc_code"
                                value="{{ old('bank_ifsc_code') }}">

                            @error('bank_ifsc_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('vendors.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        jQuery("#country-id").select2();
        jQuery("#state-id").select2();
        jQuery("#city-id").select2();
        jQuery("#pincode-id").select2();

        jQuery("#shop-country-id").select2();
        jQuery("#shop-state-id").select2();
        jQuery("#shop-city-id").select2();
        jQuery("#shop-pincode-id").select2();

        load_countries('country-id');
        load_states('state-id');
        load_cities('city-id');
        load_pincodes('pincode-id');

        load_countries('shop-country-id');
        load_states('shop-state-id');
        load_cities('shop-city-id');
        load_pincodes('shop-pincode-id');

        jQuery("#country-id").on('change', function() {
            jQuery("#state-id").val('');
            jQuery("#city-id").val('');
            jQuery("#pincode-id").val('');

            var country_id = jQuery(this).val();
            load_states('state-id', country_id);
        });

        jQuery("#shop-country-id").on('change', function() {
            jQuery("#shop-state-id").val('');
            jQuery("#shop-city-id").val('');
            jQuery("#shop-pincode-id").val('');

            var country_id = jQuery(this).val();
            load_states('shop-state-id', country_id);
        });

        jQuery("#state-id").on('change', function() {
            jQuery("#city-id").val('');
            jQuery("#pincode-id").val('');

            var state_id = jQuery(this).val();
            load_cities('city-id', state_id);
        });

        jQuery("#shop-state-id").on('change', function() {
            jQuery("#shop-city-id").val('');
            jQuery("#shop-pincode-id").val('');

            var state_id = jQuery(this).val();
            load_cities('shop-city-id', state_id);
        });

        jQuery("#city-id").on('change', function() {
            jQuery("#pincode-id").val('');

            var city_id = jQuery(this).val();
            load_pincodes('pincode-id', city_id);
        });

        jQuery("#shop-city-id").on('change', function() {
            jQuery("#shop-pincode-id").val('');

            var city_id = jQuery(this).val();
            load_pincodes('shop-pincode-id', city_id);
        });
    </script>

@endsection
