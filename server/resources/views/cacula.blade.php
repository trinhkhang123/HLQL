@extends('layouts.app')
  
@section('title', 'Thêm Thời Khóa Biểu')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@section('contents')

<meta name="csrf-token" content="{{ csrf_token() }}">

   
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <p>Noi dung</p>
    <input type="text" class="form-control form-control-user" id="title" placeholder="Noi dung">
    <p>Số tiết</p>
    <input type="text" class="form-control form-control-user" id="sesson" placeholder="Số tiết">
    <p>Thoi gian bat dau</p> 
    <select name="dropdown[]" id="dropdown1">
      @foreach($nams as $rs)
      <option value={{   $rs->Nam}}>
        {{ $rs->Nam }}
    </option>
  @endforeach
  </select>
    <p></p>
    <p>Thoi gian ket thuc</p> 
    <select name="dropdown[]" id="dropdown2">
      @foreach($nams as $rs)
      <option value={{   $rs->Nam}}>
        {{ $rs->Nam }}
    </option>
  @endforeach
  </select>
    <p></p>
    
    
    <p></p>
    <button class="btn btn-danger m-0" id ="btnGetValues" name = "btnGetValues">Thêm</button>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        var selectedTimeStart = ""; // Biến để lưu trữ giá trị thời gian bắt đầu
    var selectedTimeEnd = ""; 
    var day = 1, year = 1,course = 1,subject = 1,end_time=2018,start_time=2018;
    var sotiet = 0,noidung = 0;
    document.addEventListener("DOMContentLoaded", function() {
    // Get the input element by id
    var inputElement = document.getElementById("title");

    // Add an event listener for the 'input' event
    inputElement.addEventListener("input", function() {
      // Get the current value of the input element
      var inputValue = inputElement.value;
      noidung = inputValue;
      // Display the value
      console.log("Current value of the input element: " + inputValue);
    });
  });

  document.addEventListener("DOMContentLoaded", function() {
    // Get the input element by id
    var inputElement = document.getElementById("sesson");

    // Add an event listener for the 'input' event
    inputElement.addEventListener("input", function() {
      // Get the current value of the input element
      var inputValue = inputElement.value;
      sotiet = inputValue;
      // Display the value
      console.log("Current value of the input element: " + inputValue);
    });
  });


       
        $(document).ready(function() {
          // Lắng nghe sự kiện khi nút được nhấn
          $('#btnGetValues').on('click', function() {
              // Tạo một mảng để lưu trữ giá trị checkbox đã chọn
              var selectedValues = [];
        
              console.log(noidung,sotiet,start_time,end_time,course);
  
              // Duyệt qua tất cả các ô checkbox trong bảng
        //       
                  $.ajax({
                  url: '{{ route("products.addAtt") }}',
                  type: 'POST', // Chắc chắn rằng bạn đã sử dụng phương thức POST
                  data: {
                    name: noidung,
                    sesson : sotiet,
                    start_time : start_time,
                    end_time : end_time
                  },
                  headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
                  success: function(response) {
                      
                    // window.location.href = "/cacula";// Xử lý kết quả trả về từ server
                      console.log(response);
                      
                  },
                  error: function(error) {
                      // Xử lý lỗi (nếu có)
                      console.error('Error:', error);
                  }
              });
                
  
          });
      });
      $(document).ready(function() {
            // Bắt sự kiện change của dropdown

          $('#dropdown3').on('change', function() {
              // Lấy giá trị option được chọn
              course = $(this).val();
          });
          $('#dropdown1').on('change', function() {
              // Lấy giá trị option được chọn
              start_time = $(this).val();
          });
          $('#dropdown2').on('change', function() {
              // Lấy giá trị option được chọn
              end_time = $(this).val();
          });
        });
    </script>
   
@endsection
