@extends('layouts.admin')

@section('title', 'Shipments List')

@section('content')
@php use Illuminate\Support\Str; @endphp

    <div class="card radius-10">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <h5 class="mb-0">All Shipments</h5>
                <a href="{{ route('admin.shipments.create') }}" class="btn btn-primary btn-sm ms-auto">Add Tracking</a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Package Image</th>
                            <th>Package name</th>
                            <th>Tracking Number</th>
                            <th>Status</th>
                            <th>Date Added</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Copy</th>
                            <th>Print Receipt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shipments as $i => $row)
                            @php
                                $imagePath = $row->image ? asset('uploads/' . $row->image) : 'https://placehold.co/100x60/EEE/31343C.png?text=Package';
                            @endphp
                            <tr>
                                <td>{{ $shipments->firstItem() + $i }}</td>
                                <td><img src="{{ $imagePath }}" alt="" width="100" height="60"></td>
                                <td>
                                    <div class="ms-2">
                                        <h6 class="mb-1 font-14">{{ $row->package_discription }}</h6>
                                    </div>
                                </td>
                                <td>{{ $row->tracking_id }}</td>
                                <td>{{ $row->status }}</td>
                                <td>{{ $row->date_added }}</td>
                                <td>
                                    <a class="badge rounded-pill bg-primary p-2 text-white text-decoration-none" href="{{ route('admin.shipments.edit', $row->tracking_id) }}">Update</a>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('admin.shipments.destroy', $row->tracking_id) }}" onsubmit="return confirm('Do you really want to delete this ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="badge rounded-pill bg-danger p-2 text-white border-0">Delete</button>
                                    </form>
                                </td>
                                <td>
                                    <button type="button" class="badge rounded-pill bg-info border-0" onclick="copyContent('{{ $row->tracking_id }}')">Copy Tracking Number</button>
                                </td>
                                <td>
                                    <a class="badge rounded-pill bg-primary p-2 text-white text-decoration-none" target="_blank" href="{{ route('track.print', $row->tracking_id) }}">Print Receipt</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="10" class="text-center text-muted">No shipments found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $shipments->links() }}
            </div>
        </div>
    </div>

    <script>
        function copyContent(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert("Tracking Number Copied: " + text);
            }, function(err) {
                console.error('Failed to copy: ', err);
            });
        }
    </script>

@endsection
