<template>
  <div>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row">
          <div class="col-md-9 d-flex justify-content-start align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">{{ formlabel }}</h6>
          </div>
          <div class="col-md-3 d-flex justify-content-end align-items-center">
            <a
              href="#"
              class="btn btn-sm btn-primary btn-icon-split"
              @click="onSubmit()"
            >
              <span class="icon text-white-50">
                <i class="fas fa-save"></i>
              </span>
              <span v-if="formtype === 'add'" class="text">Save</span>
              <span v-if="formtype === 'edit'" class="text">Update</span>
            </a>
            <a
              v-if="formtype === 'add'"
              href="#"
              class="btn btn-sm btn-secondary btn-icon-split ml-2"
              @click="resetForm()"
            >
              <span class="icon text-white-50">
                <i class="fa fa-undo-alt"></i>
              </span>
              <span class="text">Reset</span>
            </a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <b-container class="bv-example-row">
          <b-form @submit.stop.prevent="onSubmit">
            <b-row>
              <b-col>
                <b-form-group id="example-input-group-1">
                  <label class="sr-only" for="example-input-1">Name</label>
                  <b-form-input
                    id="example-input-1"
                    name="example-input-1"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    placeholder="Name"
                    v-model="$v.form.name.$model"
                    :state="validateState('name')"
                    aria-describedby="input-1-live-feedback"
                  ></b-form-input>

                  <b-form-invalid-feedback id="input-1-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
              <b-col cols="6">
                <b-form-group id="example-input-group-2">
                  <label class="sr-only" for="example-input-2">Address</label>
                  <b-form-input
                    id="example-input-2"
                    name="example-input-2"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    placeholder="Address"
                    v-model="$v.form.address.$model"
                    :state="validateState('address')"
                    aria-describedby="input-2-live-feedback"
                  ></b-form-input>

                  <b-form-invalid-feedback id="input-2-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
              <b-col>
                <b-form-group id="example-input-group-3">
                  <label class="sr-only" for="example-input-3">Country</label>
                  <b-form-select
                    id="example-input-3"
                    name="example-input-3"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    v-model="$v.form.country.$model"
                    :options="countriesOptions"
                    :state="validateState('country')"
                    aria-describedby="input-3-live-feedback"
                  >
                    <template #first>
                      <b-form-select-option :value="null" disabled
                        >Select Country</b-form-select-option
                      >
                    </template>
                  </b-form-select>

                  <b-form-invalid-feedback id="input-3-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
            </b-row>
          </b-form>
        </b-container>

        <div class="table-responsive">
          <b-card
            sub-title="Users"
            class="form-list"
            :class="
              $v.form.users.$dirty
                ? $v.form.users.$invalid
                  ? 'is-invalid'
                  : 'is-valid'
                : ''
            "
          >
            <b-card-text>
              <div class="d-flex justify-content-end align-items-center mb-1">
                <a
                  href="#"
                  class="btn btn-sm btn-primary btn-icon-split"
                  v-b-modal.modal-prevent-closing
                >
                  <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                  </span>
                  <span class="text">Add User</span>
                </a>
              </div>
            </b-card-text>

            <b-card-text>
              <b-table
                v-if="form.users.length > 0"
                id="users-b-table-id"
                small
                striped
                hover
                :items="form.users"
                :fields="userFields"
                responsive="sm"
                caption-top
              >
                <template #cell(index)="data">
                  {{ data.index + 1 }}
                </template>

                <!-- email_verified_at -->
                <template #cell(email_verified_at)="data">
                  <b-badge variant="success" v-if="data.item.email_verified_at"
                    >Yes</b-badge
                  >
                  <b-badge v-if="!data.item.email_verified_at">No</b-badge>
                </template>

                <template #cell(actions)="data">
                  <action-button
                    :data="data"
                    :meta="editActionButton.meta"
                    name="edit"
                    @click="editActionButtonClick"
                  ></action-button>
                  <action-button
                    :data="data"
                    :meta="deleteActionButton.meta"
                    :classes="deleteActionButton.classes"
                    name="delete"
                    @click="deleteActionButtonClick"
                  ></action-button>
                </template>
              </b-table>
              <p v-if="form.users.length === 0" class="mb-0">No Data</p>
              <div class="invalid-feedback" v-if="!$v.form.users.required">
                Please add at least one user.
              </div>
            </b-card-text>
          </b-card>
        </div>

        <div class="table-responsive">
          <b-card
            sub-title="Projects"
            class="form-list"
            :class="
              $v.form.projects.$dirty
                ? $v.form.projects.$invalid
                  ? 'is-invalid'
                  : 'is-valid'
                : ''
            "
          >
            <b-card-text>
              <div class="d-flex justify-content-end align-items-center mb-1">
                <a
                  href="#"
                  class="btn btn-sm btn-primary btn-icon-split"
                  v-b-modal.modal-project
                >
                  <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                  </span>
                  <span class="text">Add Project</span>
                </a>
              </div>
            </b-card-text>

            <b-card-text>
              <b-table
                v-if="form.projects.length > 0"
                id="projects-b-table-id"
                small
                striped
                hover
                :items="form.projects"
                :fields="projectFields"
                responsive="sm"
                caption-top
              >
                <template #cell(index)="data">
                  {{ data.index + 1 }}
                </template>

                <template #cell(status)="data">
                  <b-badge variant="secondary">{{ data.item.status }}</b-badge>
                </template>

                <template #cell(scope)="data">
                  <b-badge
                    variant="secondary"
                    v-if="data.item.scope && scopes[data.item.scope]"
                    >{{ scopes[data.item.scope].name }}</b-badge
                  >
                </template>

                <template #cell(actions)="data">
                  <action-button
                    :data="data"
                    :meta="editActionButton.meta"
                    name="edit"
                    @click="editProjectActionButtonClick"
                  ></action-button>
                  <action-button
                    :data="data"
                    :meta="deleteActionButton.meta"
                    :classes="deleteActionButton.classes"
                    name="delete"
                    @click="deleteProjectActionButtonClick"
                  ></action-button>
                  <action-button
                    v-if="!data.item.isNew"
                    :data="data.item"
                    :meta="openActionButton.meta"
                    :classes="openActionButton.classes"
                    name="open"
                  ></action-button>
                </template>
              </b-table>

              <p v-if="form.projects.length === 0" class="mb-0">No Data</p>
              <div class="invalid-feedback" v-if="!$v.form.projects.required">
                Please add at least one project.
              </div>
            </b-card-text>
          </b-card>
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

    <b-modal
      id="modal-prevent-closing"
      ref="modal"
      :title="editUserIndex !== null ? 'Edit User' : 'Add User'"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
      :ok-title="editUserIndex !== null ? 'Edit' : 'Add'"
    >
      <form ref="form" @submit.stop.prevent="handleAddUserSubmit">
        <b-form-group
          id="example-modal-input-group-1"
          label="Name"
          label-for="modal-name-input"
        >
          <b-form-input
            id="modal-name-input"
            name="modal-name-input"
            class="mb-2 mr-sm-2 mb-sm-0"
            placeholder="Name"
            v-model="$v.newuser.name.$model"
            :state="validateModalState('name')"
            aria-describedby="modal-input-1-live-feedback"
          ></b-form-input>
          <div class="invalid-feedback" v-if="!$v.newuser.name.required">
            This is a required field.
          </div>
          <div class="invalid-feedback" v-if="!$v.newuser.name.isFullname">
            Full name is require.
          </div>
        </b-form-group>

        <b-form-group
          id="example-modal-input-group-2"
          label="Email"
          label-for="modal-email-input"
        >
          <b-form-input
            id="modal-email-input"
            name="modal-email-input"
            class="mb-2 mr-sm-2 mb-sm-0"
            placeholder="Email"
            v-model="$v.newuser.email.$model"
            :state="validateModalState('email')"
            aria-describedby="modal-input-2-live-feedback"
          ></b-form-input>
          <div class="invalid-feedback" v-if="!$v.newuser.email.required">
            This is a required field.
          </div>
          <div class="invalid-feedback" v-if="!$v.newuser.email.email">
            Enter vaild email.
          </div>
          <div
            class="invalid-feedback"
            v-if="!$v.newuser.email.isEmailAlreadyExists"
          >
            Email already exists.
          </div>
        </b-form-group>

        <b-form-group
          id="example-modal-input-group-3"
          label="Phone"
          label-for="modal-phone-input"
        >
          <b-form-input
            id="modal-phone-input"
            name="modal-phone-input"
            class="mb-2 mr-sm-2 mb-sm-0"
            placeholder="Phone"
            v-model="$v.newuser.phone.$model"
            :state="validateModalState('phone')"
            aria-describedby="modal-input-3-live-feedback"
          ></b-form-input>
          <div class="invalid-feedback" v-if="!$v.newuser.phone.required">
            This is a required field.
          </div>
          <div class="invalid-feedback" v-if="!$v.newuser.phone.numbercheck">
            Enter vaild phone number.
          </div>
        </b-form-group>
      </form>
    </b-modal>

    <b-modal
      id="modal-project"
      ref="modal2"
      :title="editProjectIndex !== null ? 'Edit Project' : 'Add Project'"
      @show="resetProjectModal"
      @hidden="resetProjectModal"
      @ok="handleProjectOk"
      :ok-title="editProjectIndex !== null ? 'Edit' : 'Add'"
    >
      <form ref="form" @submit.stop.prevent="handleAddProjectSubmit">
        <b-form-group
          id="project-modal-input-group-1"
          label="Name"
          label-for="modal-name-input"
        >
          <b-form-input
            id="modal-name-input"
            name="modal-name-input"
            class="mb-2 mr-sm-2 mb-sm-0"
            placeholder="Name"
            v-model="$v.newproject.name.$model"
            :state="validateProjectModalState('name')"
            aria-describedby="project-modal-input-1-live-feedback"
          ></b-form-input>
          <b-form-invalid-feedback id="project-modal-input-1-live-feedback"
            >This is a required field.</b-form-invalid-feedback
          >
        </b-form-group>

        <b-form-group
          id="project-modal-input-group-2"
          label="Start Date"
          label-for="modal-startdate-input"
        >
          <b-form-datepicker
            id="modal-startdate-input"
            name="modal-startdate-input"
            class="mb-2 mr-sm-2 mb-sm-0"
            placeholder="Start Date"
            v-model="$v.newproject.startdate.$model"
            :state="validateProjectModalState('startdate')"
            aria-describedby="project-modal-input-2-live-feedback"
          ></b-form-datepicker>
          <div
            class="invalid-feedback"
            v-if="!$v.newproject.startdate.required"
          >
            This is a required field.
          </div>
        </b-form-group>

        <b-form-group
          id="project-modal-input-group-3"
          label="End Date"
          label-for="modal-enddate-input"
        >
          <b-form-datepicker
            id="modal-enddate-input"
            name="modal-enddate-input"
            class="mb-2 mr-sm-2 mb-sm-0"
            placeholder="End Date"
            v-model="$v.newproject.enddate.$model"
            :state="validateProjectModalState('enddate')"
            aria-describedby="project-modal-input-3-live-feedback"
          ></b-form-datepicker>
          <div class="invalid-feedback" v-if="!$v.newproject.enddate.required">
            This is a required field.
          </div>
        </b-form-group>
      </form>
    </b-modal>
  </div>
</template>

<script>
import ActionButton from "./../components/ActionButton.vue";
import * as notify from "../../../utils/notify.js";
import { reactive, toRefs } from "vue";
import { validationMixin } from "vuelidate";
import { required, email, helpers, numeric } from "vuelidate/lib/validators";
import { getScopesBySlug } from "../../../services/scope";
import { getAllCountries } from "../../../services/country";

export default {
  name: "FormCustomer",
  mixins: [validationMixin],
  props: {
    formtype: {
      type: String,
      default: "add",
    },
    formlabel: {
      type: String,
      default: "Add Customer",
    },
  },
  data() {
    return {
      scopes: {
        oracle_database: { id: 1, name: "Oracle Database" },
      },
      busy: false,
      isDeleteFor: null,
      countriesOptions: [],
      userFields: [
        "index",
        "name",
        "email",
        "phone",
        {
          key: "email_verified_at",
          label: "Email Verified",
          class: "text-center",
        },
        "actions",
      ],
      projectFields: [
        "index",
        "name",
        "scope",
        "startdate",
        "enddate",
        "status",
        "actions",
      ],
      form: {
        name: null,
        address: null,
        country: null,
        users: [],
        projects: [],
      },
      editUserIndex: null,
      newuser: {
        name: null,
        email: null,
        phone: null,
        email_verified_at: null,
        isNew: true,
      },
      newproject: {
        name: "",
        startdate: "",
        enddate: "",
        status: "pending",
        scope: "oracle_database",
        isNew: true,
      },
      editProjectIndex: null,
      editActionButton: {
        meta: {
          icon: {
            has: true,
            classes: {
              "fa-edit": true,
            },
          },
        },
      },
      deleteActionButton: {
        meta: {
          icon: {
            has: true,
            classes: {
              "fa-trash": true,
            },
          },
        },
        classes: {
          btn: true,
          "btn-danger": true,
          "btn-sm": true,
        },
      },
      openActionButton: {
        meta: {
          prefixLink:
            "/admin/customers/open/project/" + this.getParamId() + "/",
          icon: {
            has: true,
            classes: {
              "fa-arrow-up": true,
            },
          },
        },
        classes: {
          btn: true,
          "btn-info": true,
          "btn-sm": true,
        },
      },
    };
  },
  validations: {
    form: {
      name: {
        required,
      },
      address: {
        required,
      },
      country: {
        required,
      },
      users: {
        required,
      },
      projects: {
        required,
      },
    },
    newuser: {
      name: {
        required,
        isFullname: helpers.regex("name", /^([A-z0-9]+) ([A-z0-9]+)$/),
      },
      email: {
        required,
        email,
        isEmailAlreadyExists: (value, vm) => {
          if (value === "" || value === null) return true;
          return axios.post("users/email-already-exists", {
            email: value,
            id: vm.id,
          });
        },
      },
      phone: {
        required,
        numbercheck: helpers.regex("phone", /^(\+\d{1,3}[- ]?)?\d{10}$/),
      },
    },
    newproject: {
      name: {
        required,
      },
      startdate: {
        required,
      },
      enddate: {
        required,
      },
    },
  },
  async mounted() {
    // countries
    await this.getCountries();
    // load scopes
    await this.getScopes();

    if (this.formtype === "edit") {
      const { data } = await this.getData(this.getParamId());
      this.form = {
        ...data,
      };
    }
  },
  methods: {
    async getCountries() {
      const { data } = await getAllCountries();
      this.countriesOptions = data
        ? data.map((each) => ({
            text: each.country_name,
            value: each.country_name,
          }))
        : [];
    },
    async getScopes() {
      const { data } = await getScopesBySlug();
      this.scopes = { ...data };
    },
    getParamId() {
      return this.$route.params.id;
    },
    validateState(name) {
      const { $dirty, $error } = this.$v.form[name];
      return $dirty ? !$error : null;
    },
    resetForm() {
      this.form = {
        name: null,
        address: null,
        country: null,
        users: [],
        projects: [],
      };

      this.$nextTick(() => {
        this.$v.$reset();
      });
    },
    onSubmit() {
      this.$v.form.$touch();
      if (this.$v.form.$anyError) {
        return;
      }
      if (this.formtype === "add") {
        this.addCustomer();
      } else {
        this.editCustomer();
      }
    },
    async addCustomer() {
      try {
        const response = await axios.post("customers", {
          ...this.form,
        });

        this.$router.push("/admin/customers");
      } catch (error) {
        notify.authError(error);
      }
    },
    async editCustomer() {
      try {
        const id = this.$route.params.id;
        const response = await axios.put(`customers/${id}`, {
          ...this.form,
        });

        this.$router.push("/admin/customers");
      } catch (error) {
        notify.authError(error);
      }
    },
    validateModalState(name) {
      const { $dirty, $error } = this.$v.newuser[name];
      return $dirty ? !$error : null;
    },
    validateProjectModalState(name) {
      const { $dirty, $error } = this.$v.newproject[name];
      return $dirty ? !$error : null;
    },
    resetModal() {
      this.newuser = {
        id: null,
        name: "",
        email: "",
        phone: "",
        email_verified_at: null,
        isNew: true,
      };
      this.editUserIndex = null;

      this.$v.$reset();
    },
    resetProjectModal() {
      this.newproject = {
        id: null,
        name: "",
        startdate: "",
        enddate: "",
        status: "pending",
        scope: "oracle_database",
        isNew: true,
      };
      this.editProjectIndex = null;

      this.$v.$reset();
    },
    handleOk(bvModalEvent) {
      // Prevent modal from closing
      bvModalEvent.preventDefault();
      // Trigger submit handler
      this.handleAddUserSubmit();
    },
    handleProjectOk(bvModalEvent) {
      // Prevent modal from closing
      bvModalEvent.preventDefault();
      // Trigger submit handler
      this.handleAddProjectSubmit();
    },
    handleAddUserSubmit() {
      this.$v.newuser.$touch();
      if (this.$v.newuser.$anyError) {
        return;
      }

      // Push / Update
      if (this.editUserIndex != null && this.editUserIndex != -1) {
        this.form.users[this.editUserIndex] = { ...this.newuser, isNew: false };
      } else this.form.users.push({ ...this.newuser, isNew: true, id: null });

      this.$root.$emit("bv::refresh::table", "users-b-table-id");
      this.resetModal();

      // Hide the modal manually
      this.$nextTick(() => {
        this.$bvModal.hide("modal-prevent-closing");
      });
    },
    handleAddProjectSubmit() {
      this.$v.newproject.$touch();
      if (this.$v.newproject.$anyError) {
        return;
      }

      // Push / Update
      if (this.editProjectIndex != null && this.editProjectIndex != -1) {
        this.form.projects[this.editProjectIndex] = {
          ...this.newproject,
          isNew: false,
        };
      } else
        this.form.projects.push({ ...this.newproject, isNew: true, id: null });

      this.$root.$emit("bv::refresh::table", "projects-b-table-id");
      this.resetProjectModal();

      // Hide the modal manually
      this.$nextTick(() => {
        this.$bvModal.hide("modal-project");
      });
    },
    async getData(id) {
      try {
        const response = await axios.get(`customers/${id}`);
        return response;
      } catch (error) {
        notify.authError(error);
      }
    },
    editActionButtonClick(data) {
      const { id, name, email, phone, email_verified_at } = data.item;
      this.$bvModal.show("modal-prevent-closing");
      this.editUserIndex = data.index;
      this.newuser = {
        id,
        name,
        email,
        phone,
        email_verified_at,
      };
      this.$v.$reset();
    },
    deleteActionButtonClick(data) {
      this.isDeleteFor = "user";
      this.editUserIndex = data.index;
      this.busy = true;
    },
    openActionButtonClick() {},
    editProjectActionButtonClick(data) {
      const { id, name, scope, startdate, enddate, status } = data.item;
      this.$bvModal.show("modal-project");
      this.editProjectIndex = data.index;
      this.newproject = {
        id,
        name,
        startdate,
        enddate,
        status,
        scope,
      };
      this.$v.$reset();
    },
    deleteProjectActionButtonClick(data) {
      this.isDeleteFor = "project";
      this.editProjectIndex = data.index;
      this.busy = true;
    },

    onOverlayCancel() {
      this.isDeleteFor = null;
      this.busy = false;
    },
    onOverlayOK() {
      if (this.isDeleteFor == "user") {
        if (this.editUserIndex > -1) {
          this.form.users.splice(this.editUserIndex, 1);
        }
        this.$root.$emit("bv::refresh::table", "users-b-table-id");
      } else {
        if (this.editProjectIndex > -1) {
          this.form.projects.splice(this.editProjectIndex, 1);
        }
        this.$root.$emit("bv::refresh::table", "users-b-table-id");
      }

      this.busy = false;
      this.isDeleteFor = null;
    },
  },
  components: {
    ActionButton,
  },
};
</script>