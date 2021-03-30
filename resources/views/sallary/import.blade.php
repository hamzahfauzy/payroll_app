@extends('layouts.app')

@section('template_title')
    Import Referensi
@endsection

@section('content')
    <section class="content container">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Import Referensi</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('sallaries.import') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="">File</label>
                                <input type="file" name="file" id="file" class="form-control" style="height:auto">
                            </div>

                            <button class="btn btn-primary">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
