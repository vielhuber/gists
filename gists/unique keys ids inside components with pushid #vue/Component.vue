<template>
        <ul>
            <li
                v-for="(options__value, options__key) in options"
                v-bind:key="id + '_' + options__key"
            >
                <input type="radio" :id="id + '_' + options__key" />
                <label :for="id + '_' + options__key">{{ options__value }}</label>
            </li>
        </ul>
</template>

<script>
import pushid from 'pushid';
export default {
    data() {
        return {
            id: pushid()
        };
    }
};
</script>