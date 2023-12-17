@extends('layouts.app')
  
@section('title', 'Thời khóa biểu')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@section('contents')
<meta name="csrf-token" content="{{ csrf_token() }}">

   
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
                <th>Tên nội dung</th>
                <th>Số tiết</th>
                <th>Môn học</th>
                <th>Năm học</th>
                <th>Khóa học</th>
            </tr>
        </thead>
        <tbody>
            @if($tkb->count() > 0)
                @foreach($tkb as $rs)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $rs->name }}</td>
                        <td class="align-middle">{{ $rs->sesson }}</td>
                        <td class="align-middle">{{ $rs->subject_name }}</td>
                        <td class="align-middle">{{ $rs->year_name }}</td> 
                        <td class="align-middle">{{ $rs->course_name }}</td>  
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