@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            {{--<h3 class="box-title">{!! $page_tittle ?? general()->generate_breadcrumb($mod_alias ?? null) !!}</h3>--}}
            <div class="box-tools pull-right">
                <ul class="list-inline no-margin">
                    <li>
                        <button data-href="{{ request()->fullUrl() }}" class="btn btn-sm btn-default"><i class="fa fa-refresh"></i></button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="box-body">
            <h1>Hello World</h1>
        </div>
    </div>
@endsection
