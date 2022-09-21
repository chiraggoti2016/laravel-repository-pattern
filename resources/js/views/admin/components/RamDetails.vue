<template>
	<span>
		<span>
			{{ ramdetails(data) }}
		</span>
		
	</span>
</template>
<script>
export default {
	props: {
		data: {}
	},
	methods: {
		ramdetails(data) {
			let memory = data.memory[0].total/1024;
			return parseFloat(memory).toFixed(2);
		}
	}
};
</script>