@extends('layouts.app')

@section('title', 'Edit Categorys')

@section('contents')
    <hr />
    <form action="{{ route('catetgory.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col">
                Mã
                <input type="text" name="category_id" class="form-control" placeholder="Mã"
                    value="{{ $category->category_id }}">
            </div>
            <div class="col">
                Tên
                <input type="text" name="category_name" class="form-control" placeholder="Tên"
                    value="{{ $category->category_name }}">
            </div>
        </div>
        <div class="row">
            <div class="d-grid m-3">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </div>
            <div class="d-grid m-3">
                <a type="submit" href="{{ route('category') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </div>
    </form>
@endsection
