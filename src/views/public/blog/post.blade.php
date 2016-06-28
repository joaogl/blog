@extends('layouts.default')

{{-- Page title --}}
@section('title')
    {{ $post->title }}
    @parent
@endsection

{{-- Page content --}}
@section('content')

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Post Column -->
            <div class="col-lg-8">
                @include('public.blog.partials.post', ['post' => $post])
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">
                @include('public.blog.partials.side', ['categories' => $categories])
            </div>

        </div>

    </div>
    <!-- /.Page Content -->

@endsection
