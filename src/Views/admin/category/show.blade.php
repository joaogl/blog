@extends('layouts.admin')

{{-- Page title --}}
@section('title')
    Category details
    @parent
@endsection

{{-- page level styles --}}
@section('header_styles')

    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/user_profile.css') }}" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/extensions/bootstrap/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('css/tables.css') }}" rel="stylesheet" type="text/css" />

@endsection

{{-- Page content --}}
@section('content')

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">List of categories <small>- {{ $cat->name }}</small></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">

            <div class="col-lg-12">
                <div id="tab1" class="tab-pane fade active in">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="col-md-3">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="users">
                                                <tr>
                                                    <td>Name</td>
                                                    <td>{{ $cat->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Slug</td>
                                                    <td>{{ $cat->slug }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Created at</td>
                                                    <td>
                                                        {!! $cat->created_at->diffForHumans() !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Description</td>
                                                    <td>
                                                        {!! $cat->description !!}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <ul class="panel-body">

                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs">
                                                <li class="active">
                                                    <a href="#posts" data-toggle="tab" aria-expanded="true">Posts</a>
                                                </li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane fade active in" id="posts">
                                                    <table class="table table-bordered" id="table2">
                                                        <thead>
                                                            <tr class="filters">
                                                                <th>Title</th>
                                                                <th>Author</th>
                                                                <th>Category</th>
                                                                <th>Published at</th>
                                                                <th>Views</th>
                                                                <th>Likes</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @if (!$cat->posts->isEmpty())
                                                                @foreach ($cat->posts as $post)
                                                                    <tr>
                                                                        <td>{!! $post->title !!}</td>
                                                                        <td>{!! $post->created_by !!}</td>
                                                                        <td>{!! $post->getCategory->name !!}</td>
                                                                        <td>{!! $post->created_at->diffForHumans() !!}</td>
                                                                        <td>{!! $post->views !!}</td>
                                                                        <td>{!! $post->likes !!}</td>
                                                                        <td>
                                                                            <a href="{{ route('post.show', $post->id) }}"><i class="fa fa-eye" title="View post"></i></a>

                                                                            <a href="{{ route('post.update', $post->id) }}"><i class="fa fa-pencil" title="Edit post"></i></a>

                                                                            <a href="{{ route('confirm-delete/post', $post->id) }}" data-toggle="modal" data-target="#delete_confirm"><i class="fa fa-trash" title="Delete post"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- page level scripts --}}
@section('footer_scripts')

    <!-- Bootstrap WYSIHTML5 -->
    <script  src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>

    <!-- Bootstrap DataTables -->
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/bootstrap/dataTables.bootstrap.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#table2').DataTable( {
                "language": {
                    "emptyTable": "No posts available"
                }
            } );
        });
    </script>

@endsection