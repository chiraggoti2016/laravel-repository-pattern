<template>
  <div>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row">
          <div
            class="col-md-10 d-flex justify-content-start align-items-center"
          >
            <h6 class="m-0 font-weight-bold text-primary">
              Question Categories
            </h6>
          </div>
          <div class="col-md-2 float-right d-flex justify-content-end">
            <router-link
              class="btn btn-sm btn-primary btn-icon-split"
              to="/admin/question/categories/add"
            >
              <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
              </span>
              <span class="text">Add Category</span>
            </router-link>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive p0-last-1">
          <data-table :url="url" :columns="columns" :headers="headers">
          </data-table>
        </div>
      </div>
    </div>

    <b-overlay :show="busy" no-wrap>
      <template #overlay>
        <div
          ref="dialog"
          tabindex="-1"
          role="dialog"
          aria-modal="false"
          aria-labelledby="form-confirm-label"
          class="text-center p-3"
        >
          <p><strong id="form-confirm-label">Are you sure?</strong></p>
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
export default {
  name: "QuestionCategory",
  data() {
    return {
      url: "https://optima.test/api/question/categories",
      columns: [
        {
          label: "Category ID",
          name: "id",
          searchable: false,
        },
        {
          label: "Category Name",
          name: "category",
        },
        {
          label: "Slug",
          name: "slug",
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
            prefixLink: "/admin/question/categories/edit/",
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
        // {
        //   label: "",
        //   name: "delete",
        //   orderable: false,
        //   classes: {
        //     btn: true,
        //     "btn-danger": true,
        //     "btn-sm": true,
        //   },
        //   meta: {
        //     prefixLink: null,
        //     icon: {
        //       has: true,
        //       classes: {
        //         "fa-trash": true,
        //       },
        //     },
        //   },
        //   event: "click",
        //   handler: this.deleteAction,
        //   component: ActionButton,
        // },
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
  methods: {
    onOverlayCancel() {
      this.busy = false;
    },
    onOverlayOK() {
      this.busy = false;
    },
    deleteAction(data) {
      console.log("delete action");
      this.busy = true;
    },
  },
};
</script>