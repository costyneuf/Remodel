@extends('main')

@section('title', '| Create Schedule')

@section('content')

	<?php $schedule_files = scandir('../resources/data'); ?>
	<?php $schedules = [] ?> 
	@foreach ($schedule_files as $file)
		@if(is_file('../resources/data/' . $file))
			<?php $schedules[$file] = $file; ?>
		@endif
	@endforeach

	<div class='row'>
		<div class='col-md-8 offset-md-2'>

			<h3>Choose a file to turn into a schedule: </h3>

			{!! Form::open(array('route' => 'procedure.store')) !!}

				{{ Form::select('file', $schedules, null, array('class' => 'form-control')) }}
				{{ Form::submit('Create Schedule', array('class' => 'btn btn-success btn-sm btn-block', 'style' => 'margin-top:20px'))}}

			{!! Form::close() !!}
		</div>
	</div>
@endsection