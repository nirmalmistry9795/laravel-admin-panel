@extends('layouts.app')

@section('title', 'Add Country')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add Country</h1>
        <a href="{{route('countries.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')
   
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Country</h6>
        </div>
        <form method="POST" action="{{route('countries.store')}}">
            @csrf
            <div class="card-body">
                <div class="form-group row">

                    {{-- Country Name --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span> Name</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('country_name') is-invalid @enderror" 
                            id="exampleCountryName"
                            placeholder="Country Name" 
                            name="country_name" 
                            value="{{ old('country_name') }}">

                        @error('country_name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- short Name --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span> Short Name</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('short_name') is-invalid @enderror" 
                            id="exampleShortName"
                            placeholder="Short Name" 
                            name="short_name" 
                            value="{{ old('short_name') }}">

                        @error('short_name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- phone code --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span> Phone Code</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('phonecode') is-invalid @enderror" 
                            id="examplePhoneCode"
                            placeholder="Phone Code" 
                            name="phonecode" 
                            value="{{ old('phonecode') }}">

                        @error('phonecode')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Continent --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span> Continent</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('continent') is-invalid @enderror" 
                            id="exampleContinent"
                            placeholder="Continent" 
                            name="continent" 
                            value="{{ old('continent') }}">

                        @error('continent')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('countries.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection