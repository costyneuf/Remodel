@extends('main')

@section('title', '| Procedure ' . $procedure->id)

@section('content')
	<p>This is it, kid. We finally almost are about to just barely in a bit begin our journey, maybe. </p>
	{{ $procedure }}
@endsection