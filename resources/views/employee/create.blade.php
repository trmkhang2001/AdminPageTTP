@extends('layouts.app')
  
@section('title', 'Thêm Nhân Viên')
  
@section('contents')
    <hr />
    <form action="{{route('employee.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="ma" class="form-control" placeholder="Mã nhân viên">
            </div>
            <div class="col">
                <input type="text" name="name" class="form-control" placeholder="Tên nhân viên">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="address" class="form-control" placeholder="Địa chỉ liên hệ">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="phone" name="phone" class="form-control" placeholder="Số điện thoại">
            </div>
            <div class="col">
                <input type="email" name="email" class="form-control" placeholder="Email">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <select class="form-select custom-select" name="category_id">
                    <option selected>Phân loại</option>
                    @foreach ($category as $ct)
                    <option value="{{$ct->category_id}}">{{$ct->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <select class="form-select custom-select" name="charge_id">
                    <option selected>Người phụ trách</option>
                    <option value="1">Giám Đốc</option>
                    <option value="2">Quản Lý Văn Phòng</option>
                </select>
            </div>       
        </div>
        <div class="row mb-3">
                <div class="d-grid m-3">
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
                <div class="d-grid m-3">
                    <a type="submit" href="{{route('employee')}}" class="btn btn-secondary">Hủy</a>
                </div>
        </div> 
    </form>
@endsection