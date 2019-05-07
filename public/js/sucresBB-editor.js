sceditor.create(textarea, {
    format: 'bbcode',
    plugins: 'undo',
    startInSourceMode: true,
    emoticonsEnabled: false,
    resizeEnabled: false,
    width: '100%',
    style: "{{ url('/css/sceditor.content.css') }}",
    toolbar: 'bold,italic,underline,strike|bulletlist,orderedlist,quote,code|image,link,unlink|maximize',
});