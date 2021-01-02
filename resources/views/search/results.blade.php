@extends('layouts.app')

@section('title')
Recherche : {{ $query }}
@endsection

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-7 col-xl-8">
			<div class="text-center font-weight-bold text-uppercase">Rechercher les :</div>
			<ul class="nav nav-pills justify-content-center mt-2 mb-3">
				<a href="{{ route('search.query') }}?query={{ $query }}&scope=posts"
					class="mx-2 nav-link {{ (($scope ?? 'posts') == 'posts' ? 'active' : '') }}">Posts</a>
				<a href="{{ route('search.query') }}?query={{ $query }}&scope=threads"
					class="mx-2 nav-link {{ (($scope ?? 'posts') == 'threads' ? 'active' : '') }}">threads</a>
				<a href="{{ route('search.query') }}?query={{ $query }}&scope=users"
					class="mx-2 nav-link {{ (($scope ?? 'posts') == 'users' ? 'active' : '') }}">Membres</a>
			</ul>

			@isset ($posts)
			<div class="card rounded shadow-sm mb-3">
				<div class="card-header">
					{{ $count = $posts->total() }} {{ Str::plural('post', $count) }}
					{{ Str::plural('correspondant', $count) }}
				</div>
				@forelse($posts as $post)
				<blockquote class="threads-search-results bg-theme-primary mx-3 mb-2">
					<div>
						<a href="{{ $post->link }}">
							<i class="fas fa-angle-double-left text-muted"></i>
							{{ $post->thread->title }}
							<i class="fas fa-angle-double-right text-muted"></i>
						</a>
						<br>
						<small class="text-theme-tertiary">{!! $post->trimmed_body !!}</small>
						<hr class="my-2">
						<div class="text-muted">
							<a href="{{ $post->user->link }}"><img src="{{ $post->user->avatar_link }}" class="rounded"
									height="14px"></a>
							<a href="{{ $post->user->link }}"><strong>{{ $post->user->display_name }}</strong></a>
							{{ $post->presented_date }}
						</div>
					</div>
				</blockquote>
				@empty
				<div class="card-body">
					<span class="text-danger">
						Ta recherche n'a donné aucun résultat 😅
					</span>
				</div>
				@endforelse
			</div>
			{!! $posts->appends(request()->input())->onEachSide(1)->links() !!}
			@endisset
			@isset ($threads)
			<div class="card rounded shadow-sm mb-3">
				<div class="card-header">
					{{ $count = $threads->total() }} {{ Str::plural('thread', $count) }}
					{{ Str::plural('correspondante', $count) }}
				</div>
				@forelse($threads as $thread)
				<blockquote class="threads-search-results bg-theme-primary mx-3 mb-2">
					<div>
						<a href="{{ $thread->link }}">
							<i class="fas fa-angle-double-left text-muted"></i>
							{!! $thread->title !!}
							<i class="fas fa-angle-double-right text-muted"></i>
						</a>
						<br>
						<hr class="my-2">
						<div class="text-muted">
							<a href="{{ $thread->user->link }}"><img src="{{ $thread->user->avatar_link }}"
									class="rounded" height="14px"></a>
							<a href="{{ $thread->user->link }}"><strong>{{ $thread->user->display_name }}</strong></a>
							le {{ $thread->created_at->format('d/m/Y à H:i:s') }}
						</div>
					</div>
				</blockquote>
				@empty
				<div class="card-body">
					<span class="text-danger">
						Ta recherche n'a donné aucun résultat 😅
					</span>
				</div>
				@endforelse
			</div>
			{!! $threads->appends(request()->input())->onEachSide(1)->links() !!}
			@endisset
			@isset ($users)
			<div class="card rounded shadow-sm mb-3">
				<div class="card-header">
					{{ $count = $users->total() }} {{ Str::plural('utilisateur', $count) }}
					{{ Str::plural('correspondant', $count) }}
				</div>
				@forelse($users as $user)
				<blockquote class="user-search-results bg-theme-primary mx-3 mb-2">
					<div>
						<div class="row align-items-center">
							<div class="col-auto pr-0">
								<a href="{{ $user->link }}"><img src="{{ $user->avatar_link }}" class="rounded"
										height="32px"></a>
							</div>
							<div class="col">
								<div class="d-flex flex-column">
									<a href="{!! $user->link !!}"><strong>{!! $user->display_name_for_search
											!!}</strong></a>
									<a href="{!! $user->link !!}"><small>{!! '@' . $user->name_for_search
											!!}</small></a>
								</div>
							</div>
						</div>
					</div>
				</blockquote>
				@empty
				<div class="card-body">
					<span class="text-danger">
						Ta recherche n'a donné aucun résultat 😅
					</span>
				</div>
				@endforelse
			</div>
			{!! $users->appends(request()->input())->onEachSide(1)->links() !!}
			@endisset
		</div>
	</div>
</div>
@endsection