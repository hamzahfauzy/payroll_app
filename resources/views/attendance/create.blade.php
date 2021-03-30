@extends('layouts.app')

@section('template_title')
    Buat Absensi
@endsection

@section('content')
    <section class="content container">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Buat Absensi</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('attendances.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('attendance.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
