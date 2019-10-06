const store = new Vuex.Store({
    state: {
        head: {
            title: {
                inner: '...',
                separator: '|',
                complement: '...'
            },
            link: [
                {
                    rel: 'icon',
                    href: '',
                    sizes: '16x16',
                    type: ''
                }
            ],
            meta: [
                {
                    name: 'description',
                    content: ''
                }
            ],
            script: [],
            style: []
        }
    },
    getters: {
        getHead(state) {
            return state.head;
        },
        getHeadTitle(state) {
            return state.head.title;
        },
        getHeadDescription(state) {
            return state.head.meta.find((i) => i.name === 'description');
        },
        getHeadFavicon(state) {
            return state.head.link.find((i) => i.rel === 'icon');
        }
    },
    mutations: {
        setHead(state, payload) {
            state.head = payload;
        },
        setHeadTitle(state, payload) {
            if ('inner' in payload) {
                state.head.title.inner = payload.inner;
            }
            if ('separator' in payload) {
                state.head.title.separator = payload.separator;
            }
            if ('complement' in payload) {
                state.head.title.complement = payload.complement;
            }
        },
        setHeadDescription(state, payload) {
            let desc = state.head.meta.find((i) => i.name === 'description');
            desc.content = payload;
        },
        setHeadFavicon(state, payload) {
            let favicon = state.head.link.find((i) => i.rel === 'icon');
            favicon.href = payload.href;
            favicon.type = payload.type;
        }
    },
    actions: {
    }
};
