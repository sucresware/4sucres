@push('css')
    <link rel="stylesheet" href="{{ url('/css/sceditor.css') }}">
@endpush

<form action="{{ route('discussions.posts.store', [$discussion->id, $discussion->slug]) }}" method="post">
    @csrf
    {!! GoogleReCaptchaV3::renderField('reply_to_discussion_id', 'reply_to_discussion_action') !!}
    @include('includes/_editor', ['name' => 'body'])

    <div class="text-right">
        <button type="submit" class="btn btn-primary">Élever le débat</button>
    </div>
</form>
