@extends('layouts.app')

@section('template_title')
    {{ $attendance->name ?? 'Show Attendance' }}
@endsection

@section('content')
    <section class="content container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Tampil Absensi</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('attendances.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $attendance->name }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
