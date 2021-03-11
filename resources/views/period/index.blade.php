@extends('layouts.app')

@section('template_title')
    Periode
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Periode') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('periods.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Buat Periode Baru') }}
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
                                        
										<th>Nama</th>
										<th>Bulan</th>
										<th>Tahun</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($periods as $period)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $period->name }}</td>
											<td>{{ getMonth($period->month) }}</td>
											<td>{{ $period->year }}</td>

                                            <td>
                                                <form action="{{ route('periods.destroy',$period->id) }}" method="POST" onsubmit="if(confirm('Apakah anda yakin menghapus data ini ?')){return true}else{return false}">
                                                    <a class="btn btn-sm btn-success" href="{{ route('periods.edit',$period->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
                {!! $periods->links() !!}
            </div>
        </div>
    </div>
@endsection
