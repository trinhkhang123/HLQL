@extends('layouts.app')
  
@section('title', 'Thêm học viên')
  
@section('contents')
    <hr />
    
      <form action="{{ route('register.HV') }}" method="POST" class="user">
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
          <div class="col-sm-6">
            <input name="capbac" type="text" class="form-control form-control-user @error('capbac')is-invalid @enderror" id="capbac" placeholder="Cap bac">
            @error('capbac')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          
        </div>
        
          <div class="col-md-6">
            <label class="labels">Thời gian bắt đầu khóa học</label>  
            <div class="col-sm-6 mb-3 mb-sm-0">
              <div class="d-flex align-items-center justify-content-between">
                       
                <select name="dropdown[]" id="dropdown1">
                  @foreach($namhoc as $rs)
                  <option value={{ $rs->Nam }} name = "namhoc">
                    {{ $rs->Nam }}
                </option>
              @endforeach
              </select>
          </div>
            </div>
        </div>
        
        
        <hr/>
        
        
        <button type="submit" class="btn btn-primary btn-user btn-block">Thêm học viên</button>
      </form>
@endsection