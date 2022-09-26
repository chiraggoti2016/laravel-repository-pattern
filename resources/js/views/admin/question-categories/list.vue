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
        <div class="table-responsive p0-last-2">
          <data-table
            :url="url"
            :columns="columns"
            :headers="headers"
            ref="myTable"
            @loading="isLoading = true"
            @finished-loading="isLoading = false"
          >
          </data-table>
          <loading :is-full-page="true" :active.sync="isLoading"> </loading>
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
import DeleteButton from "./../components/DeleteButton.vue";
import * as notify from "../../../utils/notify.js";
export default {
  name: "QuestionCategory",
  data() {
    return {
      isLoading: false,
      url: "/api/question/categories/list",
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
        const response = await axios.delete(
          `question/categories/${this.deleteId}`
        );
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