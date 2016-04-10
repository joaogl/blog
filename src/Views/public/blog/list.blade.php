@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Blog
    @parent
@stop

{{-- Page content --}}
@section('content')

    <div class="container">

        <h2>List of blogs</h2>

        <table class="table table-striped table-hover table-condensed">

            <thead>
            <td>Description</td>
            </thead>

            <tbody>

            @each('public.blog.partials.small_post', $posts, 'post')

            </tbody>

        </table>

    </div>

@endsection
