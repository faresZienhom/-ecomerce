@extends('admin.layout.app')

@section('title','Categories Page')

@section('content')
<a class="btn btn-warning mb-5" href="{{ route('dashboard.categories.create') }}">Add Category</a>
<a class="btn btn-warning mb-5" href="{{ route('dashboard.categories.trash') }}" >Trash</a>


<form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
    <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
    <select name="status" class="form-control mx-2">
        <option value="">All</option>
        <option value="active" @selected(request('status') == 'active')>Active</option>
        <option value="archived" @selected(request('status') == 'archived')>Archived</option>
    </select>
    <button class="btn btn-dark mx-2">Filter</button>
</form>

<table class="table">
    <thead>
        <tr>
            <th>image</th>
            <th>ID</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Products #</th>
            <th>Status</th>
            <th>Created At</th>
            <th colspan="2">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td><img src="{{asset("images/categories/" . $category->image)}}" width="50" height="50"></td>
            <td>{{ $category->id }}</td>
            <td><a href="{{ route('dashboard.categories.show', $category->id) }}">{{ $category->name }}</a></td>
            <td>{{ $category->parent->name }}</td>
            <td>{{ $category->products_number }}</td>
            <td>{{ $category->status }}</td>
            <td>{{ $category->created_at }}</td>
            <td class="d-flex">
                <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="post">
                    @method('DELETE')
                    @csrf
                    <button class="delete-category btn btn-danger" type="submit">delete</button>
                </form>
                <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="btn btn-warning">update</a>
            </td>
</tr>
        @empty
        <tr>
            <td colspan="9">No categories defined.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $categories->withQueryString()->appends(['search' => 1])->links() }}

@endsection
