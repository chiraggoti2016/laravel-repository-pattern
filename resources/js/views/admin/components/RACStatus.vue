<template>
	<span>
		<span v-if="data.rac">Yes</span>
		<span v-else>No</span>
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