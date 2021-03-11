@extends('layouts.app')

@section('template_title')
    Update Jabatan
@endsection

@section('content')
    <section class="content container">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Jabatan</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('positions.update', $position->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('position.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
