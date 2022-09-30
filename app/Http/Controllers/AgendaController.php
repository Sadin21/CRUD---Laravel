<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Agenda;
use Illuminate\Http\UploadedFile;

class AgendaController extends Controller
{
    public function index()
    {
        // ambil data dari database melalui model Agenda, method latest untuk menampilkan data terbaru paginate untuk membatasi data yang ditampilkan
        $agendas = Agenda::latest()->paginate(10);
        return view('index', ['agendas' => $agendas]);
    }

    public function create()
    {
        return view('agenda.create');
    }

    public function store(Request $request)
    {
        // // validasi data
        $validation = $this->validate($request, [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required|min:5',
            'deskripsi'   => 'required|min:10'
        ]);

        if($validation)
        {
            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('image');

            // memberi nama file random
            $nama_file = time()."_".$file->hashName();

            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = '/public/storage/agenda/';
            $file->storeAs($tujuan_upload,$nama_file);

            // create data
            Agenda::create([
                'image'     => $nama_file,
                'title'     => $request->title,
                'deskripsi'   => $request->deskripsi
            ]);

            // notification
            return redirect()->route('index')->with('success', 'Agenda berhasil ditambahkan');
        }else{
            return redirect()->route('index')->with('error', 'Agenda gagal ditambahkan');
        }

        // redirect to index
        return redirect('index');
    }

    public function edit($id)
    {
        $agenda = Agenda::find($id);
        return view('agenda.edit', ['agenda' => $agenda]);
    }

    public function update(Request $request, $id)
    {
        $agenda = Agenda::find($id);
        // validasi data
        $validation = $this->validate($request, [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required|min:5',
            'deskripsi'   => 'required|min:10'
        ]);

        // cek jika file image tidak kosong
        if ($request->hasFile('image')) {
            // upload new image
            $image = $request->file('image');
            $image->storeAs('/public/storage/agenda/', $image->hashName());

            // hapus image lama
            Storage::delete('/public/storage/agenda/'.$agenda->image);

            // update
            $agenda->image = $image->hashName();
            $agenda->title = $request->title;
            $agenda->deskripsi = $request->deskripsi;
            $agenda->save();
        } else {
            // update tanpa image
            $agenda->title = $request->title;
            $agenda->deskripsi = $request->deskripsi;
            $agenda->save();
        }

        // redirect to index
        return redirect()->route('index');
    }

    public function destroy($id)
    {
        $agenda = Agenda::find($id);
        Storage::delete('/public/storage/agenda/'.$agenda->image);
        $agenda->delete();
        return redirect()->route('index');
    }
}
