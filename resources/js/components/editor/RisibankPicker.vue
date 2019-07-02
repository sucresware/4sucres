<template>
  <div>
    <b-button class="btn btn-sm btn-light" v-b-modal.risibank-picker>
      <img src="/img/editor/risibank_logo.png" style="height: 20px;" />
    </b-button>
    <b-modal id="risibank-picker" title="RisiBank" hide-footer centered>
      <div>
        <b-tabs content-class="mt-3" fill>
          <b-tab>
            <template slot="title">
              <i class="fas fa-search"></i>
            </template>
            <div class="input-group mb-3">
              <input
                type="text"
                v-model="searchField"
                class="form-control"
                v-on:keyup.enter="search()"
              />
              <div class="input-group-append">
                <button class="btn btn-primary" v-on:click="search()">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>

            <div v-show="searchLoading == 1" class="my-5 text-center">
              <i class="fas fa-sync fa-spin fa-1x"></i>
            </div>
            <div v-show="searchLoading == -1" class="my-5 text-center">
              <i class="fas fa-exclamation-circle text-danger fa-1x"></i>
            </div>
            <div v-show="searchLoading == 0" class="row align-items-center justify-content-center">
              <div v-for="sticker in searchResults" v-bind:key="sticker.id">
                <span class="pointer" v-on:click="pick(sticker.risibank_link)">
                  <img :src="sticker.risibank_link" class="img-thumbnail sticker" />
                </span>
              </div>
            </div>
          </b-tab>
          <b-tab title="🌶 Hot" active>
            <div v-show="loading == 1" class="my-5 text-center">
              <i class="fas fa-sync fa-spin fa-1x"></i>
            </div>
            <div v-show="loading == -1" class="my-5 text-center">
              <i class="fas fa-exclamation-circle text-danger fa-1x"></i>
            </div>
            <div v-show="loading == 0" class="row align-items-center justify-content-center">
              <div v-for="sticker in stickers.trending" v-bind:key="sticker.id">
                <span class="pointer" v-on:click="pick(sticker.risibank_link)">
                  <img :src="sticker.risibank_link" class="img-thumbnail sticker" />
                </span>
              </div>
            </div>
          </b-tab>
          <b-tab title="Récent">
            <div v-show="loading == 1" class="my-5 text-center">
              <i class="fas fa-sync fa-spin fa-1x"></i>
            </div>
            <div v-show="loading == -1" class="my-5 text-center">
              <i class="fas fa-exclamation-circle text-danger fa-1x"></i>
            </div>
            <div v-show="loading == 0" class="row align-items-center justify-content-center">
              <div v-for="sticker in stickers.tms" v-bind:key="sticker.id">
                <span class="pointer" v-on:click="pick(sticker.risibank_link)">
                  <img :src="sticker.risibank_link" class="img-thumbnail sticker" />
                </span>
              </div>
            </div>
          </b-tab>
          <b-tab title="Hasard">
            <div v-show="loading == 1" class="my-5 text-center">
              <i class="fas fa-sync fa-spin fa-1x"></i>
            </div>
            <div v-show="loading == -1" class="my-5 text-center">
              <i class="fas fa-exclamation-circle text-danger fa-1x"></i>
            </div>
            <div v-show="loading == 0" class="row align-items-center justify-content-center">
              <div v-for="sticker in stickers.random" v-bind:key="sticker.id">
                <span class="pointer" v-on:click="pick(sticker.risibank_link)">
                  <img :src="sticker.risibank_link" class="img-thumbnail sticker" />
                </span>
              </div>
            </div>
          </b-tab>
          <b-tab title="Populaire">
            <div v-show="loading == 1" class="my-5 text-center">
              <i class="fas fa-sync fa-spin fa-1x"></i>
            </div>
            <div v-show="loading == -1" class="my-5 text-center">
              <i class="fas fa-exclamation-circle text-danger fa-1x"></i>
            </div>
            <div v-show="loading == 0" class="row align-items-center justify-content-center">
              <div v-for="sticker in stickers.views" v-bind:key="sticker.id">
                <span class="pointer" v-on:click="pick(sticker.risibank_link)">
                  <img :src="sticker.risibank_link" class="img-thumbnail sticker" />
                </span>
              </div>
            </div>
          </b-tab>
        </b-tabs>
      </div>
    </b-modal>
  </div>
</template>

<script>
import axios from "axios";

export default {
  props: [],
  data() {
    return {
      api: {
        load: "https://api.risibank.fr/api/v0/load",
        search: "https://api.risibank.fr/api/v0/search?search=%query%"
      },
      loading: 0,
      searchLoading: 0,
      stickers: [],
      searchResults: [],
      searchField: ""
    };
  },
  methods: {
    refresh() {
      let vm = this;

      this.loading = 1;
      axios
        .get("https://cors-anywhere.herokuapp.com/" + vm.api.load)
        .then(resp => {
          vm.stickers = resp.data.stickers;
          vm.loading = 0;
        })
        .catch(() => {
          vm.loading = -1;
        });
    },
    search() {
      let vm = this;
      let _url = this.api.search.replace(/(%query%)/g, this.searchField);

      this.searchLoading = 1;
      axios
        .post("https://cors-anywhere.herokuapp.com/" + _url)
        .then(resp => {
          vm.searchResults = resp.data.stickers;
          vm.searchLoading = 0;
        })
        .catch(() => {
          vm.searchLoading = -1;
        });
    },
    pick(link) {
      this.$parent.insertText(link);
      this.$bvModal.hide("risibank-picker");
    }
  },
  mounted() {
    let vm = this;
    this.$root.$on("bv::modal::show", (bvEvent, modalId) => {
      if (modalId == "risibank-picker") {
        vm.refresh();
      }
    });
  }
};
</script>