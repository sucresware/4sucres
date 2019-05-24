import $ from 'jquery';
import Editor from './editor';

const DefaultOptions = {
    api: {
        upload: '/api/v0/imgur-gateway/upload',
    },
    selectors: {
        modal: '#imgur',
        form: '#imgur-form',
        upload: '#imgur-upload',
        uploadInput: '#imgur-uploadinput',
        progress: '#imgur-progress',
        error: '#imgur-error'
    },
    modalSelector: '#imgur',
    errorTemplate: '<i class="fas fa-exclamation-circle fa-1x mr-1"></i>',
    progressTemplate: '<i class="fas fa-sync fa-spin fa-1x mr-1 mb-2"></i>',
    outputTemplate: '![](%link%)'
};

class ImgurWrapper {

    constructor(options) {
        this.options = {
            ...DefaultOptions,
            ...options
        };
    }

    upload() {
        this.clearError()
        this.setProgress(0)

        let _data = new FormData();
        _data.append('file', $(this.options.selectors.uploadInput)[0].files[0])

        $.ajax({
            type: 'POST',
            url: this.options.api.upload,
            cache: false,
            contentType: false,
            processData: false,
            data: _data,
            xhr: () => {
                var xhr = new XMLHttpRequest();

                xhr.upload.addEventListener("progress", (event) => {
                    if (event.lengthComputable) {
                        this.setProgress(Math.round((event.loaded / event.total) * 100))
                    }
                }, false);

                return xhr
            },
            success: (resp) => {
                if (resp.success) {
                    Editor.insert(this.options.outputTemplate.replace(/(%link%)/g, resp.file.link));
                    this.setForm()
                    this.close();
                } else {
                    this.setError(resp.error)
                    this.setForm()
                }
            },
            error: (e) => {
                this.setError(e.responseJSON.errors.file[0])
                this.setForm()
            },
        })
    }

    close() {
        $(this.options.selectors.modal).modal('hide');
    }

    setForm() {
        this.hideAll()
        $(this.options.selectors.form).show()
        $(this.options.selectors.upload).show()
        $(this.options.selectors.uploadInput).val('')
    }

    setProgress(progress) {
        this.hideAll()
        $(this.options.selectors.progress).show()
        $(this.options.selectors.progress).html(`${this.options.progressTemplate} ${progress}% <br />`)
    }

    setError(error) {
        $(this.options.selectors.error).show()
        $(this.options.selectors.error).html(`${this.options.errorTemplate} ${error}`)
    }

    clearError() {
        $(this.options.selectors.error).hide()
        $(this.options.selectors.error).empty()
    }

    hideAll() {
        $(this.options.selectors.progress).hide()
        $(this.options.selectors.form).hide()
    }
}

const Imgur = new ImgurWrapper(DefaultOptions);
export default Imgur;
export {
    Imgur
};
