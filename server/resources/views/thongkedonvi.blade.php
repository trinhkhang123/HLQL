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
        <p>Noi dung</p>
        <select name="dropdown[]" id="dropdown5" onchange="handleSelectChange(this)">
            
        </select>
        <script>
            // Define the function outside the inline event handler
            function handleSelectChange(selectElement) {
                // Get the selected value
                var selectedValue = selectElement.value;
            
                // Log or use the selected value
                console.log(donvi,start_time,end_time,selectedValue);

                $.ajax({
                  url: '{{ route("thongkedvv") }}',
                  type: 'POST', // Chắc chắn rằng bạn đã sử dụng phương thức POST
                  data: {
                      noidung:selectedValue,
                      donvi:donvi
                  },
                  headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
                  success: function(response) {
                      // Xử lý kết quả trả về từ server
                      console.log(response);
                      updateTableContent(response);
                      
                  },
                  error: function(error) {
                      // Xử lý lỗi (nếu có)
                      console.error('Error:', error);
                  }
              });
             
            }
            
            </script>
       
        {{-- <button class="btn btn-primary" id="btnGetValuess">Xác nhận</button> --}}
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
                <th>Ten Don Vi</th>
                <th>Tong diem chuyen can</th>
                <th>hoc vien dat diem thi</th>
                <th>So luong hoc vien</th>
                <th>Muc do chuyen can</th>
                <th>Diem thi</th>
            </tr>
        </thead>
        <tbody id="tableBody">
           
                <tr>
                    <td class="text-center" colspan="5">Không có sinh viên nào!</td>
                </tr>
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
                    '<td class="align-middle">' + row.donvi + '</td>' +
                    '<td class="align-middle">' + row.tong + '</td>' +
                    '<td class="align-middle">' + row.nhapdiem + '</td>' +
                    '<td class="align-middle">' + row.soluong + '</td>' +
                    '<td class="align-middle">' + row.mucdo + '</td>' +
                    '<td class="align-middle">' + row.diem + '</td>' +
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
    //    document.getElementById('table2').addEventListener('click', function(event) {
    //     if (event.target.id.startsWith('btnGetValues')) {
    //         var idToDelete = event.target.id.replace('btnGetValues', '');
    //         // Call a function or perform actions based on the idToDelete
    //         console.log('Delete button clicked with id:', idToDelete);
    //         $.ajax({
    //               url: '{{ route("deleteTH") }}',
    //               type: 'POST', // Chắc chắn rằng bạn đã sử dụng phương thức POST
    //               data: {
    //                 id:idToDelete,
    //                   donvi:donvi,
    //                   start_time:start_time,
    //                   end_time:end_time
    //               },
    //               headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    //               success: function(response) {
    //                  console.log(response);
    //                  var newData = response.kehoach;

    //     // Function to update the table content
        

    //     // Handle button click event
        
    //         // Call the function with the new data
    //         updateTableContent(newData);
    //         var newTable2Data = response.thuchiens;

        

    //     // Handle button click event
    //         // Call the function with the new data for the second table
    //         updateTable2Content(newTable2Data);
    
    //               },
    //               error: function(error) {
    //                   // Xử lý lỗi (nếu có)
    //                   console.error('Error:', error);
    //               }
    //           });
    //       }
    // });
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
      function handleSelectChange(selectElement) {
    // Get the selected value
    var selectedValue = selectElement.value;

    // Log or use the selected value
    console.log("Selected value: " + selectedValue);
}
          // Bắt sự kiện change của dropdown
          $('#dropdown1').on('change', function() {
              // Lấy giá trị option được chọn
            selectedValue = $(this).val();
              console.log(selectedValue);
              window.location.href = "/thongkedonvi/" + selectedValue ;
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
              console.log(start_time,end_time,6);
              $.ajax({
                  url: '{{ route("getnoidung") }}',
                  type: 'POST', // Chắc chắn rằng bạn đã sử dụng phương thức POST
                  data: {
                      start_time:start_time,
                      end_time:end_time,
                      donvi:donvi
                  },
                  headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
                  success: function(response) {
                    console.log(response);
                    var options = response;

                // Get the select element by its ID
                var selectElement = document.getElementById('dropdown5');
                selectElement.innerHTML = '';
                console.log(options.length);
                // Add options to the select element
                options.forEach(function(option) {
                    var optionElement = document.createElement('option');
                    optionElement.value = option.id;
                    optionElement.text = option.TenNoiDung;
                    optionElement.id = option.id;
                    selectElement.add(optionElement);
                });

                  },
                  error: function(error) {
                      // Xử lý lỗi (nếu có)
                      console.error('Error:', error);
                  }
              });
          });
          $('#dropdown4').on('change', function() {
              // Lấy giá trị option được chọn
            end_time = $(this).val();
              console.log(start_time,end_time);
              $.ajax({
                  url: '{{ route("getnoidung") }}',
                  type: 'POST', // Chắc chắn rằng bạn đã sử dụng phương thức POST
                  data: {
                      start_time:start_time,
                      end_time:end_time,
                      donvi:donvi
                  },
                  headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
                  success: function(response) {
                    console.log(response);
                    var options = response;

                // Get the select element by its ID
                var selectElement = document.getElementById('dropdown5');
                selectElement.innerHTML = '';
                console.log(options.length);
                // Add options to the select element
                options.forEach(function(option) {
                    var optionElement = document.createElement('option');
                    optionElement.value = option.id;
                    optionElement.text = option.TenNoiDung;
                    optionElement.id = option.id;
                    selectElement.add(optionElement);
                });

                  },
                  error: function(error) {
                      // Xử lý lỗi (nếu có)
                      console.error('Error:', error);
                  }
              });
          });
      });
  </script>
@endsection