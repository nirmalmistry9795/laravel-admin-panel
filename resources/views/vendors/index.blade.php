@extends('layouts.app')

@section('title', 'Vendor List')
@section('search_for', 'vendor')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Vendors</h1>
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('vendors.create') }}" class="btn btn-sm btn-primary" title="Add New">
                        <i class="fas fa-plus m-2"></i>
                    </a>
                </div>
                {{-- <div class="col-md-6">
                    <a href="{{ route('vendors.export') }}" class="btn btn-sm btn-success" title="Export To Excel">
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
                <h6 class="m-0 font-weight-bold text-primary">All Vendors</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="20%">Name</th>
                                <th width="25%">Email</th>
                                <th width="15%">Mobile</th>
                                <th width="15%">Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($vendors))
                                @foreach ($vendors as $vendor)
                                    <tr>
                                        <td>{{ $vendor->user->full_name }}</td>
                                        <td>{{ $vendor->user->email }}</td>
                                        <td>{{ $vendor->user->mobile_number }}</td>
                                        <td>
                                            @if ($vendor->user->status == 0)
                                                <span class="badge badge-danger">Inactive</span>
                                            @elseif ($vendor->user->status == 1)
                                                <span class="badge badge-success">Active</span>
                                            @endif
                                        </td>
                                        <td style="display: flex">
                                            @hasrole('Admin')
                                                @if ($vendor->user->status == 0)
                                                    <a href="{{ route('vendors-status', ['user_id' => $vendor->user_id, 'status' => 1]) }}"
                                                        class="btn btn-success m-2">
                                                        <i class="fa fa-check"></i>
                                                    </a>
                                                @elseif ($vendor->user->status == 1)
                                                    <a href="{{ route('vendors-status', ['user_id' => $vendor->user_id, 'status' => 0]) }}"
                                                        class="btn btn-danger m-2">
                                                        <i class="fa fa-ban"></i>
                                                    </a>
                                                @endif
                                            @endhasrole

                                            <a href="{{ route('vendors.edit', ['vendor' => $vendor->id]) }}"
                                                class="btn btn-primary m-2">
                                                <i class="fa fa-pen"></i>
                                            </a>

                                            @hasrole('Admin')
                                                <form method="POST"
                                                    action="{{ route('vendors.destroy', ['vendor' => $vendor->id]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger m-2" type="submit">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endhasrole
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

                    {{ $vendors->links() }}
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')

@endsection
