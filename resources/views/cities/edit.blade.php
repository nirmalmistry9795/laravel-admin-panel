@extends('layouts.app')

@section('title', 'Edit City')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit City</h1>
            <a href="{{ route('cities.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit City</h6>
            </div>
            <form method="POST" action="{{ route('cities.update', ['city' => $city->id]) }}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group row">

                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <span style="color:red;">*</span>State Name</label>
                            <select class="form-control form-control-user @error('state_id') is-invalid @enderror"
                                name="state_id">
                                <option selected disabled>Select State Name</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}"
                                        {{ old('state_id') ? (old('state_id') == $state->id ? 'selected' : '') : ($city->state_id == $state->id ? 'selected' : '') }}>
                                        {{ $state->name }}</option>
                                @endforeach

                            </select>
                            @error('state_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- City Name --}}
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <span style="color:red;">*</span> Name</label>
                            <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror"
                                id="exampleName" placeholder="City Name" name="name"
                                value="{{ old('name') ? old('name') : $city->name }}">

                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">Update</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('cities.index') }}">Cancel</a>
                </div>
            </form>
        </div>

    </div>


@endsection
