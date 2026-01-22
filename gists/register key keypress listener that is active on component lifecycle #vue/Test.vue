<template>
    <div class="test">
        ...
    </div>
</template>

<script>
export default {
    methods: {
        keypressListener(e) {
            console.log(e.key);
        }
    },
    mounted() {
        document.addEventListener('keypress', this.keypressListener);
    },
    beforeDestroy() {
        document.removeEventListener('keypress', this.keypressListener);
    },
    props: {
        active: Boolean
    }
};
</script>
