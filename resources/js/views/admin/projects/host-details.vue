<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-start align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Project Hosts Details</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <data-table :url="url" :columns="columns" :headers="headers"></data-table>
                </div>
            </div>
        </div>

        <b-modal id="modal-prevent-closing" ref="modal" title="Edit Host Details" @show="resetModal" @hidden="resetModal" @ok="handleOk" ok-title="Update" >
            <form ref="form" @submit.stop.prevent="handleAddUserSubmit">
                <b-form-group id="example-modal-input-group-1" label="Cluster-Name" label-for="modal-cluster-input" label-class="require" >
                    <b-form-input id="modal-cluster-input" name="modal-cluster-input" class="mb-2 mr-sm-2 mb-sm-0" placeholder="Cluster Name" aria-describedby="modal-input-1-live-feedback" ></b-form-input>                    
                </b-form-group>
                <b-form-group id="example-modal-input-group-1" label="Server-Identifier" label-for="modal-server-input" label-class="require" >
                    <b-form-input id="modal-server-input" name="modal-server-input" class="mb-2 mr-sm-2 mb-sm-0" placeholder="Server Identifier" aria-describedby="modal-input-1-live-feedback" ></b-form-input>                    
                </b-form-group>
                <b-form-group id="example-modal-input-group-1" label="Environment" label-for="modal-env-input" label-class="require" >
                    <b-form-input id="modal-env-input" name="modal-env-input" class="mb-2 mr-sm-2 mb-sm-0" placeholder="Environment" aria-describedby="modal-input-1-live-feedback" ></b-form-input>                    
                </b-form-group>
            </form>
        </b-modal>
    </div>
</template>

<script>
import { reactive, toRefs } from "vue";
import ViewSlugButton from "./../components/ViewSlugButton.vue";
import ActionButton from "./../components/ActionButton.vue";
import RamDetails from "./../components/RamDetails.vue";
import CpuUtil from "./../components/CpuUtil.vue";
import NoDatabase from "./../components/NoDatabase.vue";
import TotalCores from "./../components/TotalCores.vue";
import ActionModalPopup from './../components/ActionModalPopup.vue';

export default {
    name: "Project",
    data() {
        return {
            url: "/api/project/host-details/"+this.$route.params.slug,
            columns: [
                { label: "Host name", name: 'hostname' },
                { label: "Cluster-Name", name: 'host_details' },
                { label: "Server-Identifier", name: 'server_identifier' },
                { label: "Environment", name: 'environment' },
                { label: "Databases", name: 'databases', component: NoDatabase },
                { label: "Cores", name: 'cores', component: TotalCores },
                { label: "CPU-Util(%)", name: 'cpuutil', component: CpuUtil },
                { label: "RAM(GB)", name: 'ram', component: RamDetails },
                { label: "Storage(GB)", name: 'storage' },
                {
                    label: "Action",
                    name: "Edit",
                    orderable: false,
                    classes: {
                        btn: true,
                        "btn-warning": true,
                        "btn-sm": true,
                    },
                    meta: {
                        prefixLink: "/admin/projects/edit/",
                        icon: {
                            has: true,
                            classes: {
                                "fa-edit": true,
                            },
                        },
                    },
                    event: "click",
                    handler: () => {},
                    component: ActionModalPopup,
                },
            ],
            headers: {
                ...axiosHeaders,
            },
            busy: false,
        };
    },
    components: {
        ActionButton,
        ViewSlugButton,
        RamDetails,
        CpuUtil,
        NoDatabase,
        TotalCores,
        ActionModalPopup
    },
    async mounted() {
        //console.log(this.$route.params);
    },
    methods: {
        resetModal() {
        },
        handleOk(bvModalEvent) {
        }
    },
};
</script>