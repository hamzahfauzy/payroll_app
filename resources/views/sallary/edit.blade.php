@extends('layouts.app')

@section('template_title')
    Update Referensi Bonus dan Potongan
@endsection

@section('content')
    <section class="content container">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Referensi Bonus dan Potongan</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('sallaries.update', $sallary->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('sallary.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
