@extends('layouts.app')

@section('template_title')
    Karyawan
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Karyawan') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('employees.delete-all') }}" onclick="if(confirm('Apakah anda yakin akan menghapus semua data karyawan')){return true}else{return false}" class="btn btn-danger btn-sm">
                                  {{ __('Hapus Semua Karyawan') }}
                                </a>

                                <a href="{{ route('employees.import') }}" class="btn btn-success btn-sm">
                                  {{ __('Import Karyawan') }}
                                </a>

                                <a href="{{ route('employees.create') }}" class="btn btn-primary btn-sm">
                                  {{ __('Buat Karyawan Baru') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif

                    <div class="card-body">
                        <form action="">
                            <div class="form-group">
                                <label for="">Cari Karyawan</label>
                                <input type="text" value="{{isset($_GET['keyword'])?$_GET['keyword']:''}}" name="keyword" class="form-control" placeholder="Cari Berdasarkan ID, Nama, Area Kerja atau No Rekening Lalu Tekan Enter ...">
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>#</th>
                                        
										<th>Karyawan</th>
										<th>Jabatan</th>
										<th>Area Kerja</th>
										<th>No. Rekening</th>
										<th>Gaji Pokok</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $employee)
                                        <tr>
                                        <td><input type="checkbox" id="delete-check-{{$employee->id}}" onchange="setDelete(event)" value="{{$employee->id}}"></td>
                                            
											<td>
                                                {{ $employee->name }}
                                                <br>
                                                <b>{{ $employee->NIK }}</b>
                                            </td>
											<td>{{ $employee->position->name }}</td>
											<td>{{ $employee->work_around }}</td>
											<td>{{ $employee->bank_account }}</td>
											<td>{{ number_format($employee->gaji_pokok) }}</td>

                                            <td>
                                                <form action="{{ route('employees.destroy',$employee->id) }}" method="POST" onsubmit="if(confirm('Apakah anda yakin menghapus data ini ?')){return true}else{return false}">
                                                    <a class="btn btn-sm btn-success" href="{{ route('employees.edit',$employee->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <form action="{{route('employee.bulk-delete')}}" name="bulk-export" method="post">
                        @csrf
                        <div id="hidden-field"></div>
                        <button class="btn btn-success">Hapus Terpilih</button>
                        </form>
                    </div>
                </div>
                {!! $employees->links() !!}
            </div>
        </div>
    </div>
    <script>
    var deleteId = []
    function setDelete(e){
        if(e.target.checked)
            deleteId.push(e.target.value)
        else
        {
            var index = deleteId.indexOf(e.target.value);
            if (index !== -1) {
                deleteId.splice(index, 1);
            }
        }
        generateField()
    }

    function generateField()
    {
        document.getElementById('hidden-field').innerHTML = ''
        deleteId.forEach(val => {
            document.getElementById('hidden-field').innerHTML += '<input type="hidden" name="delete[]" value="'+val+'">'
        })
    }
    </script>
@endsection
