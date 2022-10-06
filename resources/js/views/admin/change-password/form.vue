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
              <span class="text">Change</span>
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
              <b-col cols="12">
                <b-form-group id="example-input-group-1">
                  <label class="require" for="example-input-1"
                    >Old Password</label
                  >
                  <b-form-input
                    id="example-input-1"
                    name="example-input-1"
                    class="mb-2 mr-sm-2 mb-sm-0 w-50"
                    placeholder="Old Password"
                    v-model="$v.form.old_password.$model"
                    :state="validateState('old_password')"
                    type="password"
                    aria-describedby="input-1-live-feedback"
                  ></b-form-input>

                  <b-form-invalid-feedback id="input-1-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
              <b-col cols="12">
                <b-form-group id="example-input-group-1">
                  <label class="require" for="example-input-1"
                    >New Password</label
                  >
                  <b-form-input
                    id="example-input-1"
                    name="example-input-1"
                    class="mb-2 mr-sm-2 mb-sm-0 w-50"
                    placeholder="New Password"
                    v-model="$v.form.new_password.$model"
                    :state="validateState('new_password')"
                    type="password"
                    aria-describedby="input-1-live-feedback"
                  ></b-form-input>

                  <div
                    class="invalid-feedback"
                    v-if="!$v.form.new_password.required"
                  >
                    This is a required field.
                  </div>
                  <div
                    class="invalid-feedback"
                    v-if="!$v.form.new_password.minLength"
                  >
                    Password must have at least
                    {{ $v.form.new_password.$params.minLength.min }} letters.
                  </div>
                </b-form-group>
              </b-col>
              <b-col cols="12">
                <b-form-group id="example-input-group-1">
                  <label class="require" for="example-input-1"
                    >Confirm Password</label
                  >
                  <b-form-input
                    id="example-input-1"
                    name="example-input-1"
                    class="mb-2 mr-sm-2 mb-sm-0 w-50"
                    placeholder="Confirm Password"
                    v-model="$v.form.confirm_password.$model"
                    :state="validateState('confirm_password')"
                    type="password"
                    aria-describedby="input-1-live-feedback"
                  ></b-form-input>

                  <div
                    class="invalid-feedback"
                    v-if="!$v.form.confirm_password.sameAsPassword"
                  >
                    Passwords must be identical
                  </div>
                </b-form-group>
              </b-col>
            </b-row>
          </b-form>
        </b-container>
      </div>
    </div>
    <loading
      v-if="formtype !== 'add'"
      :is-full-page="true"
      :active.sync="isLoading"
    >
    </loading>

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
import * as notify from "../../../utils/notify.js";
import { validationMixin } from "vuelidate";
import { required, sameAs, minLength } from "vuelidate/lib/validators";

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
      default: "Change Password",
    },
  },
  data() {
    return {
      loading: false,
      isLoading: false,
      busy: false,
      form: {
        old_password: null,
        new_password: null,
        confirm_password: null,
      },
    };
  },
  validations: {
    form: {
      old_password: {
        required,
      },
      new_password: {
        required,
        minLength: minLength(6),
      },
      confirm_password: {
        sameAsPassword: sameAs("new_password"),
      },
    },
  },
  async mounted() {},
  methods: {
    validateState(name) {
      const { $dirty, $error } = this.$v.form[name];
      return $dirty ? !$error : null;
    },
    resetForm() {
      this.form = {
        old_password: null,
        new_password: null,
        confirm_password: null,
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

      this.changePassword();
    },
    async changePassword() {
      try {
        const response = await axios.post("change-password", {
          ...this.form,
        });
        this.loading = false;

        let toast = this.$toasted.show(response.data.message, {
          theme: "toasted-primary",
          position: "top-right",
          duration: 5000,
        });
        this.resetForm();
      } catch (error) {
        this.loading = false;
        notify.authError(error);
      }
    },
  },
};
</script>