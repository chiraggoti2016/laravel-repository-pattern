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
                <i class="fas fa-undo-alt"></i>
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
                  <label class="sr-only" for="example-input-1"
                    >Country Name</label
                  >
                  <b-form-input
                    id="example-input-1"
                    name="example-input-1"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    placeholder="Country Name"
                    v-model="$v.form.country_name.$model"
                    :state="validateState('country_name')"
                    aria-describedby="input-1-live-feedback"
                  ></b-form-input>

                  <b-form-invalid-feedback id="input-1-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
              <b-col cols="1">
                <b-form-group id="example-input-group-2">
                  <label class="sr-only" for="example-input-2">Sort Name</label>
                  <b-form-input
                    id="example-input-2"
                    name="example-input-2"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    placeholder="Sort Name"
                    v-model="$v.form.sortname.$model"
                    :state="validateState('sortname')"
                    aria-describedby="input-2-live-feedback"
                  ></b-form-input>

                  <b-form-invalid-feedback id="input-2-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
              <b-col>
                <b-form-group id="example-input-group-3">
                  <label class="sr-only" for="example-input-3"
                    >Country Lat</label
                  >
                  <b-form-input
                    id="example-input-3"
                    name="example-input-3"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    placeholder="Country Lat"
                    v-model="$v.form.country_lat.$model"
                    :state="validateState('country_lat')"
                    aria-describedby="input-3-live-feedback"
                  ></b-form-input>

                  <b-form-invalid-feedback id="input-3-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
              <b-col>
                <b-form-group id="example-input-group-4">
                  <label class="sr-only" for="example-input-4"
                    >Country Long</label
                  >
                  <b-form-input
                    id="example-input-4"
                    name="example-input-4"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    placeholder="Country Long"
                    v-model="$v.form.country_lng.$model"
                    :state="validateState('country_lng')"
                    aria-describedby="input-4-live-feedback"
                  ></b-form-input>

                  <b-form-invalid-feedback id="input-4-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
            </b-row>
            <b-row>
              <b-col>
                <b-form-group id="example-input-group-5">
                  <label class="sr-only" for="example-input-4">Timezone</label>
                  <b-form-input
                    id="example-input-5"
                    name="example-input-5"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    placeholder="Timezone"
                    v-model="$v.form.timezone.$model"
                    :state="validateState('timezone')"
                    aria-describedby="input-5-live-feedback"
                  ></b-form-input>

                  <b-form-invalid-feedback id="input-5-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
            </b-row>
          </b-form>
        </b-container>
      </div>
    </div>
  </div>
</template>

<script>
import * as notify from "../../../utils/notify.js";
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";

export default {
  name: "AddCountry",
  mixins: [validationMixin],
  props: {
    formtype: {
      type: String,
      default: "add",
    },
    formlabel: {
      type: String,
      default: "Add Country",
    },
  },
  data() {
    return {
      busy: false,
      form: {
        country_name: null,
        sortname: null,
        country_lat: null,
        country_lng: null,
        timezone: null,
      },
      editUserIndex: null,
    };
  },
  validations: {
    form: {
      country_name: {
        required,
      },
      sortname: {
        required,
      },
      country_lat: {
        required,
      },
      country_lng: {
        required,
      },
      timezone: {
        required,
      },
    },
  },
  async mounted() {
    if (this.formtype === "edit") {
      const { data } = await this.getData(this.$route.params.id);
      this.form = {
        ...data,
      };
    }
  },
  methods: {
    validateState(name) {
      const { $dirty, $error } = this.$v.form[name];
      return $dirty ? !$error : null;
    },
    resetForm() {
      this.form = {
        country_name: null,
        sortname: null,
        country_lat: null,
        country_lng: null,
        timezone: null,
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
        this.addCountry();
      } else {
        this.editCountry();
      }
    },
    async addCountry() {
      try {
        const response = await axios.post("countries", {
          ...this.form,
        });

        this.$router.push("/admin/countries");
      } catch (error) {
        notify.authError(error);
      }
    },
    async editCountry() {
      try {
        const id = this.$route.params.id;
        const response = await axios.put(`countries/${id}`, {
          ...this.form,
        });

        this.$router.push("/admin/countries");
      } catch (error) {
        notify.authError(error);
      }
    },
    async getData(id) {
      try {
        const response = await axios.get(`countries/${id}`);
        return response;
      } catch (error) {
        notify.authError(error);
      }
    },
    onOverlayCancel() {
      this.busy = false;
    },
    onOverlayOK() {
      if (this.editUserIndex > -1) {
        this.form.users.splice(this.editUserIndex, 1);
      }
      this.$root.$emit("bv::refresh::table", "users-b-table-id");

      this.busy = false;
    },
  },
};
</script>