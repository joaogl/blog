
<!-- Post Title -->
<h2>
    <a href="{{ url('blog/' . $post->id) }}">{{ $post->title }}</a>
</h2>

<!-- Post Author -->
<p class="lead">
    by <a href="{{ url('account/' . $post->id) }}">{{ $post->getAuthor->first_name }} {{ $post->getAuthor->last_name }}</a>
</p>
<p><span class="glyphicon glyphicon-time"></span> Posted on {{ $post->created_at->format('M d, Y \a\t h:i a') }}</p>

<hr>

<!-- Post Content -->
<p>{!! str_limit($post->contents, $limit = 300, $end = '.......') !!}</p>

<!-- Post Footer -->
<br>
<br>

<a class="btn btn-primary" href="{{ url('blog/' . $post->id) }}">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

<hr>
