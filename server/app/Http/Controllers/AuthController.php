<?php
  
namespace App\Http\Controllers;

use App\Models\DonVi;
use App\Models\Hocvien;
use App\Models\Donvi as ModelsDonvi;
use App\Models\Namhoc;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Trainee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
  
class AuthController extends Controller
{
    public function register()
    {
        $year = Namhoc::get();
        $unit = ModelsDonvi::get();
        $ff = new ModelsDonvi();
        
        return view('auth/register',compact('year','unit'));
    }

    public function test () {
        $donvi = ModelsDonvi::get();
        return $donvi;
    }
  
    public function registerSave(Request $request)
    {
        
        $ans =  $request->all();
        $loai = $ans["dropdown"][0];
        $cha = $ans["dropdown"][1];
        Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ])->validate();

        $donvi = new ModelsDonvi();
        $donvi->LoaiDonVi = $loai;
        if ($loai != 'Trung đoàn') {
            $donvi->DonViCha = $cha;
        }
        $donvi->TenDonVi = $request->donvi;
        
        $donvi->save();
        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type_user' => $loai,
            'ChucVu' => $request->chucvu,
            'QuanHam' =>$request->quanham,
            'DonVi' => $donvi->id
        ]);
  
        return redirect()->route('products');
    }
  
    public function registerHV(Request $request)
    {
        $ans =  $request->all();
        $unitId = $ans["dropdown"][1];
        $year = $ans["dropdown"][0];

        Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ])->validate();
        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type_user' => 'Học viên'
        ]);

        $trainee = Hocvien::create([
            'HoTen' => $request->full_name,
            'CapBac' => $request->capbac,
            'TenLop' => $request->class_name,
            'ThoiGianBatDau' => now()
        ]);

        // $trainee = Hocvien::with('unit')->get();
  
        return redirect()->route('products');
    }
  
    public function login()
    {
        return view('auth/login');
    }
  
    public function loginAction(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();
  
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }
  
        $request->session()->regenerate();
  
        return redirect()->route('dashboard');
    }
  
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
  
        $request->session()->invalidate();
  
        return redirect('/');
    }
 
    public function profile()
    {
        $user = Auth::user();
        $trainee = $user->trainee;
        return view('profile',compact('trainee'));
    }
}