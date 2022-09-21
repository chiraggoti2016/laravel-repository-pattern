<template>
	<span>
		<span v-if="data.options_packs_database_detail">
			<router-link :to="'/admin/project/'+data.id+'/database-details'" target="_blank">{{ data.db_name }}</router-link>
		</span>
		<span v-else>{{ data.db_name }}</span>
	</span>
</template>
<script>
export default {
	props: {
		data: {}
	},
	methods: {
		//
	}
};
</script>