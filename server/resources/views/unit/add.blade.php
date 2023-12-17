@extends('layouts.app')
  
@section('title', 'Thông Tin Trang bị')
  
@section('contents')
    <hr />
 
    <form method="POST" enctype="multipart/form-data" id="profile_setup_frm" action="{{ route('products.addUN') }}"  >
        @csrf
        @method('POST')
        <div class="form-group">
            <input name="tb" type="text" class="form-control form-control-user @error('full_name')is-invalid @enderror" id="exampleInputFullName" placeholder="Tên đơn vị">
            @error('tb')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <input name="cl" type="text" class="form-control form-control-user @error('email')is-invalid @enderror" id="exampleInputEmail" placeholder="Loại đơn vị">
            @error('cl')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
       
          <div class="row">
            <div class="col-md-12 border-right">
                <div class="col-md-6">
                    <label class="labels">Đơn vị trực thuộc</label>
                    <div class="d-flex align-items-center justify-content-between">
                       
                        <select name="dropdown[]" id="dropdown1">
                            <option value="Không có">Không có</option>
                          @foreach($unit as $rs)
                          <option value="{{ $rs->id }}" name = "subject_id">
                            {{ $rs->name }}
                        </option>
                      @endforeach
                      </select>
                    
                  </div>
                </div>
                <div class="mt-5 text-center"><button id="btn" class="btn btn-primary profile-button" type="submit">Xác nhận</button></div>
            </div>
    </div>   
            
        </form>
@endsection