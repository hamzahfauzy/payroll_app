@extends('layouts.app')

@section('template_title')
    Import Gaji
@endsection

@section('content')
    <section class="content container">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Import Gaji</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('employee-periods.import') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="">Periode</label>
                                {!! Form::select('period', $periods, 0, ['class'=>'form-control '.($errors->has('period')?'is-invalid':''),'placeholder'=>'- Pilih Periode -']) !!}

                                @error('period')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">File</label>
                                <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" style="height:auto">

                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button class="btn btn-primary">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
