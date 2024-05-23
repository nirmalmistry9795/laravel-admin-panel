@extends('layouts.app')

@section('title', 'City List')
@section('search_for', 'city')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">City</h1>
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('cities.create') }}" class="btn btn-sm btn-primary" title="Add New">
                        <i class="fas fa-plus m-2"></i>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('cities-export') }}" class="btn btn-sm btn-success" title="Export To Excel">
                        <i class="fas fa-file-export m-2"></i>
                    </a>
                </div>

            </div>

        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Cities</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                {{-- <th>Flag</th> --}}
                                <th>Name</th>
                                <th>State</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($cities))
                                @foreach ($cities as $city)
                                    <tr>
                                        {{-- <td>{{ $country->flage }}</td> --}}
                                        <td>{{ $city->name }}</td>
                                        <td>{{ $city->state->name }}</td>
                                        <td style="display: flex">
                                            <a href="{{ route('cities.edit', ['city' => $city->id]) }}"
                                                class="btn btn-primary m-2">
                                                <i class="fa fa-pen"></i>
                                            </a>
                                            <form method="POST"
                                                action="{{ route('cities.destroy', ['city' => $city->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger m-2" type="submit">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <p>No Record Found.</p>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    {{ $cities->links() }}
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')

@endsection
