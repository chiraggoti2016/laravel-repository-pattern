<template>
	<span>
		<span>{{ totalCores(data) }}</span>
	</span>
</template>
<script>
export default {
	props: {
		data: {}
	},
	methods: {
		totalCores(data) {
			return data.details.cores_per_socket * data.details.sockets;
		}
	}
};
</script>