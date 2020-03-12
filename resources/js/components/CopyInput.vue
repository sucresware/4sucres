<template>
    <div class="form-group row">
        <label :for="name" class="col-12">
            {{ label }}
        </label>
        <div class="col-md-12">
            <div class="input-group">
                <input
                    :type="type"
                    :id="name"
                    :name="name"
                    :value="value"
                    readonly="readonly"
                    class="form-control" />

                <div class="input-group-append">
                    <button
                        class="btn btn-outline-primary"
                        type="button"
                        v-clipboard:copy="value"
                        v-clipboard:success="onCopy"
                        v-clipboard:error="onError">
                        <i class="fas fa-copy mr-1"></i> Copier
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import iziToast from "izitoast";

export default {
    props: ["label", "value", "type", "name"],
    methods: {
        onCopy: function(e) {
            iziToast.success({
                title: "Copié !",
                message: "Copié dans le presse-papiers"
            });
        },
        onError: function(e) {
            iziToast.error({
                title: "Arf, ça marche pas !",
                message: "Impossible de copier (psst, change de navigateur)"
            });
        }
    },

};
</script>
