<div class="modal fade" id="preview" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Prévisualisation</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="preview-dom"></div>
        </div>
    </div>
</div>

<sucres-editor value="{{ $value ?? '' }}"></sucres-editor>

@if ($errors->has('body'))
    <small class="text-danger">{{ $errors->first('body') }}</small>
@endif