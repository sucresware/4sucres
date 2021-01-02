@extends('layouts.app')

@section('title')
{{ $thread->title }}
@endsection

@section('content')

@if ($thread->deleted_at)
<div class="shadow" style="margin-top: -25px; margin-bottom: 25px;">
	<div class="container py-2">
		<div class="row no-gutters align-items-center">
			<div class="col-auto mr-2"><i class="fas fa-error-circle"></i></div>
			<div class="col">
				<strong>Erreur 410</strong><br>
				Vous consultez une thread supprimée.
			</div>
		</div>
	</div>
</div>
@endif

<div class="container">

	@if ($thread->id == 2566)
	<div class="embed-responsive embed-responsive-16by9 mb-5">
		<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/bcL4EHUbPHc?autoplay=1" frameborder="0"
			allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</div>
	@endif

	<div class="pb-0">
		{{ $posts->onEachSide(1)->links() }}
	</div>

	<div class="card border-b-0">
		<div class="card-header">
			<div class="row">
				<div class="col">
					{{ $thread->title }}
				</div>
				<div class="col-auto">
					@if (!$thread->private)
					<a class="mr-2 text-muted"
						href="{{ route('threads.boards.index', [$thread->board->id, $thread->board->slug]) }}">{{ $thread->board->name }}</a>
					@if (auth()->check() && $thread->subscribed()->wherePivot('user_id', user()->id)->count())
					<a href="{{ route('threads.unsubscribe', [$thread->id, $thread->slug]) }}" class=""><i
							class="fas fa-star"></i></a>
					@else
					<a href="{{ route('threads.subscribe', [$thread->id, $thread->slug]) }}" class=""><i
							class="far fa-star"></i></a>
					@endif
					@endif
				</div>
			</div>
		</div>
	</div>

	<thread :thread-id="{{ $thread->id }}" :initial-paginator="{{ $posts->toJson() }}"></thread>

	<div class="pb-0">
		{{ $posts->onEachSide(1)->links() }}
	</div>

	@if (!auth()->check())
	<div class="alert alert-secondary text-center">
		<i class="fas fa-lock"></i> Vous devez être connecté pour participer.
		<a href="{{ route('login') }}" class="btn btn-sm btn-secondary ml-1 text-uppercase">se connecter</a>
	</div>
	@elseif ($thread->locked)
	<div class="alert alert-secondary text-center">
		<i class="fas fa-lock"></i> Cette thread est désormais verrouillée.
	</div>
	@elseif (!$thread->locked || (auth()->check() && $thread->locked && user()->can('bypass threads guard')))
	<section class="card thread-response" id="reply">
		<div class="card-body">
			<h2 class="h6">Répondre</h2>
			@include('thread._reply')
		</div>
	</section>
	@endif

</div>

@endsection