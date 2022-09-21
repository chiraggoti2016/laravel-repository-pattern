<template>
	<span>
		<span v-if="database(data) > 0">
			<!--
				# 2 Parameters  
				#1 - Project Slug
				#2 - Host Id 
			-->
			<router-link :to="'/admin/project/'+data.project.slug+'/database-details/'+data.id" target="_blank">{{ database(data) }}</router-link>
		</span>
		<span v-else>{{ database(data) }}</span>
	</span>
</template>
<script>
export default {
	props: {
		data: {}
	},
	methods: {
		database(data) {
			return data.database.length;
		}
	}
};
</script>