// does not work
<li v-for="item in items"></li>

// always works
<li v-for="(item,i) in items" v-bind:key="i"></li>