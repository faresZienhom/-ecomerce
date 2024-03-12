@extends('admin.layout.app')

@section('title','Create Page')

@section('content')

<form action="{{ route('dashboard.roles.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    @include('admin.pages.roles._form')
</form>

@endsection
