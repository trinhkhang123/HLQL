@extends('layouts.app')
  
@section('title', 'Thuc Hien Ke Hoach')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@section('contents')
<meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="d-flex align-items-center justify-content-between">
        <p>Loai don vi</p>
          <select name="dropdown[]" id="dropdown1">
            @foreach($loaiDonVi as $rs)
            <option value="{{ $rs}}" {{ $rs == $id ? 'selected' : '' }}>
              {{ $rs }}
          </option>
        @endforeach
        </select>
        <p>Chon don vi</p>
          <select name="dropdown[]" id="dropdown2">
            @foreach($donvi as $rs)
            <option value={{ $rs->id}}>
              {{ $rs->TenDonVi }}
          </option>
        @endforeach
        </select>
        <p>Thoi gian bat dau</p>
          <select name="dropdown[]" id="dropdown3">
            @foreach($nam as $rs)
            <option value={{ $rs->Nam}}>
              {{ $rs->Nam}}
          </option>
        @endforeach
        </select>
        <p>Thoi gian ket thuc</p>
        <select name="dropdown[]" id="dropdown4">
            @foreach($nam as $rs)
            <option value={{ $rs->Nam}}>
              {{ $rs->Nam}}
          </option>
        @endforeach
        </select>
       
        <button class="btn btn-primary" id="btnGetValuess">Xác nhận</button>
    </div>
    <div class="d-flex align-items-center justify-content-between">
        
        
    
  </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
        <table  id="table1" class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Ma ke hoach</th>
                <th>Ma noi dung</th>
                <th>So tiet</th>
                <th>Thoi gian bat dau</th>
                <th>Thoi gian ket thuc</th>
                <th>tinh trang</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @if(count($kehoach) > 0)
                @foreach($kehoach as $rs)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $rs->id }}</td>
                        <td class="align-middle">{{ $rs->MaNoiDung }}</td>
                        <td class="align-middle">{{ $rs->SoGioChoDoiTuong }}</td>
                        <td class="align-middle">{{ $rs->ThoiGianBatDau }}</td>
                        <td class="align-middle">{{ $rs->ThoiGianKetThuc }}</td>
                        <td class="align-middle">
                          <button class="btn btn-primary" id="btnGetValuess+{{ $rs->id }}">Xoa</button>
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
    <table  id="table2" class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Noi dung</th>
                <th>Ma ke hoach</th>
                <th>tinh trang</th>
            </tr>
        </thead>
        <tbody id ='table2Body'>
            @if(count($thuchiens) > 0)
                @foreach($thuchiens as $rs)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $rs->MaNoiDung }}</td>
                        <td class="align-middle">{{ $rs->MaKeHoach }}</td>
                        <td class="align-middle">
                          <button class="btn btn-primary" id="btnGetValues+{{ $rs->id }}">Xoa</button>
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
    <script>
     
      $(document).ready(function() {
       
          // Lắng nghe sự kiện khi nút được nhấn
          $('#btnGetValues').on('click', function() {
              // Tạo một mảng để lưu trữ giá trị checkbox đã chọn
              var selectedValues = [];
  
              // Duyệt qua tất cả các ô checkbox trong bảng
              $('input[name="checkbox[]"]:checked').each(function() {
                  // Thêm giá trị của checkbox đã chọn vào mảng
                  
                  $.ajax({
                  url: '{{ route("update.att") }}',
                  type: 'POST', // Chắc chắn rằng bạn đã sử dụng phương thức POST
                  data: {
                      id: $(this).val()
                  },
                  headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
                  success: function(response) {
                      // Xử lý kết quả trả về từ server
                      
                  },
                  error: function(error) {
                      // Xử lý lỗi (nếu có)
                      console.error('Error:', error);
                  }
              });
                });
                window.location.href = "/dashboard";
  
          });
      });
  </script>
    <script>
      function updateTableContent(data) {
            var tbody = $('#tableBody'); // Assuming your tbody has an id attribute

            // Clear existing table rows
            tbody.empty();

            // Append new rows
            $.each(data, function(index, row) {
                var newRow = '<tr>' +
                    '<td class="align-middle">' + (index + 1) + '</td>' +
                    '<td class="align-middle">' + row.id + '</td>' +
                    '<td class="align-middle">' + row.TenNoiDung + '</td>' +
                    '<td class="align-middle">' + row.SoGioChoDoiTuong + '</td>' +
                    '<td class="align-middle">' + row.ThoiGianBatDau + '</td>' +
                    '<td class="align-middle">' + row.ThoiGianKetThuc + '</td>' +
                    '<td class="align-middle">' +
                '<button class="btn btn-primary btnDelete" id="btnGetValuess' + row.id + '">Them</button>' +
                '</td>'+
                    '</tr>';

                tbody.append(newRow);
            });
        }
        function updateTable2Content(data) {
            var table2Body = document.getElementById('table2Body');

            // Clear existing table rows
            table2Body.innerHTML = '';

            // Append new rows
            data.forEach(function(row, index) {
              var newRow = '<tr>' +
                '<td class="align-middle">' + (index + 1) + '</td>' +
                '<td class="align-middle">' + row.TenNoiDung + '</td>' +
                '<td class="align-middle">' + row.id + '</td>' +
                '<td class="align-middle">' +
                '<button class="btn btn-primary btnDelete" id="btnGetValues' + row.MaThucHien + '">Xoa</button>' +
                '</td>' +
                '</tr>';
                table2Body.innerHTML += newRow;
            });
        }
       document.getElementById('table2').addEventListener('click', function(event) {
        if (event.target.id.startsWith('btnGetValues')) {
            var idToDelete = event.target.id.replace('btnGetValues', '');
            // Call a function or perform actions based on the idToDelete
            console.log('Delete button clicked with id:', idToDelete);
            $.ajax({
                  url: '{{ route("deleteTH") }}',
                  type: 'POST', // Chắc chắn rằng bạn đã sử dụng phương thức POST
                  data: {
                    id:idToDelete,
                      donvi:donvi,
                      start_time:start_time,
                      end_time:end_time
                  },
                  headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
                  success: function(response) {
                     console.log(response);
                     var newData = response.kehoach;

        // Function to update the table content
        

        // Handle button click event
        
            // Call the function with the new data
            updateTableContent(newData);
            var newTable2Data = response.thuchiens;

        

        // Handle button click event
            // Call the function with the new data for the second table
            updateTable2Content(newTable2Data);
    
                  },
                  error: function(error) {
                      // Xử lý lỗi (nếu có)
                      console.error('Error:', error);
                  }
              });
          }
    });
    document.getElementById('table1').addEventListener('click', function(event) {
        if (event.target.id.startsWith('btnGetValuess')) {
            var idToDelete = event.target.id.replace('btnGetValuess', '');
            // Call a function or perform actions based on the idToDelete
            console.log('Delete button clicked with id:', idToDelete);
            $.ajax({
                  url: '{{ route("addTH") }}',
                  type: 'POST', // Chắc chắn rằng bạn đã sử dụng phương thức POST
                  data: {
                     id:idToDelete,
                      donvi:donvi,
                      start_time:start_time,
                      end_time:end_time
                  },
                  headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
                  success: function(response) {
                     console.log(response);
                     var newData = response.kehoach;

        // Function to update the table content
        

        // Handle button click event
        
            // Call the function with the new data
            updateTableContent(newData);
            var newTable2Data = response.thuchiens;

        

        // Handle button click event
            // Call the function with the new data for the second table
            updateTable2Content(newTable2Data);
    
                  },
                  error: function(error) {
                      // Xử lý lỗi (nếu có)
                      console.error('Error:', error);
                  }
              });
          }
    });

    

    // Initial table update
       let donvitt =  {!! json_encode($donvi) !!}
      console.log(donvitt);
        let selectedValue = 1,selectedValue1 = 1;
        let start_time = 2018,end_time = 2018,donvi = donvitt[0]['id'];
      $(document).ready(function() {
        $('#btnGetValuess').on('click', function() {
          $.ajax({
                  url: '{{ route("thuchienthem") }}',
                  type: 'POST', // Chắc chắn rằng bạn đã sử dụng phương thức POST
                  data: {
                      donvi:donvi,
                      start_time:start_time,
                      end_time:end_time
                  },
                  headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
                  success: function(response) {
                     console.log(response);
                     var newData = response.kehoach;

        // Function to update the table content
        

        // Handle button click event
        
            // Call the function with the new data
            updateTableContent(newData);
            var newTable2Data =response.thuchiens;

        

        // Handle button click event
            // Call the function with the new data for the second table
            updateTable2Content(newTable2Data);
      
                      // Xử lý kết quả trả về từ server
    //                   var newOptions = [
    //     { id: 1, TenDonVi: 'New Option 1' },
    //     { id: 2, TenDonVi: 'New Option 2' },
    //     // Add more options as needed
    // ];

    // // Function to update the dropdown options
    // function updateDropdownOptions(options) {
    //     var dropdown = $('#dropdown2');

    //     // Clear existing options
    //     dropdown.empty();

    //     // Append new options
    //     $.each(options, function(index, option) {
    //         dropdown.append('<option value="' + option.id + '">' + option.TenDonVi + '</option>');
    //     });
    // }

    // // Call the function with the new options
    // updateDropdownOptions(newOptions);
                  },
                  error: function(error) {
                      // Xử lý lỗi (nếu có)
                      console.error('Error:', error);
                  }
              });
                // window.location.href = "/dashboard";
      });
          // Bắt sự kiện change của dropdown
          $('#dropdown1').on('change', function() {
              // Lấy giá trị option được chọn
            selectedValue = $(this).val();
              console.log(selectedValue);
              window.location.href = "/thuchien/" + selectedValue ;
              $id = selectedValue;
          });
          $('#dropdown2').on('change', function() {
              // Lấy giá trị option được chọn
            donvi = $(this).val();
            //   console.log(selectedValue);
            //   window.location.href = "/dashboard/" + selectedValue + '/' + selectedValue ;
            //   $id = selectedValue;

          console.log(donvi,start_time,end_time);
          });
          $('#dropdown3').on('change', function() {
              // Lấy giá trị option được chọn
            start_time = $(this).val();
              console.log(start_time,end_time);
          });
          $('#dropdown4').on('change', function() {
              // Lấy giá trị option được chọn
            end_time = $(this).val();
              console.log(start_time,end_time);
          });
      });
  </script>
@endsection