@extends('layouts.app')

@section('title', 'Edit Pincode')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Pincode</h1>
            <a href="{{ route('pincodes.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Pincode</h6>
            </div>
            <form method="POST" action="{{ route('pincodes.update', ['pincode' => $pincode->id]) }}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group row">

                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <span style="color:red;">*</span>City Name</label>
                            <select class="select2 form-control form-control-user @error('city_id') is-invalid @enderror"
                                name="city_id" id="city-id">
                                <option value="{{ $pincode->city_id }}" selected>{{ $pincode->city->name }}</option>
                            </select>
                            @error('city_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Pincode Name --}}
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <span style="color:red;">*</span>Pincode</label>
                            <input type="text"
                                class="form-control form-control-user @error('pincode') is-invalid @enderror"
                                id="exampleName" placeholder="Enter Pincode" name="pincode"
                                value="{{ old('pincode') ? old('pincode') : $pincode->pincode }}">

                            @error('pincode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">Update</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('pincodes.index') }}">Cancel</a>
                </div>
            </form>
        </div>

    </div>


@endsection

@section('scripts')

    <script>
        jQuery("#city-id").select2();
        load_cities('city-id');

        function load_cities(id) {
            $("#" + id).select2({
                ajax: {
                    url: "{{ route('getCities') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            // branch_id: branch,
                            // type: type
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                placeholder: "Select City Name",
                allowClear: true
            });
        }
    </script>

@endsection
