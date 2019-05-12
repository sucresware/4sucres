<div class="editor-buttons btn-toolbar" data-parent="sucresBB-editor">
    <div class="btn-group mr-2">
        <button type="button" class="btn btn-sm btn-outline-primary" data-bbcode="b"><i class="fas fa-bold"></i></button>
        <button type="button" class="btn btn-sm btn-outline-primary" data-bbcode="i"><i class="fas fa-italic"></i></button>
        <button type="button" class="btn btn-sm btn-outline-primary" data-bbcode="u"><i class="fas fa-underline"></i></button>
        <button type="button" class="btn btn-sm btn-outline-primary" data-bbcode="s"><i class="fas fa-strikethrough"></i></button>
    </div>
    <div class="btn-group mr-2">
        <button type="button" class="btn btn-sm btn-outline-primary" data-bbcode="url"><i class="fas fa-link"></i></button>
        <button type="button" class="btn btn-sm btn-outline-primary" data-bbcode="img"><i class="fas fa-image"></i></button>
        <button type="button" class="btn btn-sm btn-outline-primary" data-bbcode="youtube"><i class="fab fa-youtube"></i></button>
    </div>
    <div class="btn-group mr-2">
        <button type="button" class="btn btn-sm btn-outline-primary" data-bbcode="spoiler"><div class="spoiler">Spoiler</div></button>
        <button type="button" class="btn btn-sm btn-outline-primary" data-bbcode="mock">mDr</button>
        <button type="button" class="btn btn-sm btn-outline-primary" data-bbcode="glitch">░█</button>
    </div>
    <div class="btn-group mr-2">
        <button type="button" class="btn btn-sm btn-outline-primary" data-action="openRisibank" data-toggle="modal" data-target="#risibank"><img src="/img/risibank_logo.png" style="height: 20px;"></button>
        {{--  <button type="button" class="btn btn-sm btn-outline-primary" data-action="openNoelshack" data-toggle="modal" data-target="#noelshack"><img src="/img/noelshack_logo.png" style="height: 20px;"></button>  --}}
        <button type="button" class="btn btn-sm btn-outline-primary" data-action="openImgur" data-toggle="modal" data-target="#imgur"><img src="/img/imgur_logo.png" style="height: 20px;"></button>
    </div>
</div>

<div class="modal fade" id="risibank" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><img src="/img/risibank_logo.png" style="height: 30px;">
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="risibank" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="risibank-popular-tab" data-toggle="tab" href="#popular" role="tab">Populaires</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="risibank-latest-tab" data-toggle="tab" href="#latest" role="tab">Nouveaux</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="risibank-random-tab" data-toggle="tab" href="#random" role="tab">Random</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="risibank-search-tab" data-toggle="tab" href="#search" role="tab">Recherche</a>
                    </li>
                </ul>
                <div class="tab-content py-3" id="risibank-content">
                    <div class="tab-pane fade show active" id="popular" role="tabpanel">
                        <div id="risibank-popular" class="text-center"></div>
                    </div>
                    <div class="tab-pane fade" id="latest" role="tabpanel">
                        <div id="risibank-latest" class="text-center"></div>
                    </div>
                    <div class="tab-pane fade" id="random" role="tabpanel">
                        <div id="risibank-random" class="text-center"></div>
                    </div>
                    <div class="tab-pane fade" id="search" role="tabpanel">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="risibank-searchfield">
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="risibank-searchaction"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div id="risibank-search" class="text-center"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="noelshack" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><img src="/img/noelshack_logo.png" style="height: 30px;">
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="noelshack-dom">
                <div id="noelshack-progress" class="text-center mb-3"></div>
                <div id="noelshack-error" class="text-center text-danger mb-3"></div>
                <div id="noelshack-form">
                    <div class="input-group mb-3">
                        <input type="file" id="noelshack-uploadinput" class="form-control">
                        <div class="input-group-append">
                            <button type="submit" id="noelshack-uploadaction" class="btn btn-primary"><i class="fas fa-upload"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="imgur" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
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
                    <div class="input-group mb-3">
                        <input type="file" id="imgur-uploadinput" class="form-control">
                        <div class="input-group-append">
                            <button type="submit" id="imgur-uploadaction" class="btn btn-primary"><i class="fas fa-upload"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="preview" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
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

{!! BootForm::textarea('body', false, old('body', $value ?? ''), ['style' => 'width: 100%;', 'class' => 'sucresBB-editor']) !!}