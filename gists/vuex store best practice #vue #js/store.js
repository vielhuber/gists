import Vue from 'vue';
import Vuex from 'vuex';
import dotProp from 'dot-prop';

Vue.use(Vuex);

/* pattern: EVERYTHING is an object (consisting of objects); we do not use arrays anywhere */
/* if we need to sort objects, we use computed properties inside components or getters that convert these objects to arrays */
/* all ids should be pushids (not numeric auto incremented values) so that we can create them on client side */

export default new Vuex.Store({
    state: {
        foo: {
          bar: 'baz'
        }
    },
    getters: {
      	/* getProp('foo.bar.baz'); */
        getProp(state) {
            return (source, alternative = null) => {
                let ret = dotProp.get(state, source);
                if (ret === undefined && alternative !== null) {
                    return alternative;
                }
                return ret;
            };
        },
        /* (faster) alternative */
        getFooBar(state) {
          	if( state.foo && state.foo.bar && state.foo.bar.baz )
            {
            	return state.foo.bar.baz;
            }
          	return undefined;
        },
        toArray() {
            return (obj) => {
                var arr = [];
                for (var prop in obj) {
                    if (obj.hasOwnProperty(prop)) {
                        arr.push(obj[prop]);
                    }
                }
                return arr;
            };
        },
      	getSortedFooBar(state, getters) {
         	return getters.toArray(state.foo.bar);
        }
    },
    mutations: {
        set(state, payload) {
            /* due to
            /* https://vuex.vuejs.org/guide/mutations.html#mutations-follow-vue-s-reactivity-rules
            /* https://vuejs.org/v2/guide/list.html#Caveats,
            /* vue loses reactivity when adding new items
            /* we overcome this by using Vue.set */
            let path = payload.source.split('.'),
                prop = path.splice(-1, 1),
                obj = dotProp.get(state, path.join('.'));
            /* recursively traverse back if nested property should be set */
            while ((obj === undefined || obj === null || typeof obj !== 'object') && path.length > 1) {
                payload.value = { [prop]: payload.value };
                prop = path.splice(-1, 1);
                obj = dotProp.get(state, path.join('.'));
            }
            if (obj !== undefined && obj !== null && typeof obj === 'object') {
                Vue.set(obj, prop, payload.value);
            }
        },
        remove(state, payload) {
            let path = payload.source.split('.'),
                prop = path.splice(-1, 1),
                obj = dotProp.get(state, path.join('.'));
            if (obj !== undefined && obj !== null && typeof obj === 'object') {
                Vue.delete(obj, prop);
            }
        },
    },
  	/* all actions return promises! */
  	actions: {
      		/* setProp({ source: 'foo.bar', value: 'baz' }); */
      		async setProp(context, payload) {
                context.commit('set', { source: payload.source, value: payload.value });
            },
      		/* addProp({ source: 'foo.bar', value: 'baz' }); */
            async addProp(context, payload) {
                let key = 0;
                if (typeof payload.value === 'object' && 'id' in payload.value) {
                    key = payload.value.id;
                } else {
                    let obj = context.getters.getProp(payload.source);
                    if (obj !== undefined) {
                        while (obj[key] !== undefined) {
                            key++;
                        }
                    }
                }
                payload.source += '.' + key;
                context.commit('set', { source: payload.source, value: payload.value });
            },
      		/* removeProp({ source: 'foo.bar' }); */
            async removeProp(context, payload) {
                context.commit('remove', { source: payload.source });
            },
            async foo(context, payload)
            {
                try {
                  	await test();
                  	return 'message'; // optional
                }
                catch
                {
                    return Promise.reject('general error'); // mandatory
                }
            }
    }
});