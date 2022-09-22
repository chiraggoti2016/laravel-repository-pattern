<template>
  <div>
    <div class="row">
      <div class="col-sm-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <div class="row">
              <div
                class="col-md-4 d-flex justify-content-start align-items-center"
              >
                <h6 class="m-0 font-weight-bold text-primary">
                  {{ formlabel }}
                </h6>
              </div>
              <div
                class="col-md-8 d-flex justify-content-end align-items-center"
              >
                <a
                  href="#"
                  class="btn btn-sm btn-primary btn-icon-split"
                  @click="onSubmit()"
                  :class="loading ? 'pe-none' : ''"
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
                  <span v-if="formtype === 'add'" class="text">Save</span>
                  <span v-if="formtype === 'edit'" class="text">Update</span>
                </a>
                <a
                  v-if="formtype === 'add'"
                  href="#"
                  class="btn btn-sm btn-secondary btn-icon-split ml-2"
                  @click="resetForm()"
                >
                  <span class="icon text-white-50"
                    ><i class="fas fa-undo-alt"></i
                  ></span>
                  <span class="text">Reset</span>
                </a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <b-container class="bv-example-row">
              <b-form @submit.stop.prevent="onSubmit">
                <b-row>
                  <b-col cols="12">
                    <b-form-group id="example-input-group-1">
                      <label for="example-input-1">Project Name</label>
                      <b-form-input
                        id="example-input-1"
                        name="example-input-1"
                        class="mb-2 mr-sm-2 mb-sm-0"
                        placeholder="Project Name"
                        v-model="$v.form.name.$model"
                        :state="validateState('name')"
                        aria-describedby="input-1-live-feedback"
                      ></b-form-input>
                      <b-form-invalid-feedback id="input-1-live-feedback"
                        >This is a required field.</b-form-invalid-feedback
                      >
                    </b-form-group>
                  </b-col>
                </b-row>
                <b-row>
                  <b-col cols="12">
                    <b-form-group id="example-input-group-2">
                      <label for="example-input-2">Slug</label>
                      <b-form-input
                        id="example-input-2"
                        name="example-input-2"
                        class="mb-2 mr-sm-2 mb-sm-0"
                        placeholder="Slug"
                        v-model="$v.form.slug.$model"
                        :state="validateState('slug')"
                        aria-describedby="input-2-live-feedback"
                      ></b-form-input>
                      <b-form-invalid-feedback id="input-2-live-feedback"
                        >This is a required field.</b-form-invalid-feedback
                      >
                    </b-form-group>
                  </b-col>
                </b-row>
                <b-row>
                  <b-col cols="12">
                    <b-form-group id="example-input-group-3">
                      <label for="example-input-3">Folder</label>
                      <b-form-input
                        id="example-input-3"
                        name="example-input-3"
                        class="mb-2 mr-sm-2 mb-sm-0"
                        placeholder="Folder"
                        v-model="$v.form.folder.$model"
                        :state="validateState('folder')"
                        aria-describedby="input-3-live-feedback"
                      ></b-form-input>
                      <b-form-invalid-feedback id="input-3-live-feedback"
                        >This is a required field.</b-form-invalid-feedback
                      >
                    </b-form-group>
                  </b-col>
                </b-row>
                <!--b-row>
                                    <b-col cols="12">
                                        <b-form-group id="example-input-group-3">
                                            <label for="example-input-3">Start Date</label>
                                            <b-form-date id="example-input-3" name="example-input-3" class="mb-2 mr-sm-2 mb-sm-0" placeholder="Start Date"
                                                v-model="$v.form.start_date.$model" :state="validateState('start_date')" aria-describedby="input-3-live-feedback" ></b-form-date>
                                            <b-form-invalid-feedback id="input-3-live-feedback" >This is a required field.</b-form-invalid-feedback >
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col cols="12">
                                        <b-form-group id="example-input-group-3">
                                            <label for="example-input-3">Start Date</label>
                                            <b-form-date id="example-input-3" name="example-input-3" class="mb-2 mr-sm-2 mb-sm-0" placeholder="End Date"
                                                v-model="$v.form.end_date.$model" :state="validateState('end_date')" aria-describedby="input-3-live-feedback" ></b-form-date>
                                            <b-form-invalid-feedback id="input-3-live-feedback" >This is a required field.</b-form-invalid-feedback >
                                        </b-form-group>
                                    </b-col>
                                </b-row-->
              </b-form>
            </b-container>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ActionButton from "./../components/ActionButton.vue";
import * as notify from "../../../utils/notify.js";
import { reactive, toRefs } from "vue";
import { validationMixin } from "vuelidate";
import { required, email, helpers, numeric } from "vuelidate/lib/validators";

export default {
  name: "AddProject",
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
      busy: false,
      form: {
        name: null,
        slug: null,
        folder: null,
        /*start_date: null,
                end_date: null*/
      },
    };
  },
  validations: {
    form: {
      name: {
        required,
      },
      slug: {
        required,
      },
      folder: {
        required,
      },
      /*start_date: {
                required,
            },
            end_date: {
                required,
            },*/
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
        name: null,
        slug: null,
        folder: null,
        /*start_date: null,
                end_date: null,*/
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
        this.addProject();
      } else {
        this.editProject();
      }
    },
    async addProject() {
      try {
        const response = await axios.post("projects", {
          ...this.form,
        });
        this.loading = false;

        this.$router.push("/admin/projects");
      } catch (error) {
        notify.authError(error);
      }
    },
    async editProject() {
      try {
        const id = this.$route.params.id;
        const response = await axios.put(`projects/${id}`, {
          ...this.form,
        });
        this.loading = false;

        this.$router.push("/admin/projects");
      } catch (error) {
        notify.authError(error);
      }
    },
    async getData(id) {
      try {
        const response = await axios.get(`projects/${id}`);
        return response;
      } catch (error) {
        notify.authError(error);
      }
    },
  },
  components: {
    ActionButton,
  },
};
</script>