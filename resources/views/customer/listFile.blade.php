@extends('layouts.app')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="h3 mb-0">Danh Mục Hồ Sơ</h1>
        <div class="btn-group">
            <a href="#" type="button" class="btn btn-primary mx-2">Thêm tài liệu</a>
        </div>
        <div class="btn-group">
            <a href="#" type="button" class="btn btn-primary mx-2">Thêm thư mục</a>
        </div>
        <div class="btn-group">
            <a href="{{route('customer')}}" class="btn btn-secondary mx-2">Quay lại</a>
        </div>
    </div>
    <hr />
    <div class="table-responsive overflow-y: hidden">
    <table class="table table-hover text-nowrap">
        <thead class="table-primary">
            <tr class="align-middle font-weight-bold text-uppercase">
                <th>
                    @foreach ($folder as $f)
                        @if($folder->count()==1)
                            <a href="{{route('customer.listFile',$f->folder_id_parent)}}"><img src="{{asset('admin_assets/img/skip-back.svg')}}" alt=""></a>
                            @break
                        @endif
                    @endforeach
                    Tên file
                </th>
                <th>Thời gian sửa đổi gần nhất</th>
                <th>Tải Xuống</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($files->count() > 0)
                @foreach($files as $file)
                    <tr>
                        <td class="align-middle text-dark"> 
                            @if ($file->getMimeType()=='application/vnd.google-apps.folder')
                                <img src="{{$file->iconLink}}" alt="">
                                <a href="{{route('customer.listFile',$file->id)}}" class="link-primary text-uppercase font-weight-bold">{{$file->name}}</a>
                            @else
                            <img src="{{$file->iconLink}}" alt="">
                            {{$file->name}}
                            @endif
                        </td>
                        <td class="align-middle text-dark">
                            {{substr($file->modifiedTime,0,10)}} 
                        </td>
                        @if($file->fileExtension != null)
                        <td class="align-middle text-dark">
                            <a href="{{$file->webContentLink}}" target="_blank" type="button">TẢI</a>
                        </td>
                        @else
                        <td></td>
                        @endif
                        <td class="align-middle">
                            @if ($file->getMimeType()!='application/vnd.google-apps.folder')
                            <div class="btn-group">
                                <a href="{{$file->webViewLink}}" target="_blank" type="button" class="btn btn-success">Xem</a>
                            </div>
                            @endif
                        </td>
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