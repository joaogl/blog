@extends('layouts.admin')

{{-- Page title --}}
@section('title')
    Deleted categories
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
                <h1 class="page-header">List of deleted categories</h1>
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
                    <th>Slug</th>
                    <th>Created at</th>
                    <th>Deleted at</th>
                    <th>Deleted by</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cats as $cat)
                    <tr>
                        <td>{!! $cat->id !!}</td>
                        <td>{!! $cat->name !!}</td>
                        <td>{!! $cat->slug !!}</td>
                        <td>{!! $cat->created_at->diffForHumans() !!}</td>
                        <td>{!! $cat->deleted_at->diffForHumans() !!}</td>
                        <td>{!! $cat->deletedBy()->first_name !!} {!! $cat->deletedBy()->last_name !!}</td>
                        <td>
                            <a href="{{ route('restore/category', $cat->id) }}"><i class="fa fa-arrow-circle-left"></i></a>
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
