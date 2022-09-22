<template>
	<span>
		<span v-if="data.tuning">Yes</span>
		<span v-else>Yes</span>
	</span>
</template>
<script>
export default {
	props: {
		data: {}
	},
	methods: {
		// Test
	}
};
</script>