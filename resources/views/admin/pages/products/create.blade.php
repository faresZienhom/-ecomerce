@extends('admin.layout.app')

@section('title','Products Page')


@section('content')


<form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    @include('admin.pages.products._form')
</form>


@endsection
