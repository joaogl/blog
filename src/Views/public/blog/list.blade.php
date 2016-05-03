@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Blog
    @parent
@endsection

{{-- Page content --}}
@section('content')

    <!-- Page Content -->
    <div class="container">

        <h1 class="page-header">
            Blog
            @if($subTitle != null)
                <small>- {{ $subTitle }}</small>
            @endif
        </h1>

        <div class="row">

            <!-- Blog Posts Column -->
            <div class="col-md-8">
                @each('public.blog.partials.small_post', $posts, 'post','public.blog.partials.empty' )
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">
                @include('public.blog.partials.side', ['categories' => $categories])
            </div>

        </div>

    </div>
    <!-- /.Page Content -->

@endsection

{{-- Page scripts --}}
@section('footer_scripts')
    <script>
        var bestPictures = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: 'search',
            remote: {
                url: '/search/%QUERY',
                wildcard: '%QUERY',
                filter: function (parsedResponse) {
                    // parsedResponse is the array returned from your backend
                    console.log(parsedResponse);
                    var parsedResponse = $.map(parsedResponse, function(el) { return el; });
                    return parsedResponse;
                }
            }
        });

        bestPictures.initialize();

        $('.typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 3,
        },
        {
            name: 'bestPictures',
            valueKey: 'first_name',
            displayKey: 'last_name',
            source: bestPictures.ttAdapter(),
            templates: {
                empty: [
                    '<div class="tt-empty-message">',
                        'No Results',
                    '</div>'
                ],
                // header: '<h3 class="tt-tag-heading tt-tag-heading2">Matched Companies</h3>',
                suggestion: function(data){
                    return '<p><strong>' + data.type + '</strong> - ' + data.a + '</p>';
                }
            }

        });
    </script>
@endsection


