@extends('modules::layouts.master')
@section('custom_css')
    <!-- Load custom CSS -->
    <link rel="stylesheet" href="{{ asset('module/css/modules.css') }}">
@endsection
@section('custom_js')
    <!-- Load custom JS -->
    <script src="{{ asset('module/js/modules.js') }}"></script>
@endsection
@section('content')
    <div class="box modules">
        <div class="box-header with-border">
            <h3 class="box-title">{!! $page_tittle ?? modules()->generate_breadcrumb($mod_alias ?? null) !!}</h3>
            <div class="box-tools pull-right">
                <ul class="list-inline no-margin">
                    @hasAccess($mod_alias,'read')
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
        <div class="box-body">
            @if(isset($modules))
                <div class="list-group nested-sortable">
                    @foreach($modules as $value)
                        <div class="parent" data-id="{{ $value->modid }}">
                            <div class="list-group-item parent-{{ $value->modid }} {{ $value->published == 'n' ? 'disable' : ''}}" data-id="{{ $value->modid }}">
                                <div class="list-title">
                                    <i class="{{ $value->mod_icon }}"></i> {{ $value->mod_name }}
                                </div>
                                <div class="list-tools pull-right">
                                    <ul class="list-inline no-margin">
                                        @hasAccess($mod_alias,'update')
                                        <li>
                                            <button class="btn btn-sm btn-default btn-publish" data-id="{{ $value->modid }}" data-published="{{ $value->published }}">
                                                <i class="fa {{ $value->published == 'y' ? 'fa-eye' : 'fa-eye-slash'}}"></i>
                                            </button>
                                        </li>
                                        <li>
                                            <button class="btn btn-sm btn-default btn-edit" data-id="{{ $value->modid }}"><i class="fa fa-pencil"></i></button>
                                        </li>
                                        @endhasAccess()
                                    </ul>
                                </div>
                            </div>
                            @if(count($value->detail)>0)
                                <div class="list-group nested-sortable nested" data-parent="{{ $value->modid }}">
                                    @foreach($value->detail as $detail)
                                        <div class="list-group-item child child-{{ $detail->modid }}  {{ $detail->published == 'n' ? 'disable' : ''}}" data-id="{{ $detail->modid }}">
                                            <div class="list-title">
                                                <i class="fa fa-circle-o"></i> {{ $detail->mod_name }}
                                            </div>
                                            <div class="list-tools pull-right">
                                                <ul class="list-inline no-margin">
                                                    @hasAccess($mod_alias,'update')
                                                    <li>
                                                        <button class="btn btn-sm btn-default btn-publish" data-id="{{ $detail->modid }}" data-published="{{ $detail->published }}">
                                                            <i class="fa {{ $detail->published == 'y' ? 'fa-eye' : 'fa-eye-slash'}}"></i>
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="btn btn-sm btn-default btn-edit" data-id="{{ $detail->modid }}"><i class="fa fa-pencil"></i></button>
                                                    </li>
                                                    @endhasAccess()
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
