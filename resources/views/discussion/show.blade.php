@extends('layouts.app')

@section('title')
	{{ $discussion->title }}
@endsection

@section('content')

@if ($discussion->deleted_at)
<div class="shadow" style="margin-top: -25px; margin-bottom: 25px;">
	<div class="container py-2">
		<div class="row no-gutters align-items-center">
			<div class="col-auto mr-2"><i class="fas fa-error-circle"></i></div>
			<div class="col">
				<strong>Erreur 410</strong><br>
				Vous consultez une discussion supprimée.
			</div>
		</div>
	</div>
</div>
@endif

<div class="container">

	@if ($discussion->id == 2566)
		<div class="embed-responsive embed-responsive-16by9 mb-5">
			<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/bcL4EHUbPHc?autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
	@endif

	<div class="pb-0">
		{{ $posts->onEachSide(1)->links() }}
	</div>

	<div class="card border-b-0">
		<div class="card-header">
			<div class="row">
				<div class="col">
					{{ $discussion->title }}
				</div>
				<div class="col-auto">
					@if (!$discussion->private)
						<a class="mr-2 text-muted" href="{{ route('discussions.categories.index', [$discussion->category->id, $discussion->category->slug]) }}">{{ $discussion->category->name }}</a>
						@if (auth()->check() && $discussion->subscribed()->wherePivot('user_id', user()->id)->count())
							<a href="{{ route('discussions.unsubscribe', [$discussion->id, $discussion->slug]) }}" class=""><i class="fas fa-star"></i></a>
						@else
							<a href="{{ route('discussions.subscribe', [$discussion->id, $discussion->slug]) }}" class=""><i class="far fa-star"></i></a>
						@endif
					@endif
				</div>
			</div>
		</div>
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
