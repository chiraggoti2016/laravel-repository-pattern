<template>
	<span>
		<span v-if="data.usage_database && data.usage_database.length > 0">
			{{ cpuUtil(data) }}
		</span>
	</span>
</template>
<script>
export default {
	props: {
		data: {}
	},
	methods: {
		cpuUtil(data) {
			let count = data.usage_database.length;
			let total = 0;
			let avg = 0;

			data.usage_database.forEach(element => {
				total += parseFloat(element.idle);
			});
			
			if(total > 0) {
				avg = 100 - (total/count);
			}
			return parseFloat(avg).toFixed(2);
		}
	}
};
</script>