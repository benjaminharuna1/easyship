@extends('layouts.admin')

@section('title', 'Admin Profile')

@section('content')

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Admin Profile</h5>
            <table class="table align-middle mb-3">
                <tr>
                    <th style="width:150px;">Email</th>
                    <td>{{ $admin->email }}</td>
                </tr>
            </table>
            <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
        </div>
    </div>

@endsection
