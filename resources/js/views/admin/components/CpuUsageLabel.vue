<template>
	<span>
		<span v-if="data.cpu_usage_file">Yes</span>
		<span v-else>-</span>
	</span>
</template>
<script>
export default {
	props: {
		data: {}
	},
};
</script>