<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-10 d-flex justify-content-start align-items-center" >
                        <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
                    </div>
                    <div class="col-md-2 float-right d-flex justify-content-end">
                        <router-link class="btn btn-sm btn-primary btn-icon-split" to="/admin/projects/add" >
                            <span class="icon text-white-50" ><i class="fas fa-plus"></i ></span>
                            <span class="text">Add Project</span>
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive p0-last-3">
                    <data-table :url="url" :columns="columns" :headers="headers"></data-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, toRefs } from "vue";
import ViewSlugButton from "./../components/ViewSlugButton.vue";
import ActionButton from "./../components/ActionButton.vue";
import viewButton from "./../components/viewButton.vue";
export default {
    name: "Project",
    data() {
        return {
            url: "/api/projects",
            columns: [
                { label: "Index", name: "id", searchable: false },
                { label: "Project Name", name: "name" },
                { label: "Status", name: "status" },
                { label: "Scope", name: "scope" },
                { label: "Created By", name: "folder" },
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
                        prefixLink: "/admin/customers/open/project/",
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
        ViewSlugButton,
        ActionButton,
        viewButton,
    },
    methods: {
        onOverlayCancel() {
            this.busy = false;
        },
        onOverlayOK() {
            this.busy = false;
        },
        viewAction() {
            //console.log("data");
        },
    },
};
</script>