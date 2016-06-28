@extends('layouts.admin')

{{-- Page title --}}
@section('title')
    Settings
    @parent
@endsection

{{-- Page content --}}
@section('content')

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Edit setting</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">

            @include('errors.list')

            {!! Form::model($setting, array('route' => array('settings.update', $setting->id))) !!}

            @include('admin.settings.partials.form', ['submitButton' => 'Update setting'])

            {!! Form::close() !!}

        </div>

    </div>

@endsection
