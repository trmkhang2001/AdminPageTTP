@extends('layouts.app')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="h3 mb-0">Danh Sách Nhân Viên</h1>
        <a href="{{route('employee.create')}}" class="btn btn-primary">Thêm Nhân Viên</a>
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
                <th>Mã Nhân Viên</th>
                <th>Tên Nhân Viên</th>
                <th>Số Điện Thoại</th>
                <th>Email</th>
                <th>Loại Nhân Sự</th>
                <th>Địa chỉ</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($employee->count() > 0)
                @foreach($employee as $ep)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $ep->ma }}</td>
                        <td class="align-middle">{{ $ep->name }}</td>
                        <td class="align-middle">{{ $ep->phone }}</td>
                        <td class="align-middle">{{ $ep->email }}</td>
                        <td class="align-middle">
                            @foreach ($category as $ct)
                                @if ($ct->category_id==$ep->category_id)
                                    {{$ct->category_name}}
                                @endif
                            @endforeach
                        </td>
                        <td class="align-middle">{{$ep->address}}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{route('employee.show',$ep->id)}}" type="button" class="btn btn-secondary">Detail</a>
                                <a href="{{route('employee.edit',$ep->id)}}" type="button" class="btn btn-warning">Edit</a>
                                <form action="{{route('employee.destroy',$ep->id)}}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Bạn chắc chắn muốn xóa ?')">
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