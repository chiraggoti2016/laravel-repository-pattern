<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-start align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Server/Host Details</h6>
                    </div>
                    <div class="col-md-6 float-right d-flex justify-content-end">
                        <router-link class="btn btn-sm btn-primary btn-icon-split" target="_blank" :to="'/admin/project/cpu-count/'+this.$route.params.slug" >
                            <span class="icon text-white-50" ><i class="fas fa-plus"></i></span>
                            <span class="text">Upload CPU Counts</span>
                        </router-link>
                        &nbsp;
                        <router-link class="btn btn-sm btn-primary btn-icon-split" target="_blank" :to="'/admin/project/options-packs/'+this.$route.params.slug" >
                            <span class="icon text-white-50" ><i class="fas fa-plus"></i ></span>
                            <span class="text">Upload Options Packs</span>
                        </router-link>
                        &nbsp;
                        <router-link class="btn btn-sm btn-primary btn-icon-split" target="_blank" :to="'/admin/project/cpu-usage/'+this.$route.params.slug" >
                            <span class="icon text-white-50" ><i class="fas fa-plus"></i></span>
                            <span class="text">Upload CPU Usage</span>
                        </router-link>
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
import ViewSlugButton from "./../components/ViewSlugButton.vue";
import OptionsPacksLabel from "./../components/OptionsPacksLabel.vue";
import CpuCountLabel from "./../components/CpuCountLabel.vue";
import CpuUsageLabel from "./../components/CpuUsageLabel.vue";
import ActionButton from "./../components/ActionButton.vue";
export default {
    name: "Project",
    data() {
        return {
            url: "/api/project/hosts/"+this.$route.params.slug,
            columns: [
                { label: "Index", name: "index" },
                { label: "Physical Hosts", name: 'hostname' },
                { label: "CPU Count", name: "cpu_count_file", component: CpuCountLabel },
                { label: "Options Packs", name: "options_packs_file", component: OptionsPacksLabel },
                { label: "CPU Usage", name: "cpu_usage_file", component: CpuUsageLabel },
                {
                    label: "",
                    name: "View",
                    orderable: false,
                    classes: {
                        btn: true,
                        "btn-success": true,
                        "btn-sm": true,
                    },
                    meta: {
                        prefixLink: "/admin/project/host-details/",
                        icon: {
                            has: true,
                            classes: {
                                "fa-eye": true,
                            },
                        },
                    },
                    event: "click",
                    handler: () => {},
                    component: ViewSlugButton,
                },
                {
                    label: "",
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
                    component: ActionButton,
                },
                {
                    label: "",
                    name: "Delete",
                    orderable: false,
                    classes: {
                        btn: true,
                        "btn-danger": true,
                        "btn-sm": true,
                    },
                    meta: {
                        prefixLink: null,
                        icon: {
                            has: true,
                            classes: {
                                "fa-trash": true,
                            },
                        },
                    },
                    event: "click",
                    handler: this.deleteAction,
                    component: ActionButton,
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
        CpuCountLabel,
        CpuUsageLabel,
        OptionsPacksLabel
    },
    async mounted() {
        //console.log(this.$route.params);
    },
    methods: {},
};
</script>