<template>
	<span>
		<span v-if="data.options_packs_file">Yes</span>
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