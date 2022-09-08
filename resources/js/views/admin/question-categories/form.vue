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
                    >Category Name</label
                  >
                  <b-form-input
                    id="example-input-1"
                    name="example-input-1"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    placeholder="Category"
                    v-model="$v.form.category.$model"
                    :state="validateState('category')"
                    aria-describedby="input-1-live-feedback"
                  ></b-form-input>

                  <b-form-invalid-feedback id="input-1-live-feedback"
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
  name: "AddQuestionCategory",
  mixins: [validationMixin],
  props: {
    formtype: {
      type: String,
      default: "add",
    },
    formlabel: {
      type: String,
      default: "Add Question Category",
    },
  },
  data() {
    return {
      form: {
        category: null,
      },
    };
  },
  validations: {
    form: {
      category: {
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
        category: null,
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
        this.addQuestionCategory();
      } else {
        this.editQuestionCategory();
      }
    },
    async addQuestionCategory() {
      try {
        const response = await axios.post("question/categories", {
          ...this.form,
        });

        this.$router.push("/admin/question/categories");
      } catch (error) {
        notify.authError(error);
      }
    },
    async editQuestionCategory() {
      try {
        const id = this.$route.params.id;
        const response = await axios.put(`question/categories/${id}`, {
          ...this.form,
        });

        this.$router.push("/admin/question/categories");
      } catch (error) {
        notify.authError(error);
      }
    },
    async getData(id) {
      try {
        const response = await axios.get(`question/categories/${id}`);
        return response;
      } catch (error) {
        notify.authError(error);
      }
    },
  },
};
</script>