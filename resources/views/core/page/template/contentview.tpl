<!-- entends your master view: If you have not created master view, first create master view -->
@extends('pages.master') 

@section('styles')
<!-- Add your page style code -->
<!-- If you don't need this section, remove this.. -->
<!-- And if you didn't added this section in your master view, remove this. -->
@endsection

@section('content')
<!-- Add your content code -->
<!-- If you didn't added this section in your master view, remove this. -->
<section class="container">
	<div class="content">
		<h1>{title}</h1>
	</div>
</section>
@stop

@section('scripts')
<!-- Add your page script code-->
<!-- If you don't need this section, remove this. -->
<!-- And if you didn't added this section in your master view, remove this. -->
@endsection