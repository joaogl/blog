@extends('layouts.admin')

{{-- Page title --}}
@section('title')
    Posts
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
                <h1 class="page-header">
                    List of posts

                    <div style="float: right;">
                        <a href="{{ route('create.post') }}">
                            {!! Form::submit('Create new post', ['class' => 'btn btn-primary form-control']) !!}
                        </a>
                    </div>

                </h1>
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
                            <a href="{{ route('post.show', $post->id) }}"><i class="fa fa-eye" title="View post"></i></a>

                            <a href="{{ route('post.update', $post->id) }}"><i class="fa fa-pencil" title="Edit post"></i></a>

                            <a href="{{ route('confirm-delete/post', $post->id) }}" data-toggle="modal" data-target="#delete_confirm"><i class="fa fa-trash" title="Delete post"></i></a>
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

    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
    </script>
@endsection
