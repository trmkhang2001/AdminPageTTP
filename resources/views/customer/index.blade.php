@extends('layouts.app')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="h3 mb-0">Danh Sách Khách Hàng</h1>
        <a href="{{route('customer.create')}}" class="btn btn-primary">Thêm Khách Hàng</a>
    </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <div class="table-responsive overflow-y: hidden">
    <table class="table table-hover text-nowrap">
        <thead class="table-primary">
            <tr>
                <th>STT</th>
                <th>Mã Khách Hàng</th>
                <th>Tên Khách Hàng</th>
                <th>Số Điện Thoại</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($customer->count() > 0)
                @foreach($customer as $cus)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $cus->ma }}</td>
                        <td class="align-middle">{{ $cus->name }}</td>
                        <td class="align-middle">{{ $cus->phone }}</td>
                        <td class="align-middle">{{ $cus->email }}</td>
                        <td class="align-middle">{{ $cus->address}}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="#" type="button" class="btn btn-secondary">Detail</a>
                                <a href="#" type="button" class="btn btn-warning">Edit</a>
                                <form action="#" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Bạn chắc chắn muốn xóa ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-0">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">Không tìm thấy nhân viên nào</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection