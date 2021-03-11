@extends('layouts.app')

@section('template_title')
    Update Periode
@endsection

@section('content')
    <section class="content container">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Periode</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('periods.update', $period->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('period.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
