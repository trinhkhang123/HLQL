@extends('layouts.app')
  
@section('title', 'Thông Tin Trang bị')
  
@section('contents')
    <hr />
 
    <form method="POST" enctype="multipart/form-data" id="profile_setup_frm" action="{{ route('products.updateEQ',$id) }}"  >
        @csrf
        @method('PUT')
        <div class="row">
        <div class="col-md-12 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Sua</h4>
                </div>
                <div class="row" id="res"></div>
                <div class="row mt-2">
  
                    <div class="col-md-6">
                        <label class="labels">So hieu</label>
                        <input type="text" name="serial_number" disabled class="form-control" placeholder="Họ và tên" value="{{ $equipment->serial_number }}">
                    </div>
                    <div class="col-md-6">
                        <label class="labels">Chủng loại</label>
                        <input type="text" name="equipment_type" disabled class="form-control" value="{{ $equipment->equipment_type }}" placeholder="Chủng loại">
                    </div>
                </div>
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