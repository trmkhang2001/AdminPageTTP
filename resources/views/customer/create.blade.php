@extends('layouts.app')
  
@section('title', 'Thêm Khách Hàng')
  
@section('contents')
    <hr />
    <form action="{{route('customer.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="ma" class="form-control" placeholder="Mã khách hàng">
            </div>
            <div class="col">
                <input type="text" name="name" class="form-control" placeholder="Tên khách hàng">
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
                <select class="form-select custom-select" name="loai_dv">
                    <option selected>Dịch vụ tư vấn</option>
                    @foreach ($dichvu as $dv)
                    <option value="{{$dv->ma}}">{{$dv->name}}</option>
                    @endforeach
                </select>
            </div>      
        </div>
        <div class="row mb-3">
                <div class="d-grid m-3">
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
                <div class="d-grid m-3">
                    <a type="submit" href="{{route('customer')}}" class="btn btn-secondary">Hủy</a>
                </div>
        </div> 
    </form>
@endsection