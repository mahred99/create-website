@extends('layouts.vuetify')

@section('title')
	Dashboard - Create Website
@stop

@section('content')
	<v-layout row wrap justify-start>
		
	</v-layout>
@stop

@section('scripts')
	<script type="text/javascript" src="/js/templates/web-apps/elearning/app.js"></script>
	@include($site->theme->location . '.site._includes.layout-script')
@stop