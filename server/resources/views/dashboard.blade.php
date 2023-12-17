@extends('layouts.app')
  
@section('title', 'Điểm Danh')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@section('contents')
<meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="d-flex align-items-center justify-content-between">
        
          <select name="dropdown[]" id="dropdown1">
            @foreach($units as $rs)
            <option value="{{ $rs->id }}" {{ $rs->id == $id ? 'selected' : '' }}>
              {{ $rs->TenDonVi }}
          </option>
        @endforeach
        </select>
        <select name="dropdown[]" id="dropdown2">
            @foreach($noidung as $rs)
            <option value="{{ $rs->id }}" {{ $rs->id == $idd ? 'selected' : '' }}>
              {{ $rs->TenNoiDung}}
          </option>
        @endforeach
        </select>
       
    </div>
    <div class="d-flex align-items-center justify-content-between">
        
        
    
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
                <th>Đơn vị</th>
                <th>Số buổi có mặt</th>
                <th>Điểm danh</th>
                <th>Nhap diem</th>
            </tr>
        </thead>
        <tbody>
            @if(count($trainee) > 0)
                @foreach($trainee as $rs)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $rs->HoTen }}</td>
                        <td class="align-middle">{{ $rs->id }}</td>
                        
                        <td class="align-middle">{{ $unit['TenDonVi'] }}</td>  
                        <td class="align-middle">{{ $rs->diemdanh->DiemDanh }}</td>
                        <td><input type="checkbox" name="checkbox[]" value="{{ $rs->id }}"></td>
                        <td><input type="int" name="nhapdiem{{ $rs->id }}" value="{{ $rs->diemdanh->nhapdiem }}"></td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">Không có sinh viên nào!</td>
                </tr>
            @endif
        </tbody>
    </table>
    <button class="btn btn-primary" id="btnGetValues">Xác nhận</button>
    <script>
      $(document).ready(function() {
          // Lắng nghe sự kiện khi nút được nhấn
          $('#btnGetValues').on('click', function() {
              // Tạo một mảng để lưu trữ giá trị checkbox đã chọn
              var selectedValues = [],inputValue =0 ;
  
              // Duyệt qua tất cả các ô checkbox trong bảng
              $('input[name="checkbox[]"]:checked').each(function() {
                  // Thêm giá trị của checkbox đã chọn vào mảng
                  var value = $(this).val();
                  var inputElement = document.querySelector('input[name="nhapdiem' + value + '"]');
                 
                  if (inputElement) {
    // Get the value from the value attribute
                     inputValue = inputElement.value;

                    // Process the value here, for example:
                    console.log("Value of nhapdiem: " + inputValue);
                }
                  $.ajax({
                  url: '{{ route("update.att") }}',
                  type: 'POST', // Chắc chắn rằng bạn đã sử dụng phương thức POST
                  data: {
                      id: $(this).val(),
                      noidung:{!! json_encode($idd) !!},
                      nhapdiem:inputValue
                  },
                  headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
                  success: function(response) {
                      // Xử lý kết quả trả về từ server
                      
                window.location.href = "/dashboard";
                      
                  },
                  error: function(error) {
                      // Xử lý lỗi (nếu có)
                      console.error('Error:', error);
                  }
              });
                });
  
          });
          var inputElements = document.querySelectorAll('input[name^="nhapdiem"]');

        // Lặp qua từng phần tử để lấy giá trị
        inputElements.forEach(function(inputElement) {
            // Lấy giá trị từ thuộc tính value
            var inputValue = inputElement.value;

            // Xử lý giá trị ở đây, ví dụ:
            console.log("Giá trị của nhapdiem: " + inputValue);
        });
      });
  </script>
    <script>
        console.log({!! json_encode($trainee) !!})
        let selectedValue = {!! json_encode($id) !!},selectedValue1 = 1;
      $(document).ready(function() {
          // Bắt sự kiện change của dropdown
          $('#dropdown2').on('change', function() {
              // Lấy giá trị option được chọn
            selectedValue1 = $(this).val();
              console.log(selectedValue1);
              window.location.href = "/dashboard/" + selectedValue + '/' + selectedValue1  ;
              $id = selectedValue1;
          });
          $('#dropdown1').on('change', function() {
              // Lấy giá trị option được chọn
            selectedValue = $(this).val();
              console.log(selectedValue);
              window.location.href = "/dashboard/" + selectedValue + '/' + selectedValue1;
              $id = selectedValue;
          });
      });
  </script>
@endsection