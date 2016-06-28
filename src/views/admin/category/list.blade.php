@extends('layouts.admin')

{{-- Page title --}}
@section('title')
    Categories
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
                    List of categories

                    <div style="float: right;">
                        <a href="{{ route('create.category') }}">
                            {!! Form::submit('Create new category', ['class' => 'btn btn-primary form-control']) !!}
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
                    <th>Name</th>
                    <th>Posts</th>
                    <th>Created at</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cats as $cat)
                    <tr>
                        <td>{!! $cat->id !!}</td>
                        <td>{!! $cat->name !!}</td>
                        <td>{!! sizeof($cat->posts) !!}</td>
                        <td>{!! $cat->created_at->diffForHumans() !!}</td>
                        <td>
                            <a href="{{ route('category.show', $cat->id) }}"><i class="fa fa-eye" title="View category"></i></a>

                            <a href="{{ route('category.update', $cat->id) }}"><i class="fa fa-pencil" title="Edit category"></i></a>

                            <a href="{{ route('confirm-delete/category', $cat->id) }}" data-toggle="modal" data-target="#delete_confirm"><i class="fa fa-trash" title="Delete category"></i></a>
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

    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="category_delete_confirm_title" aria-hidden="true">
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
