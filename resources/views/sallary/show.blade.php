@extends('layouts.app')

@section('template_title')
    {{ $sallary->name ?? 'Show Sallary' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Sallary</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('sallaries.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $sallary->name }}
                        </div>
                        <div class="form-group">
                            <strong>Sallary Type:</strong>
                            {{ $sallary->sallary_type }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
