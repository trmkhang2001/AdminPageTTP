@extends('layouts.app')
  
@section('title', 'Thay đổi thông tin nhân viên')
  
@section('contents')
    <hr />
    <form action="{{route('employee.update',$employee->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <span>Mã nhân viên</span> 
                <input type="text" name="ma" class="form-control" value="{{$employee->ma}}">
            </div>
            <div class="col">
                <span>Tên nhân viên</span> 
                <input type="text" name="name" class="form-control" value="{{$employee->name}}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <span>Địa chỉ</span> 
                <input type="text" name="address" class="form-control" value="{{$employee->address}}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <span>Số điện thoại</span> 
                <input type="phone" name="phone" class="form-control" value="{{$employee->phone}}">
            </div>
            <div class="col">
                <span>Email</span> 
                <input type="email" name="email" class="form-control" value="{{$employee->email}}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <span>Chức danh</span>
                <select class="form-select custom-select" name="category_id">
                    @foreach ($category as $ct)
                    @if ($ct->category_id==$employee->category_id)
                    <option selected value="{{$ct->category_id}}">{{$ct->category_name}}</option>
                    @else
                    <option value="{{$ct->category_id}}">{{$ct->category_name}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col">
                <span>Người phụ trách</span>
                <select class="form-select custom-select" name="charge_id">
                    @if ($employee->charge_id==1)
                        <option selected value="1">Giám Đốc</option>
                        <option value="2">Quản Lý Văn Phòng</option>
                    @else
                        <option value="1">Giám Đốc</option>
                        <option selected value="2">Quản Lý Văn Phòng</option>
                    @endif
                </select>
            </div>       
        </div>
        <div class="row">
            <div class="d-grid m-3">
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
            <div class="d-grid m-3">
                <a href="{{route('employee')}}" class="btn btn-secondary">Hủy</a>
            </div>
        </div>
    </form>
@endsection