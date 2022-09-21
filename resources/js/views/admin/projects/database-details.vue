<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-start align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Host Database Details</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <data-table :url="url" :columns="columns" :headers="headers"></data-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, toRefs } from "vue";
import DbLink from "./../components/DbLink.vue";

export default {
    name: "Project",
    data() {
        return {
            url: "/api/project/"+this.$route.params.slug+"/database-details/"+this.$route.params.host_id,
            columns: [
                { label: "DB-Name", name: 'db_name', component: DbLink },
                { label: "Version", name: 'version' },
                { label: "Edition", name: 'banner' },
                { label: "Role", name: 'db_role' },
                { label: "CBD", name: 'cbdpbd' },
                { label: "PBD", name: 'cbdpbd' },
                { label: "RAC", name: 'rac' },
                { label: "Partioning", name: 'partioning' },
                { label: "Diagonostics", name: 'diagnostics' },
                { label: "Tuning", name: 'tuning' },
            ],
            headers: {
                ...axiosHeaders,
            },
            busy: false,
        };
    },
    components: {
        DbLink
    },
    async mounted() {
        //console.log(this.$route.params);
    },
    methods: {},
};
</script>