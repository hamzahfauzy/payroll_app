@extends('layouts.app')

@section('template_title')
    Absensi
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Absensi') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('attendances.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Nama</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendances as $attendance)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $attendance->name }}</td>

                                            <td>
                                                <form action="{{ route('attendances.destroy',$attendance->id) }}" method="POST" onsubmit="if(confirm('Apakah anda yakin menghapus data ini ?')){return true}else{return false}">
                                                    <a class="btn btn-sm btn-success" href="{{ route('attendances.edit',$attendance->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $attendances->links() !!}
            </div>
        </div>
    </div>
@endsection
