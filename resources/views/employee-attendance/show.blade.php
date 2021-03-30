@extends('layouts.app')

@section('template_title')
    {{ $employeeAttendance->name ?? 'Show Employee Attendance' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Employee Attendance</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('employee-attendances.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Employee Id:</strong>
                            {{ $employeeAttendance->employee_id }}
                        </div>
                        <div class="form-group">
                            <strong>Attendance Id:</strong>
                            {{ $employeeAttendance->attendance_id }}
                        </div>
                        <div class="form-group">
                            <strong>Period Id:</strong>
                            {{ $employeeAttendance->period_id }}
                        </div>
                        <div class="form-group">
                            <strong>Amount:</strong>
                            {{ $employeeAttendance->amount }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
