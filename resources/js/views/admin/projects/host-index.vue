<template>
  <div>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row">
          <div class="col-md-6 d-flex justify-content-start align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
              Server/Host Details
            </h6>
          </div>
          <div class="col-md-6 float-right d-flex justify-content-end">
            <router-link
              class="btn btn-sm btn-primary btn-icon-split"
              to="/admin/projects/add"
            >
              <span class="icon text-white-50"
                ><i class="fas fa-plus"></i
              ></span>
              <span class="text">Upload CPU Counts</span>
            </router-link>
            &nbsp;
            <router-link
              class="btn btn-sm btn-primary btn-icon-split"
              to="/admin/projects/add"
            >
              <span class="icon text-white-50"
                ><i class="fas fa-plus"></i
              ></span>
              <span class="text">Upload CPU Options</span>
            </router-link>
            &nbsp;
            <router-link
              class="btn btn-sm btn-primary btn-icon-split"
              to="/admin/projects/add"
            >
              <span class="icon text-white-50"
                ><i class="fas fa-plus"></i
              ></span>
              <span class="text">Upload CPU Usage</span>
            </router-link>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <data-table
            :url="url"
            :columns="columns"
            :headers="headers"
          ></data-table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { reactive, toRefs } from "vue";
import ActionButton from "./../components/ActionButton.vue";
export default {
  name: "Project",
  data() {
    return {
      url: "/api/projects",
      columns: [
        { label: "Physical Host", name: "name" },
        { label: "Cluster Name", name: "slug" },
        { label: "Server Identifier", name: "status" },
        { label: "Environment", name: "scope" },
        { label: "No. Of DB", name: "folder" },
        { label: "Total Cores", name: "folder" },
        { label: "CPU Util(%)", name: "folder" },
        { label: "RAM (GB)", name: "folder" },
        { label: "Storage (GB)", name: "folder" },
      ],
      headers: {
        ...axiosHeaders,
      },
      busy: false,
    };
  },
  components: {
    ActionButton,
  },
  async mounted() {
    console.log(this.$route.params);
  },
  methods: {},
};
</script>