@extends('layouts.app')
  
@section('title', 'Quán Lý Trang Bị')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@section('contents')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="d-flex align-items-center justify-content-between">
        
    <a href="{{ route('register.save') }}" class="btn btn-primary">Thêm Trang bị</a>
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
                <th>Số hiệu</th>
                <th>Ten thiet bi</th>
                <th>Chủng loại</th>
                <th>Ma don vi</th>
                <th>Tình trạng</th>
            </tr>
        </thead>
        <tbody>
            @if($equipment->count() > 0)
                @foreach($equipment as $rs)
                    <tr>
                        <td class="align-middle">{{ $rs->serial_number }}</td>
                        <td class="align-middle">{{ $rs->equipment_type }}</td>
                        <td class="align-middle">{{ $rs->subject_id }}</td>
                        <td>
                            <form action="{{ route('products.destroyEQ', $rs->id) }}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Delete?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger m-0"> Xóa trang bị</button>
                            </form>
                            <form action="{{ route('products.editEQ', $rs->id) }}" method="POST" type="button" class="btn btn-danger p-0" >
                                @csrf
                                @method('GET')
                                <button class="btn btn-danger m-0">Sửa</button>
                            </form>
                        </td>
                    </tr>
                    
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">Không có trang bị nào!</td>
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
      $(document).ready(function() {
          // Bắt sự kiện change của dropdown
          $('#dropdown1').on('change', function() {
              // Lấy giá trị option được chọn
              var selectedValue = $(this).val();
              console.log(selectedValue);
              window.location.href = "/dashboard/" + selectedValue;
              $id = selectedValue;
          });
      });
  </script>
@endsection