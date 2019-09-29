<template>
    <div class="component">
        <app-other-component></app-other-component>
        <ul>
            <li v-for="ninja in ninjas">{{ ninja }}</li>
        </ul>
    </div>
</template>

<script>
    import OtherComponent from './OtherComponent.vue';
    import hlp from 'hlp';
    
    export default {
        data() {
            return {
                ninjas: ['Yoshi','Mario','Ryu']
            }
        },
        components: {
            'app-other-component': OtherComponent
        },
        methods: {
          foo() {

          }
        },
        computed: {
          foo() {
              return 'this is es6 syntax';
          }
        },
        created() {

        },
        props: {}
    }
</script>

<style scoped>
    ul {
        background-color:red;
    }
</style>