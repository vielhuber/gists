import cloneDeep from 'clone-deep';
import diff from 'deep-diff';

export const Snapshot = {
    /* this has to be outside of the state, cause otherwise it would extremely slow down the performance */
    states: [],
    limit: 20,
    module: {
        state: {
            meta: {
                cur: -1,
                size: 0,
                changing: false
            }
        },
        mutations: {
            setSnapshotMeta(state, payload) {
                state.meta = payload;
            },
            setSnapshotMetaCur(state, payload) {
                state.meta.cur = payload;
            },
            setSnapshotMetaSize(state, payload) {
                state.meta.size = payload;
            },
            setSnapshotMetaChanging(state, payload) {
                state.meta.changing = payload;
            }
        },
        getters: {
            getSnapshotMeta(state) {
                if (state.meta) {
                    return state.meta;
                }
                return {};
            },
            getSnapshotMetaCur(state) {
                if (state.meta) {
                    return parseInt(state.meta.cur);
                }
                return -1;
            },
            getSnapshotMetaSize(state) {
                if (state.meta) {
                    return parseInt(state.meta.size);
                }
                return 0;
            },
            getSnapshotMetaChanging(state) {
                if (state.meta) {
                    return state.meta.changing;
                }
                return 0;
            },
            isSnapshotFirst(state) {
                if (state.meta) {
                    return parseInt(state.meta.cur) <= 0;
                }
                return false;
            },
            isSnapshotLast(state) {
                if (state.meta) {
                    return parseInt(state.meta.cur) >= parseInt(state.meta.size) - 1;
                }
                return false;
            }
        },
        actions: {
            async createSnapshot(context) {
                // prevent taking obsolete snapshots
                let compare1 = cloneDeep(context.rootState);
                let compare2 = cloneDeep(Snapshot.states[context.getters.getSnapshotMetaCur]);
                if (compare1 !== undefined && compare2 !== undefined) {
                    compare1.route = compare2.route = compare1.Snapshot = compare2.Snapshot = null;
                    if (diff(compare1, compare2) === undefined) {
                        return;
                    }
                }
                // if one is not at head, set new head
                if (context.getters.getSnapshotMetaCur < context.getters.getSnapshotMetaSize - 1) {
                    context.commit('setSnapshotMetaSize', context.getters.getSnapshotMetaCur + 1);
                    Snapshot.states.splice(context.getters.getSnapshotMetaCur + 1);
                }
                // limit
                if (context.getters.getSnapshotMetaSize >= Snapshot.limit) {
                    context.commit('setSnapshotMetaCur', Snapshot.limit - 2);
                    context.commit('setSnapshotMetaSize', Snapshot.limit - 1);
                    Snapshot.states.shift();
                }
                Snapshot.states.push(cloneDeep(context.rootState));
                context.commit('setSnapshotMetaCur', context.getters.getSnapshotMetaCur + 1);
                context.commit('setSnapshotMetaSize', context.getters.getSnapshotMetaSize + 1);
            },
            async undoSnapshot(context) {
                await context.dispatch('setSnapshot', context.getters.getSnapshotMetaCur - 1);
            },
            async redoSnapshot(context) {
                await context.dispatch('setSnapshot', context.getters.getSnapshotMetaCur + 1);
            },
            async setSnapshot(context, payload) {
                context.commit('setSnapshotMetaCur', payload);
                let snapshot = Snapshot.states[context.getters.getSnapshotMetaCur];
                snapshot.Snapshot = cloneDeep(context.state); // exclude statesnapshot itself
                context.commit('setSnapshotMetaChanging', true);
                this.replaceState(cloneDeep(snapshot));
                context.commit('setSnapshotMetaChanging', false);
            },
            async resetToLastSnapshotWithoutMissingFieldsInCurrentRoute(context) {
                let index = context.getters.getSnapshotMetaSize - 1,
                    route = context.getters.getCurrentRouteFullPath,
                    found = false;
                while (index >= 0) {
                    let snapshot = Snapshot.states[index];
                    if (Object.keys(snapshot.session.missingFields).find((i) => snapshot.session.missingFields[i].route === route) === undefined) {
                        found = true;
                        break;
                    }
                    index--;
                }
                if (found === false) {
                    return;
                }
                context.commit('setSnapshotMetaSize', index + 1);
                Snapshot.states.splice(index + 1);
                // special case: if target route is DEEPER than current route, set to current route
                if (
                    Snapshot.states[index].route.path === context.getters.getCurrentRoutePath &&
                    Object.keys(Snapshot.states[index].route.query).length > Object.keys(context.getters.getCurrentRouteQuery).length
                ) {
                    Snapshot.states[index].route = cloneDeep(context.getters.getCurrentRoute);
                }
                await context.dispatch('setSnapshot', index);
            }
        }
    }
};
