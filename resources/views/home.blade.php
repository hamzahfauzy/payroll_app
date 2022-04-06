@extends('layouts.app')

@section('template_title')
Gaji Karyawan
@endsection

@section('content')
<div class="container">
    @if(Auth::user()->employee)
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Periode</th>
                                    <th>Gaji Total</th>

                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0 ?>
                                @foreach($employeePeriods as $employeePeriod)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $employeePeriod->period->name.' - '.$employeePeriod->period->year }}</td>
                                    <td>{{ $employeePeriod->sallary_total_format }}</td>

                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{ route('payroll',$employeePeriod->id) }}"><i class="fa fa-fw fa-eye"></i> Download</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else

    <div class="row">
        <div class="col-sm-3">
            <div class="card card-body text-center">
                <h2>{{$employee}}</h2>
                <p>Total Karyawan</p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card card-body text-center">
                <h2>{{$period}}</h2>
                <p>Total Periode</p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card card-body text-center">
                <h2>{{$position}}</h2>
                <p>Total Jabatan</p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card card-body text-center">
                <h2>{{$not_paid}}</h2>
                <p>Total Gaji (Belum Dibayar)</p>
            </div>
        </div>
    </div>

    @endif

</div>
@endsection