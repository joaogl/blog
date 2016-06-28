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
                <h1 class="page-header">Edit post</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">

            @include('errors.list')

            {!! Form::model($post, array('route' => array('post.update', $post->id))) !!}

            @include('admin.posts.partials.form', ['submitButton' => 'Update posts'])

            {!! Form::close() !!}

        </div>

    </div>

@endsection
