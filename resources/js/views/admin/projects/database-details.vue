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
import CBDStatus from "./../components/CBDStatus.vue";
import PBDStatus from "./../components/PBDStatus.vue";
import RACStatus from "./../components/RACStatus.vue";
import PartioningStatus from "./../components/PartioningStatus.vue";
import DiagonosticsStatus from "./../components/DiagonosticsStatus.vue";
import TuningStatus from "./../components/TuningStatus.vue";

export default {
    name: "Project",
    data() {
        return {
            url: "/api/project/"+this.$route.params.slug+"/database-details/"+this.$route.params.host_id,
            columns: [
                { label: "Instance Name", name: 'db_name' },
                { label: "DB-Name", name: 'database_name', component: DbLink },
                { label: "Version", name: 'version' },
                { label: "Edition", name: 'banner' },
                { label: "Role", name: 'db_role' },
                { label: "CBD", name: 'cbdpbd', component: CBDStatus },
                { label: "PBD", name: 'cbdpbd', component: PBDStatus },
                { label: "RAC", name: 'rac', component: RACStatus },
                { label: "Partioning", name: 'partioning', component: PartioningStatus },
                { label: "Diagonostics", name: 'diagnostics', component: DiagonosticsStatus },
                { label: "Tuning", name: 'tuning', component: TuningStatus },
            ],
            headers: {
                ...axiosHeaders,
            },
            busy: false,
        };
    },
    components: {
        DbLink,
        CBDStatus, 
        PBDStatus,
        RACStatus,
        PartioningStatus,
        DiagonosticsStatus,
        TuningStatus
    },
    async mounted() {
        //console.log(this.$route.params);
    },
    methods: {},
};
</script>