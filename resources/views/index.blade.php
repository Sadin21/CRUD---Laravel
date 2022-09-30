@extends('layout')

@section('content')
<body style="background: lightgray">

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        {{-- tambah data --}}
                        <a href="{{ route('create') }}" class="btn btn-md btn-success mb-3">TAMBAH DATA</a>

                        {{-- input file  --}}
                        <a href="{{ route('input') }}" class="btn btn-md btn-success mb-3">Input Image</a>

                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th scope="col">GAMBAR</th>
                                <th scope="col">JUDUL</th>
                                <th scope="col">CONTENT</th>
                                <th scope="col">AKSI</th>
                              </tr>
                            </thead>
                            <tbody>
                                {{-- jika ada data, maka akan di looping, dan jika tidak ada maka akan ditampilkan error message --}}
                              @forelse ($agendas as $a)
                                <tr>
                                    <td class="text-center">
                                        <img src="{{ Storage::url('/storage/agenda/').$a->image }}" class="rounded" style="width: 150px; height: 180px">
                                    </td>
                                    <td>{{ $a->title }}</td>
                                    <td>{!! $a->deskripsi !!}</td>
                                    <td class="text-center">
                                        <a href="{{ route('edit', ['id' => $a->id]) }}" class="btn btn-sm btn-primary">EDIT</a>
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('delete', ['id' => $a->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                        </form>
                                    </td>
                                </tr>
                                {{-- menampilkan pesan belom tersedia --}}
                              @empty
                                  <div class="alert alert-danger">
                                      Data Post belum Tersedia.
                                  </div>
                              @endforelse
                            </tbody>
                          </table>
                          {{-- pagination --}}
                          {{ $agendas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



