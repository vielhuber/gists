<template>
    <div>
        <button v-bind:disabled="isSnapshotFirst" v-on:click="undoSnapshot">&lt;</button> - 
        <button v-bind:disabled="isSnapshotLast" v-on:click="redoSnapshot">&gt;</button>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
export default {
    methods: {
        ...mapActions([
            'undoSnapshot',
            'redonapshot',
        ])
    },
    computed: {
        ...mapGetters([
            'isSnapshotFirst',
            'isSnapshotLast'
        ])
    }
};
</script>