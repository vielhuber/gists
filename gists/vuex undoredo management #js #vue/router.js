/* ... */

// take snapshots on every route change
router.beforeEach((to, from, next) => {
    if (
        to.meta.snapshot === true && // only take snapshots on predefined routes
        Object.keys(store.state.local).length > 0 && // only take snapshots if store is filled
        store.getters.getSnapshotMetaChanging === false // prevent taking snapshots on undo/redo
    ) {
        store.dispatch('createSnapshot').then(() => {
            next();
        });
    } else {
        next();
    }
});

export default router;