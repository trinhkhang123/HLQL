@extends('layouts.app')
  
@section('title', 'Thêm trang thiết bị')
  
@section('contents')
    <hr />
 
    <form method="POST" enctype="multipart/form-data" id="profile_setup_frm" action="{{ route('products.addEQ') }}"  >
        @csrf
        @method('POST')
        <div class="form-group">
            <input name="tb" type="text" class="form-control form-control-user @error('full_name')is-invalid @enderror" id="exampleInputFullName" placeholder="Tên thiết bị">
            @error('name')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <input name="cl" type="text" class="form-control form-control-user @error('email')is-invalid @enderror" id="exampleInputEmail" placeholder="Chủng loại">
            @error('email')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        <div class="row">
        <div class="col-md-12 border-right">
            <div class="p-3 py-5">
                
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="labels">Mã số HV mượn</label>
                        <div class="d-flex align-items-center justify-content-between">
                            
                            <select name="dropdown[]" id="dropdown1" >
                                <option value="Không có">Không có</option>
                              @foreach($trainee as $rs)
                              <option value="{{ $rs->id }}" name = "trainee_id">
                                {{ $rs->id }}
                            </option>
                          @endforeach
                          </select>
                        
                      </div>
                    </div>
                    <div class="col-md-6">
                        <label class="labels">Dành cho môn học</label>
                        <div class="d-flex align-items-center justify-content-between">
                           
                            <select name="dropdown[]" id="dropdown1">
                                <option value="Không có">Không có</option>
                              @foreach($subject as $rs)
                              <option value="{{ $rs->id }}" name = "subject_id">
                                {{ $rs->name }}
                            </option>
                          @endforeach
                          </select>
                        
                      </div>
                    </div>
                </div>
                 
                <div class="mt-5 text-center"><button id="btn" class="btn btn-primary profile-button" type="submit">Xác nhận</button></div>
            </div>
        </div>
         
    </div>   
            
        </form>
@endsection