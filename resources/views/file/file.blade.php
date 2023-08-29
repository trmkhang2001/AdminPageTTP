@extends('layouts.app')
  
@section('title', 'Upfile')
  
@section('contents')
    <hr />
    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <input type="file" name="ma" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
                <div class="d-grid m-3">
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
                <div class="d-grid m-3">
                    <a type="submit" href="#" class="btn btn-secondary">Hủy</a>
                </div>
        </div> 
    </form>
@endsection