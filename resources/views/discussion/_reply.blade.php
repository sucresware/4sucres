<form data-js-submit data-url="threads/{{ $thread->id }}/posts" method="post">
    @csrf
    @include('includes/_editor', ['name' => 'body'])

    <div class="text-right">
        <button class="btn btn-secondary" data-action="open-preview" data-toggle="modal" data-target="#preview">Vérifier
            ma connerie</button>
        <button type="submit" class="btn btn-primary">Élever le débat</button>
    </div>
</form>