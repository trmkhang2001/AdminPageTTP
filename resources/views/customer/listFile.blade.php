@extends('layouts.app')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="h3 mb-0">Danh Mục Hồ Sơ</h1>
        </div>
        <!-- MODAL CREATE FOLDER-->
        <div id="modalFolder" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm thư mục</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="$('#modalFolder').modal('hide')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('customer.drive.createFolder') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <span>Tên thư mục: </span>
                            <input type="text" name="forder_name" id="forder_name">
                            <input type="hidden" name="parent_id" id="parent_id" value="{{ $folder_id }}">
                            <button type="submit" class="btn btn-primary ms-5"><i
                                    class="icon ion-md-folder"></i>&nbsp;Thêm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL UPLOAD FILE-->
        <div id="modalFile" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Chọn file</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="$('#modalFile').modal('hide')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('customer.drive.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file">
                            <input type="hidden" name="forder_id" id="forder_id" value="{{ $folder_id }}">
                            <button type="submit" class="btn btn-primary mx-2 rounded"><i
                                    class="ion ion-md-cloud-upload"></i>&nbsp; Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if (Session::has('error'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('error') }}
            </div>
        @endif
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="btn-group">
            <div class="mx-2">
                <input type="text" id="inputNameFile" onkeyup="searchFile()" class="form-control"
                    placeholder="Search by name" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="mx-2">
                <button class="btn btn-primary" onclick="$('#modalFolder').modal('show')"><i
                        class="icon ion-md-folder"></i>&nbsp;Add Folder</button>
            </div>
            <div class="mx-2">
                <button type="submit" class="btn btn-primary mx-2 rounded" onclick="$('#modalFile').modal('show')"><i
                        class="ion ion-md-cloud-upload"></i>&nbsp; Upload</button>
            </div>
            <a href="{{ route('customer') }}" class="btn btn-secondary mx-2 rounded">Thoát</a>
        </div>
    </div>
    <hr />
    <div class="table-responsive overflow-y: hidden">
        <table class="table table-hover text-nowrap" id="tableFile">
            <thead class="table-primary">
                <tr class="align-middle font-weight-bold text-uppercase">
                    @if ($parentsId != null)
                        <th class="w-100 p-3">
                            <a href="{{ route('customer.listFile', $parentsId) }}"><i class="icon ion-md-rewind"></i></a>
                            <span>Tên File</span>
                        </th>
                    @else
                        <th>
                            <span>Tên File</span>
                        </th>
                    @endif
                    <th>Thời gian sửa đổi gần nhất</th>
                    <th>Tải Xuống</th>
                </tr>
            </thead>
            <tbody>
                @if ($files->count() > 0)
                    @foreach ($files as $file)
                        @if ($file->getMimeType() == 'application/vnd.google-apps.folder')
                            <tr>
                                <td class="align-middle text-dark">
                                    <img src="{{ $file->iconLink }}" alt="">
                                    <a href="{{ route('customer.listFile', $file->id) }}"
                                        class="link-primary text-uppercase font-weight-bold">{{ $file->name }}</a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    @foreach ($files as $file)
                        <tr>
                            @if ($file->getMimeType() != 'application/vnd.google-apps.folder')
                                <td class="align-middle text-dark">
                                    <img src="{{ $file->iconLink }}" alt="">
                                    <a href="{{ $file->webViewLink }}" target="_blank">{{ $file->name }}</a>
                                </td>
                                <td class="align-middle text-dark">
                                    {{ substr($file->modifiedTime, 0, 10) }}
                                </td>
                                @if ($file->fileExtension != null)
                                    <td class="align-middle text-dark">
                                        <a href="{{ $file->webContentLink }}" target="_blank" type="button"
                                            class="btn btn-secondary icon-btn mr-2" disabled=""><i
                                                class="ion ion-md-cloud-download"></i></a>
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            @endif
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="5">Không tìm thấy tài liệu nào</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
