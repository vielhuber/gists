<template>
    <div>
        <app-child v-bind="$props"></app-child>
    </div>
</template>

<script>
import Child from '@/components/configurator/fields/Child.vue';

export default {
    components: {
        'app-child': Child
    },
    props: {
        prop1: String,
        prop2: String,
      	prop3: String,
    }
};
</script>
