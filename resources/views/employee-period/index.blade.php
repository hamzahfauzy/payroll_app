@extends('layouts.app')

@section('template_title')
Gaji Karyawan
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Gaji Karyawan') }}
                        </span>

                        <div class="float-right">
                            <a href="{{ route('employee-periods.import') }}" class="btn btn-success btn-sm">
                                {{ __('Import Gaji') }}
                            </a>

                            <a href="{{ route('employee-periods.download') }}" class="btn btn-primary btn-sm">
                                {{ __('Download Format Import') }}
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
                    <form action="" name="filter">
                        {!! Form::select('period', $periods, $period, ['required', 'class'=>'form-control','placeholder'=>'- Pilih Periode -','onchange'=>'filter.submit()']) !!}
                    </form>
                    <br>
                    @if(count($employeePeriods) || isset($_GET['keyword']))
                    <form action="" name="filter2">
                        <input type="hidden" name="period" value="{{$_GET['period']??0}}">
                        <div class="form-group">
                            <label for="">Cari Karyawan</label>
                            <input type="text" value="{{isset($_GET['keyword'])?$_GET['keyword']:''}}" name="keyword" class="form-control" placeholder="Cari Berdasarkan ID, Nama, Area Kerja atau No Rekening Lalu Tekan Enter ...">
                        </div>
                        <div class="form-group">
                            <label for="">Jumlah Data</label>
                            {!! Form::select('per_page', $perPages, $perPage, ['required', 'class'=>'form-control','placeholder'=>'- Pilih Jumlah Data -','onchange'=>'filter2.submit()']) !!}
                        </div>
                    </form>
                    @endif
                    <form action="{{route('employee-periods.bulk-download')}}" name="bulk-export" method="post">
                    @csrf
                    <input type="hidden" name="period" value="{{$_GET['period']??0}}">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>

                                    <th>Karyawan</th>
                                    <th>Periode</th>
                                    <th>Status</th>
                                    <th>Gaji Total</th>

                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employeePeriods as $employeePeriod)
                                <tr>
                                    <td><input type="checkbox" name="download[]" value="{{$employeePeriod->id}}"></td>

                                    <td>{{ $employeePeriod->employee->name }}</td>
                                    <td>{{ $employeePeriod->period->name }}</td>
                                    <td>
                                        {{ $employeePeriod->status }}<br>
                                        @if($employeePeriod->payout_at == null)
                                        <a href="{{route('employee-periods.pay',$employeePeriod->id)}}" onclick="if(confirm('Apakah anda yakin akan membayar gaji ini')){return true}else{return false}" class="btn btn-warning">Bayar</a>
                                        @else
                                        {{ $employeePeriod->payout_at }}
                                        @endif
                                    </td>
                                    <td>{{ $employeePeriod->sallary_total_format }}</td>

                                    <td>
                                        <a class="btn btn-sm btn-primary " href="{{ route('payroll',$employeePeriod->id) }}"><i class="fa fa-fw fa-eye"></i> Download</a>
                                        <a class="btn btn-sm btn-success" href="{{ route('employee-periods.sallary-panel',$employeePeriod->id) }}"><i class="fa fa-fw fa-edit"></i> Panel Gaji</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if(count($employeePeriods))
                        <button class="btn btn-danger" name="action" value="hapus">Hapus Terpilih</button>
                        <button class="btn btn-success" name="action" value="terpilih">Download Terpilih</button>
                        <button class="btn btn-success" name="action" value="semua">Download Semua</button>
                        @endif
                    </div>
                    </form>
                </div>
            </div>
            {!! $employeePeriods->links() !!}
        </div>
    </div>
</div>
@endsection