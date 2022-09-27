<template>
	<span>
		<span v-if="data.cbdpbd">Yes</span>
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