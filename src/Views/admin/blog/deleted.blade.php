@extends('layouts.admin')

{{-- Page title --}}
@section('title')
    Deleted users
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
                <h1 class="page-header">List of deleted users</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <table class="table table-bordered" id="table">
                <thead>
                <tr class="filters">
                    <th>ID</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>User e-mail</th>
                    <th>Created at</th>
                    <th>Deleted at</th>
                    <th>Deleted by</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{!! $user->id !!}</td>
                        <td>{!! $user->first_name !!}</td>
                        <td>{!! $user->last_name !!}</td>
                        <td>{!! $user->email !!}</td>
                        <td>{!! $user->created_at->diffForHumans() !!}</td>
                        <td>{!! $user->deleted_at->diffForHumans() !!}</td>
                        <td>{!! $user->deletedBy()->first_name !!} {!! $user->deletedBy()->last_name !!}</td>
                        <td>
                            <a href="{{ route('restore/user', $user->id) }}"><i class="fa fa-arrow-circle-left"></i></a>
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

    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
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
