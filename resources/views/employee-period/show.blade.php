@extends('layouts.app')

@section('template_title')
    {{ $employeePeriod->name ?? 'Show Employee Period' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Employee Period</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('employee-periods.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Employee Id:</strong>
                            {{ $employeePeriod->employee_id }}
                        </div>
                        <div class="form-group">
                            <strong>Period Id:</strong>
                            {{ $employeePeriod->period_id }}
                        </div>
                        <div class="form-group">
                            <strong>Status:</strong>
                            {{ $employeePeriod->status }}
                        </div>
                        <div class="form-group">
                            <strong>Payout At:</strong>
                            {{ $employeePeriod->payout_at }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
