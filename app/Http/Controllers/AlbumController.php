<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Album;
use App\Layouts;
use App\User;
use App\UserLayout;
use ZipArchive;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
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
        return view('user.index');
    }

    public function upload(User $user)
    {
        $a = 1;
        $id = Auth::getUser()->id;
        $nama = Auth::getUser()->name;
        $image = Auth::getUser()->image;
        $layouts = Layouts::all();
        $total = Album::all()->where('id_user', $id)->count();
        $userLayouts = UserLayout::all()->where('id_user', '=', $id);
        $album = DB::table('albums')
            ->join('users', 'users.id', '=', 'albums.id_user')
            ->select('users.name', 'users.id as id_user', 'albums.*')
            ->where('id_user', '=', $id)
            ->get();
        $hasil = 0;
        return view('user.upload', [
            'album' => $album,
            'id' => $id,
            'nama' => $nama,
            'layouts' => $layouts,
            'userLayouts' => $userLayouts,
            'hasil' => $hasil,
            'user' => $user,
            'a' => $a,
            'image' => $image,
            'total' => $total
        ]);
    }

    // public function preview(Request $request)
    // {
    //     $a = 0;
    //     $id = $request->id;
    //     $nama = $request->nama;
    //     $customer = user::all()->where('id', $id);
    //     $layouts = Layouts::all();
    //     $userLayouts = UserLayout::all()->where('id_user', '=', $id);
    //     $album = DB::table('albums')
    //         ->join('users', 'users.id', '=', 'albums.id_user')
    //         ->select('users.name', 'users.id as id_user', 'albums.*')
    //         ->where('id_user', '=', $id)
    //         ->get();
    //     return view('user.preview', [
    //         'album' => $album,
    //         'id' => $id,
    //         'nama' => $nama,
    //         'layouts' => $layouts,
    //         'userLayouts' => $userLayouts,
    //         'user' => $customer,
    //         'a' => $a
    //     ]);
    // }

    // public function print(User $user)
    // {
    //     $id = $user->id;
    //     $album = DB::table('albums')
    //         ->join('users', 'users.id', '=', 'albums.id_user')
    //         ->select('users.name', 'users.id as id_user', 'albums.*')
    //         ->where('id_user', '=', $id)
    //         ->get();
    //     return view('user.print', [
    //         'album' => $album,
    //         'id' => $id
    //     ]);
    // }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function download(Request $request)
    // {
    //     $zip = new ZipArchive;

    //     $fileName = $request->nama . '.zip';

    //     if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
    //         $files = File::files(public_path('assets/images/' . $request->nama . '*'));

    //         foreach ($files as $key => $value) {
    //             $relativeNameInZipFile = basename($value);
    //             $zip->addFile($value, $relativeNameInZipFile);
    //         }

    //         $zip->close();
    //     }

    //     return response()->download(public_path($fileName));
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Request $request)
    {
        $id = Auth::getUser()->id;
        $album = DB::table('albums')
            ->join('users', 'users.id', '=', 'albums.id_user')
            ->select('users.name', 'users.id as id_user', 'albums.*')
            ->where('id_user', '=', $id)
            ->get();
        $total = $album->count();
        $request->validate([
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4048'
        ]);

        $nama = $request->nama;
        $id = $request->id;
        if ($request->file('image')) {
            foreach ($request->file('image') as $photo) {
                $file = $photo;
                $size = getimagesize($file);
                $width = $size[0];
                $height = $size[1];
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $picture = date('His') . '_' . $filename;
                $pictures[] = $picture;
                $file->move(public_path('assets/images/' . $nama), $picture); // upload path
                $postArray = ['image' => $picture,];
                $insert['image'] = "$picture";

                $total = $total + 1;
                $data = new Album();
                $data->image = "$picture";
                $data->id_user = $id;
                $data->width = $width;
                $data->height = $height;
                $data->order = $total;
                $data->save();
            }
        }

        // $imageName = time().'.'.$request->image->extension();
        // $request->image->move(public_path('assets/images'), $imageName);
        return redirect('/customer');
    }

    public function bgUpload(Request $request)
    {
        $request->validate([
            'images' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($files = $request->file('images')) {
            $destinationPath = public_path('assets/images/' . $request->nama);
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);
            $insert['image'] = "$profileImage";
            User::where('id', $request->id)->update([
                'image' => "$profileImage"
            ]);
            return redirect('/customer');
        }
    }



    // public function TambahCustomer(Request $request)
    // {
    //     $data = new User;
    //     $data->nama = $request->user;
    //     $data->background = null;
    //     $data->header = null;
    //     $data->save();

    //     $id = $data->id;

    //     return redirect('upload/' . $id);
    // }

    public function layouts(Request $request)
    {
        $data = new UserLayout();
        $data->id_user = $request->id_user;
        $data->id_layout = $request->id_layouts;
        $data->save();

        $id = $request->id_user;

        return redirect('/customer');
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
    public function change(Request $request)
    {
        $idDrag = $request->idDrag;
        $idDrop = $request->idDrop;
        $dragPos = $request->drag;
        $dropPos = $request->drop;

        if ($dragPos == $dropPos) {
            return response()->json(['success' => "Data gagal"]);
        } else {
            $dataDrag = Album::find($idDrag);
            $dataDrag->order = $dropPos;
            $dataDrag->save();

            $dataDrop = Album::find($idDrop);
            $dataDrop->order = $dragPos;
            $dataDrop->save();
            return response()->json(['success' => "Data sukses"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album, Request $request)
    {
        $id = Auth::getUser()->id;
        $total = Album::all()->where('id_user', $id)->count();
        $order = $request->order;
        $count = $total - $order;
        $a = 0;
        if (File::exists(public_path('assets/images/' . $request->nama . '/' . $album->image))) {
            for ($i = 1; $i <= $count; $i++) {
                Album::where('order', $order + $i)
                    ->update([
                        'order' => $order + $a
                    ]);
                $a++;
            }

            File::delete(public_path('assets/images/' . $request->nama . '/' . $album->image));
            Album::destroy($album->id);
        }
        return redirect('/customer');
    }

    public function destroyLayout(Request $request)
    {
        UserLayout::destroy($request->id);
        return redirect('/customer');
    }
}
