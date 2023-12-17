<?php
  
namespace App\Http\Controllers;
  
use App\Models\Att;
use App\Models\Canbo;
use App\Models\Content;
use App\Models\Diemdanh;
use App\Models\Donvi;
use App\Models\Equipment;
use App\Models\Hocvien;
use App\Models\Nam;
use App\Models\Namhoc;
use App\Models\Noidung;
use App\Models\Quanlykehoachhuanluyen;
use App\Models\Subject;
use App\Models\Thuchienkehoach;
use App\Models\Unit;
use App\Models\Year;
use Illuminate\Http\Request;
use App\Models\Trainee;
use Exception;
use Carbon\Carbon;
use stdClass;

class TraineeController extends Controller
{
    public function index()
    {
        $trainee = Hocvien::where('DonVi','=',auth()->user()->DonVi)
        ->join('donvis', 'hocviens.Donvi', '=', 'donvis.id')
        ->select('hocviens.*',
                'donvis.TenDonVi'
        )
        ->get();
        
        return view('products.index', compact('trainee'));
    }

    public function registerHV(Request $request)
    {
        $ans =  $request->all();
        $year = $ans["dropdown"][0];
 
        $trainee = Hocvien::create([
            'HoTen' => $request->full_name,
            'CapBac' => $request->capbac,
            'TenLop' => $request->class_name,
            'DonVi' => auth()->user()->DonVi,
            'ThoiGianBatDau' => $year
        ]);

        $thuchien = Thuchienkehoach::where('MaDonVi','=',auth()->user()->DonVi)
        ->join('quanlykehoachhuanluyens','thuchienkehoaches.MaKeHoach','quanlykehoachhuanluyens.id')
        ->select('*')->get();

        foreach($thuchien as $th) {
            $diemdanh = new Diemdanh();
            $diemdanh->MaMonHoc = $th->MaNoiDung;
            $diemdanh->MaHocVien = $trainee->id;
            $diemdanh->save();
        }

        // $trainee = Hocvien::with('unit')->get();
  
        return redirect()->route('products');
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $namhoc = Nam::get();
        return view('products.create1',compact('namhoc'));
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Product::create($request->all());
 
        // return redirect()->route('products')->with('success', 'Product added successfully');
    }
  
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $product = Product::findOrFail($id);
  
        // return view('products.show', compact('product'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $equipment = Equipment::findOrFail($id);
        $subject = Subject::get();
        $trainee = Trainee::get();
  
        return view('equipment.edit', compact('equipment','subject','trainee','id'));
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $id)
    {
       $equipment = Equipment::findOrFail($id);
       $ans =  $request->all();
       if ($ans['dropdown'][1] == "Không có" || $ans['dropdown'][0] == "Không có") {
        $equipment->subject_id = -1;
        $equipment->trainee_id = -1;
       }
       else {
       $equipment->subject_id = $ans['dropdown'][1];
       $equipment->trainee_id = $ans['dropdown'][0];
    }
       $equipment->save();
       return redirect()->route('product.equipment');
    }

    public function addTB(Request $request) {
        $subject = Subject::get();
        $trainee = Trainee::get();
        return view('equipment.add',compact('subject','trainee'));
    }

    public function addEQ(Request $request) {
        $equipment = new Equipment();
        $ans =  $request->all();
        if ($ans['dropdown'][1] == "Không có" || $ans['dropdown'][0] == "Không có") {
            $equipment->subject_id = -1;
            $equipment->trainee_id = -1;
           }
           else {
           $equipment->subject_id = $ans['dropdown'][1];
           $equipment->trainee_id = $ans['dropdown'][0];
        }
        $equipment->serial_number = $ans['tb'];
        $equipment->equipment_type = $ans['cl'];
        $equipment->save();
        return redirect()->route('product.equipment');
    }


    public function updateAtt(Request $request)
    {
        
        $trainee = Diemdanh::where('MaHocVien','=',$request->id)
        ->where('MaMonHoc','=',$request->noidung)->first();
        $trainee->DiemDanh ++;
        $trainee->nhapdiem = $request->nhapdiem;
        $trainee->save();
        // return redirect()->route('dashboard');;
    }

    public function unitEQ(string $id) {
        $trainee = Donvi::findOrFail($id);
        $hocvien = Hocvien::where('DonVi','=',$id)->get();
        foreach($hocvien as $hv) {
            $hv->delete();
        }
        
        $trainee->delete();
        return redirect()->route('product.unit');
    }


    public function addUNI() {
        $unit = Unit::get();
        return view('unit.add',compact('unit'));
    }

    public function addUN(Request $request) {
        $unit = new Unit();
        $ans =  $request->all();
        $unit->name = $ans['tb'];
        $unit->unit_type = $ans['cl'];
        if ($ans['dropdown'][0] != "Không có") {
            $unit->parent_unit_id =$ans['dropdown'][0]; 
        }
        $unit->save();
        return redirect()->route('product.unit');
    }

    public function unit() {
        // $id = auth()->user()->DonVi;
        $unit = Donvi::get();
        return view('unit',compact('unit'));
    }

    public function cacu() {
        // $subjects = Subject::get();
        $namhoc = Namhoc::get();
        $days = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6','Thứ 7', 'Chủ nhật'];
        $units = Donvi::get();
        $nams = Nam::get();
        return view('cacula',compact('days','units','nams'));
    }

   

    public function addAtt(Request $request ) {
        
        $noidung = new Noidung();
        $noidung->TenNoiDung = $request->name;
        $noidung->save();
        
        $att = new Quanlykehoachhuanluyen();
    
        $att->MaNoiDung = $noidung->id;
        $att->ThoiGianBatDau = $request->start_time;
        $att->ThoiGianKetThuc =$request->end_time;
        
        $nguoilap = Hocvien::where('user_id','=',auth()->user()->id)->get();
        $att->SoGioChoDoiTuong = $request->sesson;
        $att->NguoiLapKeHoach = $nguoilap[0]->id;
        $att->NguoiLapKeHoach = 1;
        try {
            $att->save();
        } catch (Exception $e) {
            return $e;
            // Handle the exception (error) here if the save operation fails
        }
        
        // Continue with the rest of the code
    }

    public function equipment() {
        $equipment = Equipment::get();
        foreach($equipment as $loop=> $eq) {
            if ($eq->subject_id != -1) {
                $subject = Subject::findOrFail($eq->subject_id);
                $equipment[$loop]->subject_id = $subject->name;
            }
            else 
            {
                $equipment[$loop]->subject_id = 'Không có';
            }
            if ($eq->trainee_id == -1) {
                $equipment[$loop]->trainee_id = 'Không có';
            }
        }
        $subject = Subject::get();
        $trainee = Trainee::get();
        return view('equipment',compact('equipment','subject','trainee'));
    }

    public function viewTKB() {
        $trainee = auth()->user()->trainee;
        $tkb = Content::where('khoa_id',$trainee->year_id)->get();
        $tksUpdate = [];
        foreach($tkb as $loop => $tk) {
            $sub = Subject::findOrFail($tk->subject_id);
            $year = Year::findOrFail($tk->year_id)->year;
            $course = Year::findOrFail($tk->year_id)->year;
            $tk->subject_name = $sub->name;
            $tk->year_name = $year;
            $tk->course_name = $course;
            $tkb[$loop] = $tk;
        }
        return view('viewTKB',compact('tkb'));
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trainee = Hocvien::findOrFail($id);
        
        $trainee->delete();
        return redirect()->route('products')->with('success', 'hocvien deleted successfully');
    }

    public function destroyEQ(string $id)
    {
        $trainee = Equipment::findOrFail($id);
        $trainee->delete();
        return redirect()->route('product.equipment');
    }

    public function destroyUN(string $id) {
        $donvi = Donvi::findOrFail($id);
        $donvi->delete();
        return redirect()->route('product.unit');
    }

    public function dashboard() 
    {
                $unitss = Donvi::get();
        $donvi = auth()->user()->DonVi;
        $units = [];
        foreach($unitss as $th) {
            if ($th->DonViCha) $cha = Donvi::where('id','=',$th->DonViCha)->first();
            else $cha = $th;
            if ($cha->DonViCha) $donvicha = Donvi::where('id','=',$cha->DonViCha)->first();
            else $donvicha = $cha;
            if ($th->LoaiDonVi == 'Đại đội' && ($donvi == $cha->id || $donvi == $donvicha->id || $donvi == $th->id)) {
                array_push($units,$th);     
            }
        }
        $unit = Donvi::where('id','=',$donvi)->first();
        $id = $unit->id;
        $noidung = Thuchienkehoach::where('MaDonVi','=',$id)->
        join('quanlykehoachhuanluyens','thuchienkehoaches.MaKeHoach','quanlykehoachhuanluyens.id')
        ->join('noidungs','quanlykehoachhuanluyens.MaNoiDung','noidungs.id')
        ->select('*')
        ->get();

        $idd = 0;
        if (count($noidung)) $idd = $noidung[0]->id;
        $traineee = Hocvien::get();
        $trainee = [];
        foreach($traineee as $trai) {
            foreach($units as $un) {
                if ($trai->DonVi == $id) {
                    $diemdanh = Diemdanh::where('MaHocVien','=',$trai->id)
                    ->where('MaMonHoc','=',$idd)->first();
                    
                    if(count($noidung) == 0) {
                        $dong = new stdClass();
                        $dong->DiemDanh = 0;
                        $dong->nhapdiem = 0;

                    $trai->diemdanh = $dong;
                    }
                    else
                    $trai->diemdanh = $diemdanh;
                    array_push($trainee,$trai);
                    break;
                }
            }
        }

       
        return view('dashboard',compact('trainee','units','id','unit','noidung','idd'));
    }
    public function thongkedonvi() {
        $donvi = Donvi::where('LoaiDonVi','=','Đại đội')->get();;
        $loaiDonVi = [
            'Đại đội',
            'Tiểu đoàn',
            'Trung đoàn'
        ];

        $id ='Đại đội';
        $idd = 0;
        if ($donvi) $idd = $donvi[0]->id;

        if (auth()->user()->type_user == 'Đại đội') {
            $donvi = Donvi::where('id','=',auth()->user()->DonVi)->get();
            $loaiDonVi =  ['Đại đội'];
        }
        $kehoach = [];
        $thuchiens = [];
        
        $nam = Nam::get();
        return view('thongkedonvi',compact('donvi','loaiDonVi','id','nam','kehoach','thuchiens'));
    }
    public function dashboardCh(string $id,string $idd) 
    {
        $unit = Donvi::findOrFail($id);
        $noidung = Thuchienkehoach::where('MaDonVi',$id);
        $traineee = Hocvien::get();
        $trainee = [];
        foreach($traineee as $trai) {
                if ($trai->DonVi == $id) {
                    $diemdanh = Diemdanh::where('MaHocVien','=',$trai->id)
                    ->where('MaMonHoc','=',$idd)->first();
                    $trai->diemdanh = $diemdanh;
                    array_push($trainee,$trai);
                    
                }
        }
        $units = Donvi::get();
        $noidung = Thuchienkehoach::where('MaDonVi','=',$id)->
        join('quanlykehoachhuanluyens','thuchienkehoaches.MaKeHoach','quanlykehoachhuanluyens.id')
        ->join('noidungs','quanlykehoachhuanluyens.MaNoiDung','noidungs.id')
        ->select('*')
        ->get();
        return view('dashboard',compact('trainee','units','id','unit','idd','noidung'));
    }

    public function aa($kehoach,$id) {
        $donvis = Donvi::where('DonViCha','=',$id)->get();
        $noidung = [];
        foreach($donvis as $donvi ) {
            
            foreach($kehoach as $kh) {
                if ($kh->MaDonVi == $donvi->id) {
                    array_push($noidung,$kh);
                }
            }
        }
        $uniqueArray = array_unique($noidung);
        return $uniqueArray;
    }

    public function nhap($dong) {
        if ($dong->soluong > 0 && $dong->nhapdiem * 10 / $dong->soluong < 4) {
            $dong->diem = 'Khong dat';
           }
           else $dong->diem = 'Dat';
           if ($dong->soluong)
           switch (true) {
            case $dong->tong/$dong->soluong >= 9 :
                // Thực hiện các hành động khi $variable bằng 'giá_trị_1'
                $dong->mucdo = 'Xuat Sac';
                break;
            
            case $dong->tong/$dong->soluong >= 8 :
                // Thực hiện các hành động khi $variable bằng 'giá_trị_1'
                $dong->mucdo = 'Gioi';
                break;

            case $dong->tong/$dong->soluong >= 7 :
                // Thực hiện các hành động khi $variable bằng 'giá_trị_1'
                $dong->mucdo = 'Kha';
                break;

            case $dong->tong/$dong->soluong >= 6 :
                // Thực hiện các hành động khi $variable bằng 'giá_trị_1'
                $dong->mucdo = 'Trung binh kha';
                break;
            case $dong->tong/$dong->soluong >= 5 :
                // Thực hiện các hành động khi $variable bằng 'giá_trị_1'
            $dong->mucdo = 'Trung binh';
            break;
            default:
            $dong->mucdo = 'Yeu';
            
                // Thực hiện các hành động khi không có trường hợp nào trùng khớp
                break;
        }
        else $dong->mucdo = 'Yeu';

        return $dong;
    }
    public function tinh($request) {
        $diemdanh = Hocvien::where('DonVi','=',$request->donvi)
           ->join('diemdanhs','hocviens.id','diemdanhs.MaHocVien')
           ->where('MaMonHoc','=',$request->noidung)->get()->sum('DiemDanh');
           
           $dong = new stdClass();
           $dong->donvi = Donvi::where('id','=',$request->donvi)->first()->TenDonVi;
           $dong->tong = $diemdanh;
           $dong->soluong = Hocvien::where('DonVi','=',$request->donvi)
           ->count();
           if ($dong->soluong) $mucdo = $dong->tong/$dong->soluong;
           else $mucdo = 0;
           $nhapdiem = Hocvien::where('DonVi','=',$request->donvi)
           ->join('diemdanhs','hocviens.id','diemdanhs.MaHocVien')
           ->where('MaMonHoc','=',$request->noidung)
           ->where('nhapdiem','>=',5)->count();
           $dong->nhapdiem = $nhapdiem;
           if ($dong->soluong > 0 && $nhapdiem * 10 / $dong->soluong < 4) {
            $dong->diem = 'Khong dat';
           }
           else $dong->diem = 'Dat';
           switch (true) {
            case $mucdo >= 9 :
                // Thực hiện các hành động khi $variable bằng 'giá_trị_1'
                $dong->mucdo = 'Xuat Sac';
                break;
            
            case $mucdo >= 8 :
                // Thực hiện các hành động khi $variable bằng 'giá_trị_1'
                $dong->mucdo = 'Gioi';
                break;

            case $mucdo >= 7 :
                // Thực hiện các hành động khi $variable bằng 'giá_trị_1'
                $dong->mucdo = 'Kha';
                break;

            case $mucdo >= 6 :
                // Thực hiện các hành động khi $variable bằng 'giá_trị_1'
                $dong->mucdo = 'Trung binh kha';
                break;
            case $mucdo >= 5 :
                // Thực hiện các hành động khi $variable bằng 'giá_trị_1'
            $dong->mucdo = 'Trung binh';
            break;
            default:
            $dong->mucdo = 'Yeu';
            
                // Thực hiện các hành động khi không có trường hợp nào trùng khớp
                break;
        }

        return $dong;
    }
      public function thongkedvv(Request $request) {
        // $thongke =
        $current = Donvi::findOrFail($request->donvi); 
        if ($current->LoaiDonVi == 'Tiểu đoàn') {
           $donvi = Donvi::where('DonViCha','=',$request->donvi)->get();
           $table = [];
           foreach($donvi as $dv) {
            $rq = new stdClass();
            $rq->noidung = $request->noidung;
            $rq->donvi = $dv->id;
            $d = $this->tinh($rq);
            array_push($table,$d);
           }

           return $table;
        }
        if ($current->LoaiDonVi == 'Trung đoàn') { 
            $donvi = Donvi::where('DonViCha','=',$request->donvi)->get();
            $table = [];

            foreach($donvi as $dv) {
                $dd = Donvi::where('DonViCha','=',$dv->id)->get();
                $dong = new stdClass();
           $dong->donvi = $dv->TenDonVi;
           $dong->tong = 0;
           $dong->soluong = 0;
           $dong->nhapdiem= 0;
                foreach($dd as $da) {
                    $rq = new stdClass();
                    $rq->noidung = $request->noidung;
                    $rq->donvi = $da->id;
                    $dw = $this->tinh($rq);
                    $dong->tong += $dw->tong;
                    $dong->soluong += $dw->soluong;
                    $dong->nhapdiem += $dw->nhapdiem;
                }
                $dong = $this->nhap($dong);
                array_push($table,$dong);
            }
            return $table;
        }
        // if ($current->LoaiDonVi == 'Tiểu đoàn') {
        //     foreach($donvis as $donvi ) {
        //         $kehoach = Thuchienkehoach::where('MaDonVi','=',$donvi->id)
        //         ->join('quanlykehoachhuanluyens','thuchienkehoaches.MaKeHoach','quanlykehoachhuanluyens.id')
        //         where()->get();
        //     }
        // }
        
        if ($current->LoaiDonVi == 'Đại đội') {
           
           $diemdanh = Hocvien::where('DonVi','=',$request->donvi)
           ->join('diemdanhs','hocviens.id','diemdanhs.MaHocVien')
           ->where('MaMonHoc','=',$request->noidung)->get()->sum('DiemDanh');
           
           $dong = new stdClass();
           $dong->donvi = Donvi::where('id','=',$request->donvi)->first()->TenDonVi;
           $dong->tong = $diemdanh;
           $dong->soluong = Hocvien::where('DonVi','=',$request->donvi)
           ->count();
           $mucdo = $dong->tong/$dong->soluong;
           $nhapdiem = Hocvien::where('DonVi','=',$request->donvi)
           ->join('diemdanhs','hocviens.id','diemdanhs.MaHocVien')
           ->where('MaMonHoc','=',$request->noidung)
           ->where('nhapdiem','>=',5)->count();
           $dong->nhapdiem = $nhapdiem;
           if ($dong->soluong > 0 && $nhapdiem * 10 / $dong->soluong < 4) {
            $dong->diem = 'Khong dat';
           }
           else $dong->diem = 'Dat';
           switch (true) {
            case $mucdo >= 9 :
                // Thực hiện các hành động khi $variable bằng 'giá_trị_1'
                $dong->mucdo = 'Xuat Sac';
                break;
            
            case $mucdo >= 8 :
                // Thực hiện các hành động khi $variable bằng 'giá_trị_1'
                $dong->mucdo = 'Gioi';
                break;

            case $mucdo >= 7 :
                // Thực hiện các hành động khi $variable bằng 'giá_trị_1'
                $dong->mucdo = 'Kha';
                break;

            case $mucdo >= 6 :
                // Thực hiện các hành động khi $variable bằng 'giá_trị_1'
                $dong->mucdo = 'Trung binh kha';
                break;
            case $mucdo >= 5 :
                // Thực hiện các hành động khi $variable bằng 'giá_trị_1'
            $dong->mucdo = 'Trung binh';
            break;
            default:
            $dong->mucdo = 'Yeu';
            
                // Thực hiện các hành động khi không có trường hợp nào trùng khớp
                break;
        }
           $table = [];
           array_push($table,$dong);

        return $table;
        }
    }
    public function getnoidung(Request $request) {
        $kehoach = Thuchienkehoach::join('quanlykehoachhuanluyens','thuchienkehoaches.MaKeHoach','quanlykehoachhuanluyens.id')
        ->join('noidungs','noidungs.id','quanlykehoachhuanluyens.MaNoiDung')
        ->select('*')->where('ThoiGianBatDau','>=',(int)$request->start_time)->
        where('ThoiGianKetThuc','<=',(int)$request->end_time)->get();
        $donvis = Donvi::where('DonViCha','=',$request->donvi)->get();
        $current = Donvi::findOrFail($request->donvi);
        $noidung =[];
        if ($current->LoaiDonVi == 'Tiểu đoàn') {
           
            $noidung = $this->aa($kehoach,$request->donvi);
        }
        if ($current->LoaiDonVi == 'Trung đoàn') { 
            
            foreach($donvis as $donvi) {
                $noidung = array_merge($noidung,$this->aa($kehoach,$donvi->id));
            }
            $noidung = array_unique($noidung);
        }
        // if ($current->LoaiDonVi == 'Tiểu đoàn') {
        //     foreach($donvis as $donvi ) {
        //         $kehoach = Thuchienkehoach::where('MaDonVi','=',$donvi->id)
        //         ->join('quanlykehoachhuanluyens','thuchienkehoaches.MaKeHoach','quanlykehoachhuanluyens.id')
        //         where()->get();
        //     }
        // }
        
        if ($current->LoaiDonVi == 'Đại đội') {
            foreach($kehoach as $kh) {
                if ($kh->MaDonVi == $current->id) {
                    array_push($noidung,$kh);
                }
            }
            $noidung = array_unique($noidung);
        }

        return $noidung;
    }

  

    public function thongkedv(string $loai) {
        $donvi = Donvi::where('LoaiDonVi','=',$loai)->get();;
        $loaiDonVi = [
            'Đại đội',
            'Tiểu đoàn',
            'Trung đoàn'
        ];

        $id =$loai;
        $idd = 0;
        if ($donvi) $idd = $donvi[0]->id;

        if (auth()->user()->type_user == 'Đại đội') {
            $donvi = Donvi::where('id','=',auth()->user()->DonVi)->get();
            $loaiDonVi =  ['Đại đội'];
        }
        $kehoach = [];
        $thuchiens = [];
        $nam = Nam::get();
        return view('thongkedonvi',compact('donvi','loaiDonVi','id','nam','kehoach','thuchiens'));
    }
//     INSERT INTO donvis (TenDonVi, LoaiDonVi, DonViCha)
// VALUES ('Trung đoàn 1', 'Trung đoàn', NULL),
// ('Trung đoàn 2', 'Trung đoàn', NULL),
// ('Tiểu đoàn', 'Tiểu đoàn', 11)
// ,('Tiểu đoàn 1', 'Tiểu đoàn', 12),
// ('Đại đội 1', 'Đại đội', 13),
// ('Đại đội 2', 'Đại đội', 13),
// ('Đại đội 3', 'Đại đội', 13),
// ('Đại đội 4', 'Đại đội', 14);


    public function tao() {
        $donvi = new Donvi();
        $donvi->TenDonVi = 'Đại đội 4';
        $donvi->LoaiDonVi = 'Đại đội';
        $donvi->DonViCha = 22;
        $donvi->save();
        return $donvi;
    }

    public function thuchien() {
        $donvi = Donvi::where('LoaiDonVi','=','Đại đội')->get();;
        $loaiDonVi = [
            'Đại đội',
            'Tiểu đoàn',
            'Trung đoàn'
        ];

        $id ='Đại đội';
        $idd = 0;
        if ($donvi) $idd = $donvi[0]->id;

        if (auth()->user()->type_user == 'Đại đội') {
            $donvi = Donvi::where('id','=',auth()->user()->DonVi)->get();
            $loaiDonVi =  ['Đại đội'];
        }
        $kehoach = [];
        $thuchiens = [];
        $nam = Nam::get();
        return view('thuchien.index',compact('donvi','loaiDonVi','id','nam','kehoach','thuchiens'));
    }
    public function thuchient(string $loai) {
        $donvi = Donvi::where('LoaiDonVi','=',$loai)->get();;
        $loaiDonVi = [
            'Đại đội',
            'Tiểu đoàn',
            'Trung đoàn'
        ];

        $id =$loai;
        $idd = 0;
        if ($donvi) $idd = $donvi[0]->id;

        if (auth()->user()->type_user == 'Học viêna') {
            $donvi = Donvi::where('id','=',auth()->user()->DonVi)->get();
            $loaiDonVi =  ['Đại đội'];
        }
        $kehoach = [];
        $thuchiens = [];
        $nam = Nam::get();
        return view('thuchien.index',compact('donvi','loaiDonVi','id','nam','kehoach','thuchiens'));
    }
    public function thuchienthem(Request $request) {
        
        $kehoach = Quanlykehoachhuanluyen::where('ThoiGianBatDau','>=',(int)$request->start_time)->
        where('ThoiGianKetThuc','<=',(int)$request->end_time)
        ->join('noidungs','noidungs.id','quanlykehoachhuanluyens.MaNoiDung')
        ->select(
            'quanlykehoachhuanluyens.*', // Select all columns from Quanlykehoachhuanluyen
            'noidungs.TenNoiDung' // Select all columns from noidungs
        )->get();
        $thuchien = Thuchienkehoach::get();
        
        $thuchiens = [];
        foreach($thuchien as $tht) {
            $th = Quanlykehoachhuanluyen::where('id','=',$tht->MaKeHoach)->first();
            $th->TenNoiDung = Noidung::where('id','=',$th->MaNoiDung)->first()->TenNoiDung;
            $th->MaThucHien = $tht->id;
            if ($th->ThoiGianBatDau >= (int)$request->start_time &&
            $th->ThoiGianKetThuc <= (int)$request->end_time ) {
                // array_push($thuchiens,$tht);
            $donvi = Donvi::where('id','=',$tht->MaDonVi)->first();
            if ($donvi->DonViCha == $request->donvi) {
                array_push($thuchiens,$th);
            }
            else {
                $cha = Donvi::where('id','=',$donvi->DonViCha)->first();
                if ($cha->DonViCha == $request->donvi) {
                    array_push($thuchiens,$th);
                }
                else {
                    if ($donvi->id == $request->donvi) {
                        array_push($thuchiens,$th);
                    }
                }
            }
        }
        }
        $donvi = Donvi::where('id','=',(int)$request->donvi)->get();;
        $loaiDonVi = [
            'Đại đội',
            'Tiểu đoàn',
            'Trung đoàn'
        ];

        $id ="Đại đội";
        $idd = 0;
        if ($donvi) {
            $id = $donvi[0]->LoaiDonVi;
            $idd = $donvi[0]->id;
        }
        if (auth()->user()->type_user == 'Học viêna') {
            $donvi = Donvi::where('id','=',auth()->user()->DonVi)->get();
            $loaiDonVi =  ['Đại đội'];
        }
        $nam = Nam::get();
        return [
            'donvi' => $donvi,
            'loaiDonVi' => $loaiDonVi,
            'id' => $id,
            'nam' => $nam,
            'kehoach' => $kehoach,
            'thuchiens' => $thuchiens,
        ];
    }
    public function addTH(Request $request) {
        
        $kehoach3 = Quanlykehoachhuanluyen::where('id','=',$request->id)->get();
       
        $thuchien = new Thuchienkehoach();
        $thuchien->MaKeHoach = $kehoach3[0]->id;
        $thuchien->MaDonVi = $request->donvi;
        $thuchien->save();

        $trainee = Hocvien::where('DonVi','=',$request->donvi)->get();
        foreach($trainee as $trai) {
            $diemdanh = new Diemdanh();
            $diemdanh->DiemDanh = 0;
            $diemdanh->MaMonHoc = $kehoach3[0]->MaNoiDung;
            $diemdanh->MaHocVien = $trai->id;
            $diemdanh->save();
        }
        
        $kehoach = Quanlykehoachhuanluyen::where('ThoiGianBatDau','>=',(int)$request->start_time)->
        where('ThoiGianKetThuc','<=',(int)$request->end_time)
        ->join('noidungs','noidungs.id','quanlykehoachhuanluyens.MaNoiDung')
        ->select(
            'quanlykehoachhuanluyens.*', // Select all columns from Quanlykehoachhuanluyen
            'noidungs.TenNoiDung' // Select all columns from noidungs
        )->get();
        $thuchien = Thuchienkehoach::get();
        
    $thuchiens = [];
        foreach($thuchien as $tht) {
            $th = Quanlykehoachhuanluyen::where('id','=',$tht->MaKeHoach)->first();
            $th->MaThucHien = $tht->id;
            $th->TenNoiDung = Noidung::where('id','=',$th->MaNoiDung)->first()->TenNoiDung;
            if ($th->ThoiGianBatDau >= (int)$request->start_time &&
            $th->ThoiGianKetThuc <= (int)$request->end_time ) {
                // array_push($thuchiens,$tht);
            $donvi = Donvi::where('id','=',$tht->MaDonVi)->first();
            if ($donvi->DonViCha == $request->donvi) {
                array_push($thuchiens,$th);
            }
            else {
                $cha = Donvi::where('id','=',$donvi->DonViCha)->first();
                if ($cha->DonViCha == $request->donvi) {
                    array_push($thuchiens,$th);
                }
                else {
                    if ($donvi->id == $request->donvi) {
                        array_push($thuchiens,$th);
                    }
                }
            }
        }
        }

        $donvi = Donvi::where('id','=',(int)$request->donvi)->get();;
        $loaiDonVi = [
            'Đại đội',
            'Tiểu đoàn',
            'Trung đoàn'
        ];

        $id ="Đại đội";
        $idd = 0;
        if ($donvi) {
            $id = $donvi[0]->LoaiDonVi;
            $idd = $donvi[0]->id;
        }
        if (auth()->user()->type_user == 'Học viêna') {
            $donvi = Donvi::where('id','=',auth()->user()->DonVi)->get();
            $loaiDonVi =  ['Đại đội'];
        }
        $nam = Nam::get();
        return [
            'donvi' => $donvi,
            'loaiDonVi' => $loaiDonVi,
            'id' => $id,
            'nam' => $nam,
            'kehoach' => $kehoach,
            'thuchiens' => $thuchiens,
        ];
    }
    public function deleteTH(Request $request) {
        
        $thuchien = Thuchienkehoach::where('id','=',$request->id)->first();
        
        $thuchien->delete();
        
        $kehoach = Quanlykehoachhuanluyen::where('ThoiGianBatDau','>=',(int)$request->start_time)->
        where('ThoiGianKetThuc','<=',(int)$request->end_time)->get();
        $thuchien = Thuchienkehoach::get();
        
    $thuchiens = [];
        foreach($thuchien as $tht) {
            $th = Quanlykehoachhuanluyen::where('id','=',$tht->MaKeHoach)->first();
            $th->MaThucHien = $tht->id;
            if ($th->ThoiGianBatDau >= (int)$request->start_time &&
            $th->ThoiGianKetThuc <= (int)$request->end_time ) {
                // array_push($thuchiens,$tht);
            $donvi = Donvi::where('id','=',$tht->MaDonVi)->first();
            if ($donvi->DonViCha == $request->donvi) {
                array_push($thuchiens,$th);
            }
            else {
                $cha = Donvi::where('id','=',$donvi->DonViCha)->first();
                if ($cha->DonViCha == $request->donvi) {
                    array_push($thuchiens,$th);
                }
                else {
                    if ($donvi->id == $request->donvi) {
                        array_push($thuchiens,$th);
                    }
                }
            }
        }
        }

        $donvi = Donvi::where('id','=',(int)$request->donvi)->get();;
        $loaiDonVi = [
            'Đại đội',
            'Tiểu đoàn',
            'Trung đoàn'
        ];

        $id ="Đại đội";
        $idd = 0;
        if ($donvi) {
            $id = $donvi[0]->LoaiDonVi;
            $idd = $donvi[0]->id;
        }
        if (auth()->user()->type_user == 'Học viêna') {
            $donvi = Donvi::where('id','=',auth()->user()->DonVi)->get();
            $loaiDonVi =  ['Đại đội'];
        }
        $nam = Nam::get();
        return [
            'donvi' => $donvi,
            'loaiDonVi' => $loaiDonVi,
            'id' => $id,
            'nam' => $nam,
            'kehoach' => $kehoach,
            'thuchiens' => $thuchiens,
        ];
    }

}