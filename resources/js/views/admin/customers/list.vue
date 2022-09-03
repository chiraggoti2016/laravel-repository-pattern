<template>
  <div>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row">
          <div
            class="col-md-10 d-flex justify-content-start align-items-center"
          >
            <h6 class="m-0 font-weight-bold text-primary">Customers</h6>
          </div>
          <div class="col-md-2 float-right d-flex justify-content-end">
            <router-link
              class="btn btn-sm btn-primary btn-icon-split"
              to="/admin/customers/add"
            >
              <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
              </span>
              <span class="text">Add Customer</span>
            </router-link>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <data-table :url="url" :columns="columns" :headers="headers">
          </data-table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { reactive, toRefs } from "vue";
import ActionButtons from "./../components/Actions.vue";
export default {
  name: "Customer",
  setup() {
    const data = reactive({
      url: "https://optima.test/api/customers",
      columns: [
        {
          label: "Customer ID",
          name: "id",
          searchable: false,
        },
        {
          label: "Customer Name",
          name: "name",
        },
        {
          label: "Users",
          name: "users_count",
        },
        {
          label: "Projects",
          name: "projects_count",
        },
        {
          label: "Oracle",
          name: "oracle",
        },
        {
          label: "Microsoft",
          name: "microsoft",
        },
        {
          label: "VMWare",
          name: "vmware",
        },
        {
          label: "SAP",
          name: "sap",
        },
        {
          label: "Actions",
          name: "edit",
          orderable: false,
          classes: {
            btn: true,
            "btn-warning": true,
            "btn-sm": true,
          },
          meta: {
            prefixLink: "/admin/customers/edit/",
            icon: {
              has: true,
              classes: {
                "fa-edit": true,
              },
            },
          },
          event: "click",
          handler: (data) => {
            // /admin/customers/edit
            // alert(`You clicked row ${data.id}`);
          },
          component: ActionButtons,
        },
      ],
      headers: {
        ...axiosHeaders,
      },
    });

    return { ...toRefs(data) };
  },
  components: {
    ActionButtons,
  },
};
</script>