@extends('layouts.vuetify')

@section('title')
	Settings - {{ $site->name }}
@stop

@section('content')
    <site-settings address="{{ $site->address }}"></site-settings>
@stop

@section('scripts')
	<script type="text/javascript" src="/js/templates/web-apps/elearning/app.js"></script>
	@include($site->theme->location . '.site._includes.layout-script')
@stop