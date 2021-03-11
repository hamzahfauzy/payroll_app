@extends('layouts.app')

@section('template_title')
    Tunjangan Jabatan
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Tunjangan Jabatan') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('allowances.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Buat Baru') }}
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
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Jabatan</th>
										<th>Nama</th>
										<th>Jumlah</th>
										<th>Tipe</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allowances as $allowance)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $allowance->position->name }}</td>
											<td>{{ $allowance->name }}</td>
											<td>{{ $allowance->amount_format }}</td>
											<td>{{ $allowance->allowance_type }}</td>

                                            <td>
                                                <form action="{{ route('allowances.destroy',$allowance->id) }}" method="POST" onsubmit="if(confirm('Apakah anda yakin menghapus data ini ?')){return true}else{return false}">
                                                    <a class="btn btn-sm btn-success" href="{{ route('allowances.edit',$allowance->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
                    </div>
                </div>
                {!! $allowances->links() !!}
            </div>
        </div>
    </div>
@endsection
