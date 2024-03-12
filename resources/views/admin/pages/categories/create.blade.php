@extends('admin.layout.app')

@section('title','Create Categories')

@section('content')
@if(session()->has('success'))
<div class=" alert alert-success">
   {{ session()->get('success') }}
</div>
@endif

@if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


<a class="btn btn-warning mb-5" href="{{ route('dashboard.categories.index') }}">categories list</a>




    <form action="{{ route('dashboard.categories.store') }}" method="post" class="py-2" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="name" class="form-label">Name:</label>
            <input type="text" value="{{ old('name') }}" class="form-control w-50" name="name" id="name">
        </div>
        <div class="form-group">
            <label for="">Category Parent</label>
            <select name="parent_id" class="form-control w-50">
                <option value="">Primary Category</option>
                @foreach($parents as $parent)
                <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="description" class="form-label">Description:</label>
            <textarea type="text" class="form-control w-50" name="description" value="{{ old('description') }}" id="description"></textarea>
        </div>
            <label for="exampleInputFile">Image</label>
            <div class="input-group w-50">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="image" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">Upload</label>
                </div>
            </div>
            <div class="form-group">
                <label for="">Status</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" value="Active" checked>
                <label class="form-check-label" for="flexRadioDefault1">
                  Active
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="status" value="archived" checked>
                <label class="form-check-label" for="flexRadioDefault2">
                    archived
                </label>
              </div>
            </div>

            <button class="btn btn-primary">save</button>

    </form>
@endsection
