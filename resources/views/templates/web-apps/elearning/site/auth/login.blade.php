@extends($site->theme->location.'.layouts.site')

@section('content')
    <site-login address="{{ $site->address }}"></site-login>
@stop