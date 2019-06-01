@extends('layouts.app')

@section('title')
	{{ $discussion->title }}
@endsection

@section('content')
<div class="container">
	<div class="row mb-3">
		<div class="col">
			<h1>{{ $discussion->title }}</h1>
		</div>
		<div class="col-auto">
			@if (!$discussion->private)
				<a class="mr-2 text-muted" href="{{ route('discussions.categories.index', [$discussion->category->id, $discussion->category->slug]) }}">
					{{ $discussion->category->name }}
				</a>
				@if (auth()->check() && $discussion->subscribed()->wherePivot('user_id', user()->id)->count())
					<a href="{{ route('discussions.unsubscribe', [$discussion->id, $discussion->slug]) }}" class="btn btn-outline-primary">Se désabonner</a>
				@else
					<a href="{{ route('discussions.subscribe', [$discussion->id, $discussion->slug]) }}" class="btn btn-outline-primary">S'abonner</a>
				@endif
			@endif
		</div>
	</div>

	<div class="pb-0">
		{{ $posts->onEachSide(1)->links() }}
	</div>

	<discussion :discussion-id="{{ $discussion->id }}" :initial-paginator="{{ $posts->toJson() }}"></discussion>

	<div class="pb-0">
		{{ $posts->onEachSide(1)->links() }}
	</div>

	@if (!auth()->check())
		<div class="alert alert-secondary text-center">
			<i class="fas fa-lock"></i> Vous devez être connecté pour participer.
			<a href="{{ route('login') }}" class="btn btn-sm btn-secondary ml-1 text-uppercase">se connecter</a>
		</div>
	@elseif ($discussion->locked)
		<div class="alert alert-secondary text-center">
			<i class="fas fa-lock"></i> Cette discussion est désormais verrouillée.
		</div>
	@elseif (!$discussion->locked || (auth()->check() && $discussion->locked && user()->can('bypass discussions guard')))
		<section class="card discussion-response" id="reply">
			<div class="card-body" >
				<h2 class="h6">Répondre</h2>
				@include('discussion._reply')
			</div>
		</section>
	@endif
</div>

@endsection
