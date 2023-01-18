import helpers from './helpers/global';
Vue.use({
    install() {
        Vue.helpers = helpers;
        Vue.prototype.$helpers = helpers;
    }
});

/* usage inside components: */
this.$helpers.foo()
/* usage anywhere else: */
Vue.helpers.foo()