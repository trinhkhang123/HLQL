@extends('layouts.app')
  
@section('title', 'Quản Lý Đơn Vị')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@section('contents')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="d-flex align-items-center justify-content-between">
        
    <a href="{{ route('register.save') }}" class="btn btn-primary">Thêm đơn vị</a>
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
                <th>Tên đơn vị</th>
                <th>Loại đơn vị</th>
                <th>Đơn vị trực thuộc</th>
                <th>Tình trạng</th>
            </tr>
        </thead>
        <tbody>
            @if($unit->count() > 0)
                @foreach($unit as $rs)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $rs->TenDonVi }}</td>
                        <td class="align-middle">{{ $rs->loaiDonVi }}</td>
                        <td class="align-middle">{{ $rs->DonViCha }}</td>
                        <td>
                            <form action="{{ route('products.destroyUN', $rs->id) }}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Delete?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger m-0">Xóa đơn vị</button>
                            </form>
                            
                        </td>
                    </tr>
                    
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">Không có đơn vị nào!</td>
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