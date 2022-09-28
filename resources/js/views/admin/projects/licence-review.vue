<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-start align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">License in Use</h6>
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
export default {
    name: "Project",
    data() {
        return {
            url: "/api/project/hosts/"+this.$route.params.slug,
            columns: [
                { label: "Index", name: "index" },
                { label: "Products", name: 'products' },
                { label: "Server/Host", name: "server_host" },
                { label: "Cluster Name", name: "cluster_name" },
                { label: "Server Identifier", name: "server_identifier" },
                { label: "Environment", name: "environment" },
                { label: "Databases", name: "databases" },
                { label: "Total Cores", name: "total_cores" },
                { label: "Licensible Cores", name: "licensible_cores" },
            ],
            headers: {
                ...axiosHeaders,
            },
            busy: false,
        };
    },
    components: {
        //
    },
    async mounted() {
        //console.log(this.$route.params);
    },
    methods: {},
};
</script>