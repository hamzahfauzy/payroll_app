@extends('layouts.app')

@section('template_title')
    {{ $allowance->name ?? 'Show Allowance' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Allowance</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('allowances.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Position Id:</strong>
                            {{ $allowance->position_id }}
                        </div>
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $allowance->name }}
                        </div>
                        <div class="form-group">
                            <strong>Amount:</strong>
                            {{ $allowance->amount }}
                        </div>
                        <div class="form-group">
                            <strong>Allowance Type:</strong>
                            {{ $allowance->allowance_type }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
