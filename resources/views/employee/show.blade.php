@extends('layouts.app')
  
@section('contents')
    <h1 class="mb-0">Nhân viên  {{$employee->name}}</h1>
    <hr />
    <div class="row mb-3">
        <div class="col">
            <span>Mã nhân viên</span> 
            <input type="text" name="ma" class="form-control" placeholder="{{$employee->ma}}" readonly>
        </div>
        <div class="col">
            <span>Tên nhân viên</span> 
            <input type="text" name="name" class="form-control" placeholder="{{$employee->name}}" readonly>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <span>Địa chỉ</span> 
            <input type="text" name="address" class="form-control" placeholder="{{$employee->address}}" readonly>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <span>Số điện thoại</span> 
            <input type="phone" name="phone" class="form-control" placeholder="{{$employee->phone}}" readonly>
        </div>
        <div class="col">
            <span>Email</span> 
            <input type="email" name="email" class="form-control" placeholder="{{$employee->email}}" readonly>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <span>Chức danh:</span>
            <input type="email" name="email" class="form-control" @foreach ($category as $ct)
                @if ($ct->category_id==$employee->category_id)
                placeholder=" {{$ct->category_name}}"
                @endif
            @endforeach readonly>
        </div>
        <div class="col">
            <span>Người phụ trách:</span>
            <input type="email" name="email" class="form-control" @if ($employee->charge_id==1)
                placeholder="Giám Đốc"                
            @else
                placeholder="Quản Lý Văn Phòng"
            @endif readonly>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a type="submit" href="{{route('employee')}}" class="btn btn-secondary">Hủy</a>
        </div>
    </div>
@endsection