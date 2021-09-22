<template>
    <div id="app">
        <router-view></router-view>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    data() {
        return {};
    },
    computed: {
        ...mapGetters(['getHead'])
    },
    watch: {
        getHead: {
            handler() {
                this.$emit('updateHead');
            },
            deep: true
        }
    },
    head() {
        return this.getHead;
    }
};
</script>