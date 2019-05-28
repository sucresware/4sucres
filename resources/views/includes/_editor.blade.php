<div class="modal fade" id="imgur" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><img src="/img/imgur_logo.png" style="height: 30px;">
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="imgur-dom">
                <div id="imgur-progress" class="text-center mb-3"></div>
                <div id="imgur-error" class="text-center text-danger mb-3"></div>
                <div id="imgur-form">
                    <div class="form-group mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="imgur-uploadinput">
                            <label class="custom-file-label" for="customFile" data-browse="Choisir un fichier">Aucun fichier choisi</label>
                        </div>
                    </div>
                    <div class="text-right">
                        <span data-action="imgur-upload" class="btn btn-primary"><i class="fas fa-upload mr-1"></i> Envoyer</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="preview" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Prévisualisation</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="preview-dom">

            </div>
        </div>
    </div>
</div>

{!! BootForm::textarea('body', false, old('body', $value ?? ''), ['style' => 'width: 100%;', 'class' => 'sucresMD-editor']) !!}

<div class="editor-buttons btn-toolbar" data-parent="sucresBB-editor">
    <div class="btn-group mr-2">
        <button type="button" class="btn btn-sm btn-light" data-mdcode="||"><div class="spoiler">Spoiler</div></button>
        <button type="button" class="btn btn-sm btn-light" data-mdcode="%">mDr</button>
        <button type="button" class="btn btn-sm btn-light" data-mdcode="+">░█</button>
        <button type="button" class="btn btn-sm btn-light" data-mdcode="~">ｖａｐｏｒ</button>
    </div>
    <div class="btn-group mr-2">
        <button type="button" class="btn btn-sm btn-light" data-toggle="modal" data-target="#imgur">
            <img src="/img/imgur_logo.png" style="height: 20px;">
        </button>
    </div>
</div>