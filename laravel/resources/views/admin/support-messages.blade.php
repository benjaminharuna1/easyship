@extends('layouts.admin')

@section('title', 'Support Messages')

@section('content')

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Support Messages</h5>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Company</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $i => $msg)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $msg->name }}</td>
                                <td>{{ $msg->email }}</td>
                                <td>{{ $msg->mobile }}</td>
                                <td>{{ $msg->company }}</td>
                                <td>{{ $msg->message }}</td>
                                <td>{{ $msg->created_at ? $msg->created_at->format('d M Y') : '' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted">No support messages.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
