<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use App\UserLayout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SuperUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id = Auth::getUser()->id;
        $image = Auth::getUser()->image;
        $user = User::all()->where('id', '=', $id);
        return view('superUser.index', compact('user', 'image'));
    }

    public function cariAdmin(Request $request)
    {
        $nama = $request->cari;
        $image = Auth::getUser()->image;
        $user = User::all()->where('name', $nama);
        $total = $user->count();
        return view('superUser/Admin', compact('user', 'total', 'image'));
    }

    public function cariCustomer(Request $request)
    {
        $nama = $request->cari;
        $image = Auth::getUser()->image;
        $user = User::all()
            ->where('name', $nama);
        $total = $user->count();
        return view('superUser/customer', compact('user', 'total', 'image'));
    }

    public function changeName(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:users,name,except,id',
        ]);
        $id = Auth::getUser()->id;
        User::where('id', $id)->update([
            'name' => $request->nama
        ]);
        return back()->with(['success' => 'Username berhasil diubah']);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'pass1' => 'required',
            'pass2' => 'required'
        ]);
        $pass = Auth::getUser()->password;
        $id = Auth::getUser()->id;
        if (Hash::check($request->pass1, $pass)) {
            User::where('id', $id)->update([
                'password' => Hash::make($request->pass2)
            ]);
            return back()->with(['success' => 'Password berhasil diubah']);
        }
        return back()->with(['danger' => 'Wrong password']);
    }

    public function changeImage(Request $request)
    {
        $folderPath = public_path('assets/images/' . $request->img);
        $request->validate([
            'images' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->img == "default.jpg") {
            if ($files = $request->file('images')) {
                $destinationPath = public_path('assets/images/');
                $profileImage =  $files->getClientOriginalName();
                $files->move($destinationPath, $profileImage);
                $insert['image'] = "$profileImage";
                User::where('id', $request->id)->update([
                    'image' => "$profileImage"
                ]);
                return back()->with(['success' => 'Image berhasil diubah']);
            }
        } else {
            if (File::exists(public_path('assets/images/' . $request->img))) {

                File::delete(public_path('assets/images/' . $request->img));
            }
            if ($files = $request->file('images')) {
                $destinationPath = public_path('assets/images/');
                $profileImage =  $files->getClientOriginalName();
                $files->move($destinationPath, $profileImage);
                $insert['image'] = "$profileImage";
                User::where('id', $request->id)->update([
                    'image' => "$profileImage"
                ]);
                return back()->with(['success' => 'Image berhasil diubah']);
            }
        }
    }

    public function admin()
    {
        $image = Auth::getUser()->image;
        $user = User::all()
            ->where('level', '=', '2');
        $total = $user->count();
        return view('superUser/Admin', compact('user', 'total', 'image'));
    }

    public function customer()
    {
        $image = Auth::getUser()->image;
        $user = User::all()
            ->where('level', '=', '3');
        $total = $user->count();
        return view('superUser/customer', compact('user', 'total', 'image'));
    }

    public function tasks()
    {
        $image = Auth::getUser()->image;
        $admin = User::all()
            ->where('level', '=', '2');
        $user = User::all()
            ->where('level', '=', '3');
        $task = DB::select(DB::raw('SELECT t.id, pesan, a1.phone hp, status, a1.name admin, a2.name customer FROM tasks t
        INNER JOIN users a1 ON t.id_admin = a1.id INNER JOIN users a2 ON t.id_customer = a2.id'));

        return view('superUser/task', compact('task', 'admin', 'user', 'image'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createAdmin(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:users,name,except,id',
            'phone' => 'required|max:13',
            'password' => 'required',
        ]);
        User::create([
            'name' => $request->nama,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'image' => "default.jpg",
            'level' => 2,
            'hit' => 0
        ]);
        $request->session()->put('passAdmin', $request->password);
        return redirect('superUser/admin');
    }

    public function createCustomer(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:users,name,except,id',
            'phone' => 'required|max:13',
            'password' => 'required',
        ]);
        User::create([
            'name' => $request->nama,
            'phone' => $request->phone,
            'image' => "default.jpg",
            'password' => Hash::make($request->password),
            'level' => 3,
            'hit' => 0
        ]);
        $request->session()->put('passCustomer', $request->password);
        return redirect('superUser/customer');
    }

    public function createTasks(Request $request)
    {
        $validasi = Validator::make(request()->all(),[
            'pesan' => 'required',
        ]);

        if($validasi->fails()){
            return back()->with(['danger' => 'Pesan harus diisi']);
        }else{
            User::where('id', $request->id)
            ->update([
                'hit' => $request->hit + 1
            ]);
        Task::create([
            'id_admin' => $request->admin,
            'id_customer' => $request->customer,
            'pesan' => $request->pesan,
            'status' => 0
        ]);
        return back()->with(['success' => 'Task berhasil ditambahkan']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAdmin(Request $request)
    {
        User::where('id', $request->id)
            ->update([
                'name' => $request->nama,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'level' => 2
            ]);
        return redirect('superUser/admin');
    }

    public function updateCustomer(Request $request)
    {
        User::where('id', $request->id)
            ->update([
                'name' => $request->nama,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'level' => 3
            ]);
        return redirect('superUser/customer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAdmin(Request $request)
    {
        $task = Task::all()->where('id_admin',$request->id)->first();
        if($task!=null){
            return back()->with(['danger' => 'Data tidak dapat dihapus karena memiliki relasi']);
        }else{
            User::destroy('id', $request->id);
            return back()->with(['success' => 'Data berhasil dihapus']);

        }
    }

    public function destroyCustomer(Request $request)
    {
        $layout = UserLayout::where('id_user',$request->id)->first();
        $task = Task::all()->where('id_customer',$request->id)->first();
        if ($task==null && $layout==null) {
            User::destroy('id', $request->id);
            return back()->with(['success' => 'Data berhasil dihapus']);
        } else {
            return back()->with(['danger' => 'Data tidak dapat dihapus karena memiliki relasi']);
        }
    }

    public function destroyTask(Request $request)
    {
        Task::destroy('id', $request->id);
        return redirect('superUser/tasks');
    }
}
