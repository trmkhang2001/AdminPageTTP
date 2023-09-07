@extends('layouts.app')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="h3 mb-0">Danh Sách Loại Nhân Sự</h1>
        <a href="{{ route('category.create') }}" class="btn btn-primary">Thêm loại nhân sự</a>
    </div>
    <hr />
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>STT</th>
                <th>Mã</th>
                <th>Loại Nhân Sự</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if ($category->count() > 0)
                @foreach ($category as $ct)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $ct->category_id }}</td>
                        <td class="align-middle">{{ $ct->category_name }}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('category.edit', $ct->id) }}" type="button"
                                    class="btn btn-warning">Edit</a>
                                <form action="{{ route('catetgory.destroy', $ct->id) }}" method="POST" type="button"
                                    class="btn btn-danger p-0" onsubmit="return confirm('Bạn chắc chắn muốn xóa ?')">
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
                    <td class="text-center" colspan="5">Không tìm loại nhân sự nào</td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection
