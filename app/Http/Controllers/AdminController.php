<?php

namespace App\Http\Controllers;

use App\Album;
use Illuminate\Http\Request;
use App\User;
use App\Layouts;
use App\Task;
use App\UserLayout;
use Illuminate\Support\Facades\DB;
use ZipArchive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id = Auth::getUser()->id;
        $image = Auth::getUser()->image;
        $user = User::all()->where('id', '=', $id);
        return view('admin.index', compact('user', 'image'));
    }

    public function changePassword(Request $request)
    {
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

    public function task()
    {
        $id = Auth::getUser()->id;
        $image = Auth::getUser()->image;
        $task = DB::table('tasks')
            ->join('users', 'users.id', '=', 'tasks.id_customer')
            ->select('users.name', 'tasks.*')
            ->where('tasks.id_admin', '=', $id)
            ->get();
        return view('admin/task', compact('task', 'image'));
    }

    public function updateStatus(Request $request)
    {
        Task::where('id', $request->id)
            ->update([
                'status' => 1
            ]);
        return redirect('admin/task');
    }

    public function preview(Request $request)
    {
        $a = 0;
        $id = $request->id;
        $nama = $request->nama;
        $customer = user::all()->where('id', $id);
        $layouts = Layouts::all();
        $userLayouts = UserLayout::all()->where('id_user', '=', $id);
        $album = DB::table('albums')
            ->join('users', 'users.id', '=', 'albums.id_user')
            ->select('users.name', 'users.id as id_user', 'albums.*')
            ->where('id_user', '=', $id)
            ->get();
        return view('user.preview', [
            'album' => $album,
            'id' => $id,
            'nama' => $nama,
            'layouts' => $layouts,
            'userLayouts' => $userLayouts,
            'user' => $customer,
            'a' => $a
        ]);
    }

    public function download(Request $request)
    {
        $zip = new ZipArchive;

        $fileName = $request->nama . '.zip';

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = File::files(public_path('assets/images/' . $request->nama . '*'));

            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }

            $zip->close();
        }

        return response()->download(public_path($fileName));
    }

    public function destroy(Request $request)
    {
        $folderPath = public_path('assets/images/' . $request->nama);
        $all = Album::where('id_user', '=', $request->id);
        if (File::exists(public_path('assets/images/' . $request->nama))) {
            $folderPath = public_path('assets/images/' . $request->nama);
            File::deleteDirectory($folderPath);
            DB::delete('delete from albums where id_user = ' . $request->id);
            return redirect('admin/task');
        }
        return redirect('admin/task');
    }
}
