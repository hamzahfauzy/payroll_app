@extends('layouts.app')

@section('template_title')
    Panel Gaji Karyawan
@endsection

@section('content')
    <form method="POST" action="{{ route('employee-periods.sallary-panel',$employeePeriod->id) }}"  role="form" enctype="multipart/form-data">
    @csrf
    <section class="content container">
        <div class="card card-default">
            <div class="card-header">
                <span class="card-title">Panel Gaji Karyawan {{$employeePeriod->employee->name}}</span>
                <div class="float-right">
                    <button class="btn btn-primary btn-sm">Submit</button>
                    <a href="{{route('employee-periods.index',['period'=>$employeePeriod->id])}}" class="btn btn-warning btn-sm">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @includeif('partials.errors')
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h3>Absensi</h3>
                    </div>
                    @foreach($absensi as $absen)
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="">{{$absen->attendance->name}}</label>
                            <input type="number" name="attendance[{{$absen->attendance->id}}]" class="form-control" value="{{$absen->amount}}">
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        {{-- FORM BONUS --}}
                        <h3>Bonus</h3>
                        @foreach($bonus as $sallary)
                        <div class="form-group">
                            <label for="">{{$sallary->sallary->name}}</label>
                            <input type="number" name="sallary[{{$sallary->sallary_id}}]" class="form-control" value="{{$sallary->amount}}">
                        </div>
                        @endforeach
                    </div>
                    <div class="col-sm-12 col-md-6">
                        {{-- FORM POTONGAN --}}
                        <h3>Potongan</h3>
                        @foreach($potongan as $sallary)
                        <div class="form-group">
                            <label for="">{{$sallary->sallary->name}}</label>
                            <input type="number" name="sallary[{{$sallary->sallary_id}}]" class="form-control" value="{{$sallary->amount}}">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    </form>
@endsection
