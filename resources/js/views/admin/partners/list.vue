<template>
  <div>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row">
          <div
            class="col-md-10 d-flex justify-content-start align-items-center"
          >
            <h6 class="m-0 font-weight-bold text-primary">Partners</h6>
          </div>
          <div class="col-md-2 float-right d-flex justify-content-end">
            <router-link
              class="btn btn-sm btn-primary btn-icon-split"
              to="/admin/partners/add"
            >
              <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
              </span>
              <span class="text">Add Partner</span>
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
  name: "Partner",
  setup() {
    const data = reactive({
      url: "https://optima.test/api/partners",
      columns: [
        {
          label: "Partner ID",
          name: "id",
          searchable: false,
        },
        {
          label: "Partner Name",
          name: "name",
        },
        {
          label: "No of Users",
          name: "users_count",
        },
        {
          label: "Customers",
          name: "customers_count",
        },
        {
          label: "OLA Engagements",
          name: "ola_engagements",
        },
        {
          label: "Completed",
          name: "completed",
        },
        {
          label: "Cancelled",
          name: "cancelled",
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
          icon: {
            has: true,
            classes: {
              "fa-edit": true,
            },
          },
          meta: {
            prefixLink: "/admin/partners/edit/",
            icon: {
              has: true,
              classes: {
                "fa-flag": true,
              },
            },
          },
          event: "click",
          handler: (data) => {
            // /admin/partners/edit
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