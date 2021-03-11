@extends('layouts.app')

@section('template_title')
    {{ $employeeSallary->name ?? 'Show Employee Sallary' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Employee Sallary</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('employee-sallaries.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Employee Id:</strong>
                            {{ $employeeSallary->employee_id }}
                        </div>
                        <div class="form-group">
                            <strong>Sallary Id:</strong>
                            {{ $employeeSallary->sallary_id }}
                        </div>
                        <div class="form-group">
                            <strong>Period Id:</strong>
                            {{ $employeeSallary->period_id }}
                        </div>
                        <div class="form-group">
                            <strong>Amount:</strong>
                            {{ $employeeSallary->amount }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
