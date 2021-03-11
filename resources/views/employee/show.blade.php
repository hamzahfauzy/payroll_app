@extends('layouts.app')

@section('template_title')
    {{ $employee->name ?? 'Tampil Karyawan' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Tampil Karyawan</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('employees.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Jabatan:</strong>
                            {{ $employee->position->name }}
                        </div>
                        <div class="form-group">
                            <strong>NIK:</strong>
                            {{ $employee->NIK }}
                        </div>
                        <div class="form-group">
                            <strong>NPWP:</strong>
                            {{ $employee->NPWP }}
                        </div>
                        <div class="form-group">
                            <strong>Nama:</strong>
                            {{ $employee->name }}
                        </div>
                        <div class="form-group">
                            <strong>Area Kerja:</strong>
                            {{ $employee->work_around }}
                        </div>
                        <div class="form-group">
                            <strong>No. Rekening:</strong>
                            {{ $employee->bank_account }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
