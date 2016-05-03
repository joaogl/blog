
<!-- Blog Post -->

<!-- Title -->
<h1>{{ $post->title }}</h1>

<!-- Author -->
<p class="lead">
    by {{ $post->getAuthor->first_name }} {{ $post->getAuthor->last_name }}
</p>

<hr>

<!-- Date/Time -->
<p><span class="glyphicon glyphicon-time"></span> Posted on {{ $post->created_at->format('M d, Y \a\t h:i a') }}</p>

<hr>

<!-- Post Content -->
{!! $post->contents !!}
<hr>

<!-- Blog Comments -->

<!-- Comments Form -->
@if (Sentinel::check())
    @include('public.comments.partials.form', ['post' => $post])
    <hr>
@endif

<!-- Comment -->
@include('public.comments.partials.list', ['comments' => $post->comments()->orderBy('created_at', 'desc')->take(5)->get() ])
