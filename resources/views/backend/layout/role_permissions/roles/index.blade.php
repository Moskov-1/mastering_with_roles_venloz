@extends('backend.master')
@session('content')
<table class="table table-bordered table-striped align-middle">
    <thead class="table-light">
        <tr>
            <th style="width: 10%">#</th>
            <th>Name</th>
            <th class="text-end" style="width: 15%">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($roles as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->name }}</td>
                <td class="text-end">
                    <a href="{{ $item->id }}" class="btn btn-sm btn-primary">
                        <i class="ri-edit-2-line"></i> Edit
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsession