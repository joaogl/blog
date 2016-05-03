@extends('layouts.admin')

{{-- Page title --}}
@section('title')
    User details
    @parent
@endsection

{{-- page level styles --}}
@section('header_styles')

    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/user_profile.css') }}" rel="stylesheet" type="text/css"/>

@endsection

{{-- Page content --}}
@section('content')

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">List of users <small>- {{ $user->first_name }} {{ $user->last_name }}</small></h1>
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
                                    <div class="col-md-4" style="text-align:center">
                                        @if($user->pic)
                                            <img src="{!! url('/').'/uploads/users/'.$user->pic !!}" alt="profile pic" class="img-max  img-rounded">
                                        @else
                                            <img src="http://placehold.it/200x200" alt="profile pic" class="img-rounded">
                                        @endif
                                    </div>

                                    <div class="col-md-8">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="users">
                                                    <tr>
                                                        <td>First name</td>
                                                        <td>{{ $user->first_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Last name</td>
                                                        <td>{{ $user->last_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Username</td>
                                                        <td>{{ $user->username }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>User e-mail</td>
                                                        <td>{{ $user->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Birthday</td>
                                                        <td>{{ $user->birthday->format('d-m-Y') }} ({{ $user->birthday->diff(Carbon\Carbon::now())->format('%y years old') }} - {{ Carbon\Carbon::createFromDate(Carbon\Carbon::now()->year, $user->birthday->month, $user->birthday->day)->diff(Carbon\Carbon::now())->format('%m months and %d days until next birthday') }})</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status</td>
                                                        <td>
                                                            @if($user->deleted_at)
                                                                Deleted
                                                            @elseif($user->activated)
                                                                Activated
                                                            @else
                                                                Pending
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Last IP</td>
                                                        <td>
                                                            {!! $user->ip !!}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Created at</td>
                                                        <td>
                                                            {!! $user->created_at->diffForHumans() !!}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Last login</td>
                                                        <td>
                                                            {!! $user->last_login != null ? $user->last_login->diffForHumans() : 'Never' !!}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Description</td>
                                                        <td>
                                                            {!! $user->description !!}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
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

@endsection