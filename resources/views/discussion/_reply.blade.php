@push('css')
    <link rel="stylesheet" href="{{ url('/css/sceditor.css') }}">
@endpush

    <form action="{{ route('discussions.posts.store', [$discussion->id, $discussion->slug]) }}" method="post">
        @csrf
        {!! GoogleReCaptchaV3::renderField('reply_to_discussion_id', 'reply_to_discussion_action') !!}
        {!! BootForm::textarea('reply', 'Message', old('reply'), ['class' => 'form-control', 'style' => 'width: 100%;']) !!}

        <div class="text-right">
            <button type="submit" class="btn btn-primary">Élever le débat</button>
        </div>
    </form>

@push('js')
    <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/sceditor/2.1.2/sceditor.min.js') }}"></script>
    <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/sceditor/2.1.2/formats/bbcode.js') }}"></script>
    <script>
        var textarea = document.getElementById('reply');
    </script>
    <script src="{{ url('/js/sucresBB-editor.js') }}"></script>
@endpush