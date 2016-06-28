@extends('layouts.admin')

{{-- Page title --}}
@section('title')
    Deleted posts
    @parent
@endsection

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/extensions/bootstrap/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('css/tables.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Page content --}}
@section('content')

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">List of deleted posts</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <table class="table table-bordered" id="table">
                <thead>
                <tr class="filters">
                    <th>ID</th>
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
                @foreach ($posts as $post)
                    <tr>
                        <td>{!! $post->id !!}</td>
                        <td>{!! $post->title !!}</td>
                        <td>{!! $post->created_by !!}</td>
                        <td>{!! $post->getCategory->name !!}</td>
                        <td>{!! $post->created_at->diffForHumans() !!}</td>
                        <td>{!! $post->views !!}</td>
                        <td>{!! $post->likes !!}</td>
                        <td>
                            <a href="{{ route('restore/post', $post->id) }}"><i class="fa fa-arrow-circle-left"></i></a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>

        </div>

    </div>

@endsection

@section('footer_scripts')

    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/bootstrap/dataTables.bootstrap.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>

@endsection
