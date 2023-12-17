@extends('layouts.app')
  
@section('title', 'Thêm học viên')
  
@section('contents')
    <hr />
    
      <form action="{{ route('register.save') }}" method="POST" class="user">
        @csrf
        <div class="form-group row">
          <div class="form-group">
            <input name="full_name" type="text" class="form-control form-control-user @error('full_name')is-invalid @enderror" id="exampleInputFullName" placeholder="Họ và tên">
            @error('name')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="col-sm-6">
            <input name="class_name" type="text" class="form-control form-control-user @error('class_name')is-invalid @enderror" id="exampleClassName" placeholder="Lớp">
            @error('class_name')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          
        </div>
        
        <div class="form-group">
          <input name="email" type="email" class="form-control form-control-user @error('email')is-invalid @enderror" id="exampleInputEmail" placeholder="Địa chỉ email">
          @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>
        <div class="row mt-2">
  
          <div class="col-md-6">
            <label class="labels">Thời gian bắt đầu khóa học</label>  
            <div class="col-sm-6 mb-3 mb-sm-0">
              <div class="d-flex align-items-center justify-content-between">
                       
                <select name="dropdown[]" id="dropdown1">
                  @foreach($year as $rs)
                  <option value="{{ $rs->id }}" name = "unit_id">
                    {{ $rs->year }}
                </option>
              @endforeach
              </select>
          </div>
            </div>
        </div>
        <div class="col-md-6">
          <label class="labels">Đơn vị</label>       
          <div class="col-sm-6 mb-3 mb-sm-0">
            <div class="d-flex align-items-center justify-content-between">
              
              <select name="dropdown[]" id="dropdown1">
                @foreach($unit as $rs)
                <option value="{{ $rs->id }}" name = "unit_id">
                  {{ $rs->name }}
              </option>
            @endforeach
            </select>
        </div>
          </div>
      </div>
      </div>
        
        <hr/>
        
        
        <div class="form-group row">
          <div class="col-sm-6 mb-3 mb-sm-0">
            <input name="password" type="password" class="form-control form-control-user @error('password')is-invalid @enderror" id="exampleInputPassword" placeholder="Mật khẩu">
            @error('password')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="col-sm-6">
            <input name="password_confirmation" type="password" class="form-control form-control-user @error('password_confirmation')is-invalid @enderror" id="exampleRepeatPassword" placeholder="Nhập lại mật khẩu">
            @error('password_confirmation')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>
        
        <button type="submit" class="btn btn-primary btn-user btn-block">Thêm học viên</button>
      </form>
@endsection