@extends('layouts.app')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="h3 mb-0">Danh Mục Hồ Sơ</h1>
        </div>
        <div class="btn-group">
            <a hreft="#"    type="button" class="btn btn-primary mx-2 rounded" ><i class="ion ion-md-cloud-upload"></i>&nbsp; Upload</a>
            <a href="{{route('customer')}}" class="btn btn-secondary mx-2 rounded">Quay lại</a>
        </div>
    </div>
    <hr />
    <div class="table-responsive overflow-y: hidden">
    <table class="table table-hover text-nowrap">
        <thead class="table-primary">
            <tr class="align-middle font-weight-bold text-uppercase">
                @if($parentsId!=null)
                <th class="w-100 p-3">
                    <a href="{{route('customer.listFile',$parentsId)}}"><i class="file-item-icon file-item-level-up fas fa-level-up-alt text-secondary"></i></a>
                <span>Tên File</span>
                </th>
                @endif
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
                            <a href="{{$file->webContentLink}}" target="_blank" type="button" class="btn btn-secondary icon-btn mr-2" disabled=""><i class="ion ion-md-cloud-download"></i></a>
                            {{-- <a href="{{$file->webContentLink}}" target="_blank" type="button">TẢI</a> --}}
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