@extends('layouts.app')

@section('contents')
    <!-- MODAL CREATE CUSTOMER-->
    <div id="modalCreateCustomer" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Khách Hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="$('#modalCreateCustomer').modal('hide')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
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
                                        <option value="{{ $dv->ma }}">{{ $dv->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Thêm</button>
                            </div>
                            <div class="col d-flex justify-content-center">
                                <a type="submit" href="{{ route('customer') }}" class="btn btn-secondary">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL CONTTENT CUSTOMER-->
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="h3 mb-0">Danh Sách Khách Hàng</h1>
        <div class="btn-group">
            <div class="mx-2">
                <input type="text" id="inputMa" onkeyup="searchKH()" class="form-control"
                    placeholder="Search by mã khách hàng" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="mx-2">
                <button type="submit" class="btn btn-primary mx-2 rounded"
                    onclick="$('#modalCreateCustomer').modal('show')">
                    <i class="icon ion-md-person"></i>
                    <span>Thêm Khách Hàng</span>
                </button>
            </div>
        </div>
    </div>
    <hr />
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <div class="table-responsive overflow-y: hidden">
        <table class="table table-hover text-nowrap" id="tableKH">
            <thead class="table-primary">
                <tr>
                    <th>STT</th>
                    <th>Mã Khách Hàng</th>
                    <th>Tên Khách Hàng</th>
                    <th>Số Điện Thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Hồ sơ</th>
                </tr>
            </thead>
            <tbody>
                @if ($customer->count() > 0)
                    @foreach ($customer as $cus)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle" id="maKh">{{ $cus->ma }}</td>
                            <td class="align-middle">{{ $cus->name }}</td>
                            <td class="align-middle">{{ $cus->phone }}</td>
                            <td class="align-middle">{{ $cus->email }}</td>
                            <td class="align-middle">{{ $cus->address }}</td>
                            <td class="align-middle">
                                <div class="btn-group">
                                    <a href="{{ route('customer.listFile', $cus->folder_id) }}" type="button"
                                        class="btn btn-success">Xem</a>
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
