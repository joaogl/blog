@extends('layouts.admin')

{{-- Page title --}}
@section('title')
    Posts
    @parent
@endsection

{{-- Page content --}}
@section('content')

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Create post</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">

            {!! Form::model(null, array('route' => array('create.post'))) !!}

            @include('admin.posts.partials.form', ['submitButton' => 'Create post'])

            {!! Form::close() !!}

        </div>

    </div>

@endsection
