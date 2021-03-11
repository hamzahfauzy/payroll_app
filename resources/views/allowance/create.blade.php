@extends('layouts.app')

@section('template_title')
    Buat Tunjangan
@endsection

@section('content')
    <section class="content container">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Buat Tunjangan</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('allowances.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('allowance.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
