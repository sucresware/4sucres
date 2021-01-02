<template>
  <div>
    <b-button class="btn btn-sm btn-light" v-b-modal.aveshack-uploader>
      AveShack
    </b-button>
    <b-modal id="aveshack-uploader" title="AveShack" hide-footer centered>
      <div v-if="status == 0">
        <div class="mb-3 input-group">
          <input type="file" ref="fileInput" class="form-control" />
          <div class="input-group-append">
            <button @click="upload" class="btn btn-primary"><i class="fas fa-upload"></i></button>
          </div>
        </div>
      </div>
      <div class="mb-3 text-center" v-if="status == 1">
        <i class="mb-2 mr-1 fas fa-sync fa-spin fa-1x"></i>
        {{ progress }}%
      </div>
      <div class="mb-3 text-center text-danger" v-if="status == 2">
        <i class="mr-1 fas fa-exclamation-circle fa-1x"></i> Erreur<br /><br />
        <button @click="reset" class="btn btn-secondary">Réessayer</button>
      </div>
    </b-modal>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: [],
  data() {
    return {
      api: {
        upload: 'https://api.aveshack.com/v1/uploads',
      },
      status: 0,
      error: 0,
      progress: 0,
      file: null,
    };
  },
  methods: {
    upload() {
      let vm = this;
      this.status = 1;
      this.progress = 0;

      let _data = new FormData();
      _data.append('file', this.$refs.fileInput.files[0]);

      axios
        .post(this.api.upload, _data, {
          headers: { 'Content-Type': 'multipart/form-data' },
          onUploadProgress: (progressEvent) => {
            vm.progress = parseInt(Math.round((progressEvent.loaded / progressEvent.total) * 100));
          },
        })
        .then((resp) => {
          let data = resp.data;
          if (data.err == null) {
            vm.$parent.insertText(data.link);
            vm.$bvModal.hide('aveshack-uploader');
            vm.reset();
          } else {
            vm.status = 2;
          }
        })
        .catch((err) => {
          vm.status = 2;
        });
    },
    reset() {
      this.status = 0;
      this.progress = 0;
    },
  },
};
</script>
