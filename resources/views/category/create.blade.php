@extends('layouts.app')
  
@section('title', 'Create Categorys')
  
@section('contents')
    <hr />
    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="category_id" class="form-control" placeholder="Mã">
            </div>
            <div class="col">
                <input type="text" name="category_name" class="form-control" placeholder="Tên">
            </div>
        </div> 
        <div class="row">
            <div class="d-grid m-3">
                <button type="submit" class="btn btn-primary">Thêm</button>
            </div>
            <div class="d-grid m-3">
                <a type="submit" href="{{route('category')}}" class="btn btn-secondary">Hủy</a>
            </div>
        </div>
    </form>
@endsection