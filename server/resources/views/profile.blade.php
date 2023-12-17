@extends('layouts.app')
  
@section('title', 'Thông Tin Cá Nhân')
  
@section('contents')
    <hr />
 
    <form method="POST" enctype="multipart/form-data" id="profile_setup_frm" action="{{ route('profile.update') }}"  >
        @csrf
        @method('PUT')
        <div class="row">
        <div class="col-md-12 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    
                </div>
                <div class="row" id="res"></div>
                <div class="row mt-2">
  
                    <div class="col-md-6">
                        <label class="labels">Họ và tên</label>
                        <input type="text" name="name" disabled class="form-control" placeholder="Họ và tên" value="{{ $trainee->full_name }}">
                    </div>
                    <div class="col-md-6">
                        <label class="labels">MSSV</label>
                        <input type="text" name="email" disabled class="form-control" value="{{ $trainee->id }}" placeholder="MSSV">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="labels">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" value="{{ $trainee->phone }}">
                    </div>
                    <div class="col-md-6">
                        <label class="labels">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" value="{{ $trainee->address }}" placeholder="Địa chỉ">
                    </div>
                </div>
                 
                <div class="mt-5 text-center"><button id="btn" class="btn btn-primary profile-button" type="submit">Save Profile</button></div>
            </div>
        </div>
         
    </div>   
            
        </form>
@endsection