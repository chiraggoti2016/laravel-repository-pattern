<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-start align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Products Details</h6>
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
            url: "/api/project/"+this.$route.params.database_id+"/database-details",
            columns: [
                { label: "Con Name", name: 'con_name'},
                { label: "Product", name: 'product' },
                { label: "Usage", name: 'usage' },
                { label: "Last sample date", name: 'last_sample_date' },
                { label: "First usage date", name: 'first_usage_date' },
                { label: "Last usage date", name: 'last_usage_date' }
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
        //this.$route.params.database_id
    },
    methods: {},
};
</script>