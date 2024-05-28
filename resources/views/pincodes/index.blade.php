@extends('layouts.app')

@section('title', 'Pincode List')
@section('search_for', 'pincode')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pincode</h1>
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('pincodes.create') }}" class="btn btn-sm btn-primary" title="Add New">
                        <i class="fas fa-plus m-2"></i>
                    </a>
                </div>
                {{-- <div class="col-md-6">
                    <a href="{{ route('pincodes-export') }}" class="btn btn-sm btn-success " title="Export To Excel">
                        <i class="fas fa-file-export m-2"></i>
                    </a>
                </div> --}}

            </div>

        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Pincodes</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                {{-- <th>Flag</th> --}}
                                <th>Pincode</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($pincodes))
                                @foreach ($pincodes as $pincode)
                                    <tr>
                                        {{-- <td>{{ $country->flage }}</td> --}}
                                        <td>{{ $pincode->pincode }}</td>
                                        <td>{{ $pincode->city->name }}</td>
                                        <td>{{ $pincode->city->state->name }}</td>
                                        <td style="display: flex">
                                            <a href="{{ route('pincodes.edit', ['pincode' => $pincode->id]) }}"
                                                class="btn btn-primary m-2">
                                                <i class="fa fa-pen"></i>
                                            </a>
                                            <form method="POST"
                                                action="{{ route('pincodes.destroy', ['pincode' => $pincode->id]) }}">
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

                    {{ $pincodes->links() }}
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')

@endsection
