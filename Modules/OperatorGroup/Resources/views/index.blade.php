@extends('operatorgroup::layouts.master')
@section('custom_css')
    <!-- Load custom CSS -->
    <link rel="stylesheet" href="{{ asset('module/css/operatorgroup.css') }}">
@endsection
@section('custom_js')
    <script src="{{ asset('module/js/operatorgroup.js') }}"></script>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{!! $page_title ?? modules()->generate_breadcrumb($mod_alias ?? null) !!}</h3>
            <div class="box-tools pull-right">
                <ul class="list-inline no-margin">
                    @hasAccess($mod_alias,'create')
                    <li>
                        <button class="btn btn-sm btn-default btn-add"><i class="fa fa-plus"></i> Add</button>
                    </li>
                    @endhasAccess()
                    <li>
                        <button data-href="{{ request()->fullUrl() }}" class="btn btn-sm btn-default"><i class="fa fa-refresh"></i></button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-body">
            <div class="loading text-center">
                @include('layouts.loading',['color'=> 'loading-black'])
            </div>
            <div class="table-container">
                <div class="table-action-area clearfix">
                    <div class="table-action" id="table-action-operator-group">
                        <div class="left-action">
                            <ul class="list-inline no-margin">
                                <li>
                                    {!! form_dropdown('length',[10=>10,50=>50,100=>100,1000=>1000],$all_get->length ?? null,"class=\"form-control\"") !!}
                                </li>
                            </ul>
                        </div>
                        <div class="right-action">
                            <ul class="list-inline no-margin">
                                <li>
                                    <input type="text" class="form-control" name="q" value="{{ $all_get->q ?? null }}" placeholder="Search Data">
                                </li>
                                <li>
                                    <button type="button" class="btn btn-default btn-filter"><i class="fa fa-search"></i> Search</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered nowrap table-hover" id="table-operator-group" style="width: 100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Operator Groups</th>
                        <th>Total Operator</th>
                        <th>View</th>
                        <th>Create</th>
                        <th>Update</th>
                        <th>Delete</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
