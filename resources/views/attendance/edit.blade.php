@extends('layouts.app')

@section('template_title')
    Update Absensi
@endsection

@section('content')
    <section class="content container">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Absensi</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('attendances.update', $attendance->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('attendance.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
