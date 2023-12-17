@extends('layouts.app')
  
@section('title', 'Danh Sách Sinh Viên')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        
        <a href="{{ route('products.create') }}" class="btn btn-primary">Thêm SV</a>
    </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Họ và tên</th>
                <th>MSSV</th>
                <th>Đơn vị </th>
                <th>Tên lớp</th>
                <th>Cap Bac</th>
                <th>Khóa</th>
                <th>Tình trạng</th>
            </tr>
        </thead>
        <tbody>
            @if(count($trainee) > 0)
                @foreach($trainee as $rs)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $rs->HoTen }}</td>
                        <td class="align-middle">{{ $rs->id }}</td>
                        <td class="align-middle">{{ $rs->TenDonVi}}</td>
                        <td class="align-middle">{{ $rs->TenLop }}</td>
                        <td class="align-middle">{{ $rs->CapBac }}</td>
                        <td class="align-middle">{{ $rs->ThoiGianBatDau }}</td>  
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                
                                <form action="{{ route('products.destroy', $rs->id) }}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-0">Xóa SV</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">Không có sinh viên nào!</td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection