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
                            <th>Last Updated</th>
                            <th>Actions</th>
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
                                <td>
                                    <div class="d-flex align-items-center gap-1">
                                        <span>{{ $row->tracking_id }}</span>
                                        <button type="button" class="btn btn-sm btn-link p-0 border-0" title="Copy tracking number" onclick="copyContent('{{ $row->tracking_id }}')"><i class="bx bx-copy"></i></button>
                                    </div>
                                </td>
                                <td>{{ $row->status }}</td>
                                <td>{{ $row->updated_at ? $row->updated_at->format('d M Y H:i') : ($row->date_added ?: 'N/A') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('admin.shipments.edit', $row->tracking_id) }}"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                            <li>
                                                <form method="POST" action="{{ route('admin.shipments.destroy', $row->tracking_id) }}" onsubmit="return confirm('Do you really want to delete this ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"><i class="bx bx-trash me-2"></i>Delete</button>
                                                </form>
                                            </li>
                                            <li><a class="dropdown-item" target="_blank" href="{{ route('track.print', $row->tracking_id) }}"><i class="bx bx-printer me-2"></i>Print Receipt</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted">No shipments found.</td></tr>
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
