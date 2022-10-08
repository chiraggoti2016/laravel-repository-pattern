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
              :class="loading ? 'pe-none' : ''"
              @click="onSubmit()"
            >
              <span class="icon text-white-50">
                <b-icon
                  v-if="loading"
                  icon="arrow-clockwise"
                  animation="spin-pulse"
                  font-scale="1"
                ></b-icon>
                <i v-else class="fas fa-save"></i>
              </span>
              <span class="text">Save</span>
            </a>
            <a
              v-if="formtype === 'add'"
              href="#"
              class="btn btn-sm btn-secondary btn-icon-split ml-2"
              @click="resetForm()"
            >
              <span class="icon text-white-50">
                <i class="fas fa-undo-alt"></i>
              </span>
              <span class="text">Reset</span>
            </a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <b-container class="bv-example-row ml-0 pl-0">
          <b-form @submit.stop.prevent="onSubmit">
            <b-row>
              <b-col>
                <b-form-group id="example-input-group-1">
                  <label class="require" for="example-input-1">Name</label>
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
                  <label class="require" for="example-input-2">Address</label>
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
                  <label class="require" for="example-input-3">Country</label>
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
                  <action-button
                    :data="data"
                    :meta="resetActionButton.meta"
                    :classes="resetActionButton.classes"
                    name="reset password"
                    @click="resetActionButtonClick"
                  ></action-button>
                  <action-button
                    v-if="!data.item.email_verified_at"
                    :data="data"
                    :meta="verifyActionButton.meta"
                    :classes="verifyActionButton.classes"
                    name="send verification email"
                    @click="verifyActionButtonClick"
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
      </div>
    </div>
    <loading
      v-if="formtype !== 'add'"
      :is-full-page="true"
      :active.sync="isLoading"
    >
    </loading>

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
          label="Full Name"
          label-for="modal-name-input"
          label-class="require"
        >
          <b-form-input
            id="modal-name-input"
            name="modal-name-input"
            class="mb-2 mr-sm-2 mb-sm-0"
            placeholder="Full Name"
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
          label-class="require"
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
          <div class="invalid-feedback" v-if="!$v.newuser.phone.numbercheck">
            Enter vaild phone number.
          </div>
        </b-form-group>
      </form>
    </b-modal>

    <b-modal
      id="modal-prevent-reset-password"
      ref="modal"
      :title="
        this.userData
          ? `Reset password for ${this.userData.email}`
          : 'Reset Password'
      "
      @show="resetResetModal"
      @hidden="resetResetModal"
      @ok="handleResetOk"
      ok-title="Reset"
    >
      <form ref="form" @submit.stop.prevent="handleResetSubmit">
        <b-form-group
          id="example-modal-input-group-1"
          label="Password"
          label-for="modal-name-input-password"
          label-class="require"
        >
          <b-form-input
            type="password"
            id="modal-name-input-password"
            name="modal-name-input-password"
            class="mb-2 mr-sm-2 mb-sm-0"
            placeholder="Enter Password"
            v-model="$v.reset.password.$model"
            :state="validateResetModalState('password')"
            aria-describedby="modal-input-password-1-live-feedback"
          ></b-form-input>
          <div class="invalid-feedback" v-if="!$v.reset.password.required">
            This is a required field.
          </div>
          <div class="invalid-feedback" v-if="!$v.reset.password.minLength">
            Password must have at least
            {{ $v.reset.password.$params.minLength.min }} letters.
          </div>
        </b-form-group>

        <b-form-group
          id="example-modal-input-group-1"
          label="Password"
          label-for="modal-name-input-password"
          label-class="require"
        >
          <b-form-input
            type="password"
            id="modal-name-input-password"
            name="modal-name-input-password"
            class="mb-2 mr-sm-2 mb-sm-0"
            placeholder="Repeat Password"
            v-model="$v.reset.password_confirm.$model"
            :state="validateResetModalState('password_confirm')"
            aria-describedby="modal-input-password-1-live-feedback"
          ></b-form-input>
          <div
            class="invalid-feedback"
            v-if="!$v.reset.password_confirm.sameAsPassword"
          >
            Passwords must be identical
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
import {
  required,
  email,
  helpers,
  numeric,
  sameAs,
  minLength,
} from "vuelidate/lib/validators";
import { getAllCountries } from "../../../services/country";

export default {
  name: "AddPartner",
  mixins: [validationMixin],
  props: {
    formtype: {
      type: String,
      default: "add",
    },
    formlabel: {
      type: String,
      default: "Add Partner",
    },
  },
  data() {
    return {
      loading: false,
      isLoading: false,
      busy: false,
      overlayMessage: "Are you sure?",
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
      form: {
        name: null,
        address: null,
        country: null,
        users: [],
      },
      reset: {
        password: null,
        password_confirm: null,
      },
      editUserIndex: null,
      userData: null,
      overlayFor: null,
      newuser: {
        id: null,
        name: null,
        email: null,
        phone: null,
        email_verified_at: null,
        isNew: true,
      },
      editActionButton: {
        meta: {
          icon: {
            has: true,
            classes: {
              "fa-edit": true,
            },
          },
          onlyicon: true,
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
          onlyicon: true,
        },
        classes: {
          btn: true,
          "btn-danger": true,
          "btn-sm": true,
        },
      },
      verifyActionButton: {
        meta: {
          icon: {
            has: true,
            classes: {
              "fa-paper-plane": true,
            },
          },
          onlyicon: true,
        },
        classes: {
          btn: true,
          "btn-info": true,
          "btn-sm": true,
        },
      },
      resetActionButton: {
        meta: {
          icon: {
            has: true,
            classes: {
              "fa-eye-slash": true,
            },
          },
          onlyicon: true,
        },
        classes: {
          btn: true,
          "btn-secondary": true,
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
          if (
            value === "" ||
            value === null ||
            /[a-z0-9]+@[a-z]+\.[a-z]{2,3}/.test(value) === false
          )
            return true;
          return axios.post("users/email-already-exists", {
            email: value,
            id: vm.id,
          });
        },
      },
      phone: {
        numbercheck: helpers.regex("phone", /^(\+\d{1,3}[- ]?)?\d{10}$/),
      },
    },
    reset: {
      password: {
        required,
        minLength: minLength(6),
      },
      password_confirm: {
        sameAsPassword: sameAs("password"),
      },
    },
  },
  async mounted() {
    await this.load();
  },
  methods: {
    async load() {
      this.isLoading = true;
      await this.getCountries();
      if (this.formtype === "edit") {
        const { data } = await this.getData(this.$route.params.id);
        this.form = {
          ...data,
        };
      }
      this.isLoading = false;
    },
    async getCountries() {
      const { data } = await getAllCountries();
      this.countriesOptions = data
        ? data.map((each) => ({
            text: each.country_name,
            value: each.country_name,
          }))
        : [];
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

      this.loading = true;

      if (this.formtype === "add") {
        this.addPartner();
      } else {
        this.editPartner();
      }
    },
    async addPartner() {
      try {
        const response = await axios.post("partners", {
          ...this.form,
        });
        this.loading = false;
        this.$router.push("/admin/partners");
      } catch (error) {
        notify.authError(error);
      }
    },
    async editPartner() {
      try {
        const id = this.$route.params.id;
        const response = await axios.put(`partners/${id}`, {
          ...this.form,
        });
        this.loading = false;
        this.$router.push("/admin/partners");
      } catch (error) {
        notify.authError(error);
      }
    },
    validateModalState(name) {
      const { $dirty, $error } = this.$v.newuser[name];
      return $dirty ? !$error : null;
    },
    validateResetModalState(name) {
      const { $dirty, $error } = this.$v.reset[name];
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
    resetResetModal() {
      this.reset = {
        password: null,
        password_confirm: null,
      };
      this.userData = null;

      this.$v.$reset();
    },
    handleOk(bvModalEvent) {
      // Prevent modal from closing
      bvModalEvent.preventDefault();
      // Trigger submit handler
      this.handleAddUserSubmit();
    },
    handleResetOk(bvModalEvent) {
      // Prevent modal from closing
      bvModalEvent.preventDefault();
      // Trigger submit handler
      this.handleResetSubmit();
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
    async handleResetSubmit() {
      this.$v.reset.$touch();
      if (this.$v.reset.$anyError) {
        return;
      }

      if (this.userData) {
        await this.resetPassword(this.userData.id);
      }

      this.resetResetModal();

      // Hide the modal manually
      this.$nextTick(() => {
        this.$bvModal.hide("modal-prevent-reset-password");
      });
    },
    async resetPassword(id) {
      try {
        const response = await axios.post(`users/reset-password/${id}`, {
          ...this.reset,
        });

        let toast = this.$toasted.show("Password updated successfully", {
          theme: "toasted-primary",
          position: "top-right",
          duration: 5000,
        });
      } catch (error) {
        notify.authError(error);
      }
    },
    async getData(id) {
      try {
        const response = await axios.get(`partners/${id}`);
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
      this.editUserIndex = data.index;
      this.overlayFor = "delete";
      this.overlayMessage = `Are you sure to delete ${data.item.email} user?`;
      this.busy = true;
    },
    verifyActionButtonClick(data) {
      this.userData = data.item;
      this.overlayFor = "verify";
      this.overlayMessage = `Continue email verification for ${data.item.email} user?`;
      this.busy = true;
    },
    resetActionButtonClick(data) {
      this.$bvModal.show("modal-prevent-reset-password");
      this.$v.$reset();
      this.userData = data.item;
    },

    onOverlayCancel() {
      this.busy = false;
      this.overlayFor = null;
      this.overlayMessage = null;
      this.userData = null;
    },
    onOverlayOK() {
      if (this.overlayFor === "delete") this.onDeleteOk();
      else if (this.overlayFor === "verify") this.onVerifyOk();

      this.busy = false;
    },
    onDeleteOk() {
      if (this.editUserIndex > -1) {
        this.form.users.splice(this.editUserIndex, 1);
      }
      this.$root.$emit("bv::refresh::table", "users-b-table-id");
    },
    onVerifyOk() {
      this.sendVerifyMail(this.userData);
    },
    async sendVerifyMail(data) {
      this.isLoading = true;
      try {
        const response = await axios.post(`email/resend/${data.id}`);

        let toast = this.$toasted.show(response.data.message, {
          theme: "toasted-primary",
          position: "top-right",
          duration: 5000,
        });
        this.$root.$emit("bv::refresh::table", "users-b-table-id");
      } catch (error) {
        notify.authError(error);
      }
      this.isLoading = false;
    },
  },
  components: {
    ActionButton,
  },
};
</script>