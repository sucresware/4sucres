<template>
    <div class="flex items-center justify-between">
        <template v-if="paginator.current_page > 1">
            <t-button @click="visit(paginator.prev_page_url)" type="secondary"><i class="fas fa-angle-left"></i></t-button>
        </template>
        <template v-else>
            <t-button disabled type="secondary"><i class="fas fa-angle-left"></i></t-button>
        </template>
        <span class="mx-2 text-muted">
            {{ paginator.current_page }} / {{ paginator.last_page }}
        </span>
        <template v-if="paginator.current_page < paginator.last_page">
            <t-button @click="visit(paginator.next_page_url)" type="secondary"><i class="fas fa-angle-right"></i></t-button>
        </template>
        <template v-else>
            <t-button disabled type="secondary"><i class="fas fa-angle-right"></i></t-button>
        </template>
    </div>
</template>

<script>
export default {
    props: ["paginator", "only"],

    methods: {
        visit(url) {
            if (this.only) {
                let queryString = url.replace(this.paginator.path, '');
                let currentUrl = window.location.href.split('?')[0];
                return this.$inertia.visit(currentUrl + queryString, { only: this.only })
            }

            return this.$inertia.visit(url)
        }
    }
};
</script>