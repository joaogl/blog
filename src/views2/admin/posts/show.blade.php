@extends('layouts.admin')

{{-- Page title --}}
@section('title')
    Post details
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
                <h1 class="page-header">List of posts <small>- {{ $post->title }}</small></h1>
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
                                                    <td>Title</td>
                                                    <td>{{ $post->title }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Slug</td>
                                                    <td>{{ $post->slug }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Author</td>
                                                    <td>
                                                        {!! $post->created_by !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Created at</td>
                                                    <td>
                                                        {!! $post->created_at->diffForHumans() !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Views</td>
                                                    <td>
                                                        {!! $post->views !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Likes</td>
                                                    <td>
                                                        {!! $post->likes !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Keywords</td>
                                                    <td>
                                                        {!! $post->keywords !!}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        {!! $post->contents !!}
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