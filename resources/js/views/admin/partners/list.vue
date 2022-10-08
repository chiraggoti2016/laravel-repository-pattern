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
        <div class="p0-last-2">
          <data-table
            :url="url"
            :columns="columns"
            :headers="headers"
            :classes="classes"
            ref="myTable"
            @loading="isLoading = true"
            @finished-loading="isLoading = false"
          >
          </data-table>
          <loading :is-full-page="true" :active.sync="isLoading"> </loading>
        </div>
      </div>
    </div>

    <b-overlay :show="busy" no-wrap fixed>
      <template #overlay>
        <div
          ref="dialog"
          tabindex="-1"
          role="dialog"
          aria-modal="false"
          aria-labelledby="form-confirm-label"
          class="text-center p-3"
        >
          <p>
            <strong id="form-confirm-label">{{ overlayMessage }}</strong>
          </p>
          <div class="d-flex">
            <b-button
              variant="outline-danger"
              class="mr-3"
              @click="onOverlayCancel"
            >
              Cancel
            </b-button>
            <b-button variant="outline-success" @click="onOverlayOK"
              >OK</b-button
            >
          </div>
        </div>
      </template>
    </b-overlay>
  </div>
</template>

<script>
import { reactive, toRefs } from "vue";
import ActionButton from "./../components/ActionButton.vue";
import DeleteButton from "./../components/DeleteButton.vue";
import * as notify from "../../../utils/notify.js";
export default {
  name: "Partner",
  data() {
    return {
      url: "/api/partners",
      deleteId: null,
      isLoading: false,
      classes: {
        td: {
          "text-center": true,
        },
      },
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
          classes: {
            "text-center": true,
          },
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
          label: "",
          name: "edit",
          orderable: false,
          classes: {
            btn: true,
            "btn-warning": true,
            "btn-sm": true,
          },
          meta: {
            prefixLink: "/admin/partners/edit/",
            icon: {
              has: true,
              classes: {
                "fa-edit": true,
              },
            },
            onlyicon: true,
          },
          event: "click",
          handler: () => {},
          component: ActionButton,
        },
        {
          label: "",
          name: "delete",
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
            onlyicon: true,
          },
          event: "click",
          handler: this.deleteAction,
          component: DeleteButton,
        },
      ],
      headers: {
        ...axiosHeaders,
      },
      busy: false,
      overlayMessage: "Are you sure?",
    };
  },
  components: {
    ActionButton,
    DeleteButton,
  },
  methods: {
    onOverlayCancel() {
      this.busy = false;
    },
    async onOverlayOK() {
      try {
        const id = this.$route.params.id;
        const response = await axios.delete(`partners/${this.deleteId}`);
        this.$refs.myTable.getData();
      } catch (error) {
        notify.authError(error);
      }
      this.deleteId = null;
      this.busy = false;
    },
    deleteAction(data) {
      this.deleteId = data.id;
      this.busy = true;
    },
  },
};
</script>