<!-- only show one additional class on exact active match -->
<router-link
  v-bind:to="/foo"
  class="module__link"
  exact
  active-class="module__link__link--active"
  exact-active-class="module__link__link--active"
  >{{ items__value.name }}</router-link
>