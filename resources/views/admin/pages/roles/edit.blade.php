@extends('admin.layout.app')

@section('title','Update Page')

@section('content')

<form action="{{ route('dashboard.roles.update', $role->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    @include('admin.pages.roles._form', [
        'button_label' => 'Update'
    ])
</form>

@endsection
