<form action="{{ route('discussions.posts.store', [$discussion->id, $discussion->slug]) }}" method="post" data-disable-on-submit>
    @csrf
    @include('includes/_editor', ['name' => 'body'])

    <div class="text-right">
        <button class="btn btn-secondary" data-action="open-preview" data-toggle="modal" data-target="#preview">Vérifier ma connerie</button>
        <button type="submit" class="btn btn-primary">Élever le débat</button>
    </div>
</form>
