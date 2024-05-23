@extends('layouts.app')

@section('title', 'Edit State')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit State</h1>
            <a href="{{ route('states.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit State</h6>
            </div>
            <form method="POST" action="{{ route('states.update', ['state' => $state->id]) }}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group row">

                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <span style="color:red;">*</span>Country Name</label>
                            <select class="form-control form-control-user @error('country_id') is-invalid @enderror"
                                name="country_id">
                                <option selected disabled>Select Country Name</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ old('country_id') ? (old('country_id') == $country->id ? 'selected' : '') : ($state->country_id == $country->id ? 'selected' : '') }}>
                                        {{ $country->country_name }}</option>
                                @endforeach

                            </select>
                            @error('country_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- State Name --}}
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <span style="color:red;">*</span> Name</label>
                            <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror"
                                id="exampleName" placeholder="State Name" name="name"
                                value="{{ old('name') ? old('name') : $state->name }}">

                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">Update</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('states.index') }}">Cancel</a>
                </div>
            </form>
        </div>

    </div>


@endsection
