<template>
	<div :test="$helpers.foo1()" :test2="bar()"></div>
</template>

<script>
import { bar } from '@/helpers/utils';
</script>