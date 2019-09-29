const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/test',
            name: 'test',
            component: Test,
            meta: {
                title: 'Test!'
            }
        }
    ]
});

// set title based on route
router.beforeEach((to, from, next) => {
    if (to.meta.title) {
        store.commit('setHeadTitle', { inner: to.meta.title });
    }
    next();
});