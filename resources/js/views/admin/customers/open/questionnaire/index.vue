<template>
  <div>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row">
          <div class="col-md-9 d-flex justify-content-start align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
              Pre-Engagement Questionnaire
            </h6>
          </div>
          <div class="col-md-3 d-flex justify-content-end align-items-center">
            <a href="#" class="btn btn-sm btn-secondary btn-icon-split">
              <span class="icon text-white-50">
                <i class="fas fa-paper-plane-top"></i>
              </span>
              <span class="text">Send</span>
            </a>
            <a
              href="#"
              class="btn btn-sm btn-primary btn-icon-split ml-2"
              @click="onSubmit()"
            >
              <span class="icon text-white-50">
                <i class="fas fa-save"></i>
              </span>
              <span class="text">Submit</span>
            </a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <b-card
            sub-title="Email To (select client name to send)"
            class="form-list"
            body-class="require-h6"
            :class="
              $v.form.emailTo.$dirty && !$v.form.emailTo.required
                ? $v.form.emailTo.$invalid
                  ? 'is-invalid'
                  : 'is-valid'
                : ''
            "
          >
            <b-card-text>
              <b-form-radio-group
                v-model="$v.form.emailTo.$model"
                :options="project.participants"
                class="mb-3"
                value-field="id"
                text-field="name"
                :state="validateState('emailTo')"
                aria-describedby="emailTo-live-feedback"
              ></b-form-radio-group>

              <div class="invalid-feedback" v-if="!$v.form.emailTo.required">
                This is a required field.
              </div>
            </b-card-text>
          </b-card>
        </div>
        <div class="table-responsive">
          <b-card
            :header="category.toUpperCase()"
            class="form-list"
            v-for="(questions, category) in questionsbycategory"
            :key="category"
          >
            <b-form-group
              :label="index + 1 + '. ' + question.question"
              v-slot="{ questionsLiveFeedback }"
              v-for="(question, index) in questions"
              :key="index"
            >
              <b-form-radio-group
                v-model="form.questions"
                :options="[
                  { name: 'Yes', id: 'yes' },
                  { name: 'No', id: 'no' },
                ]"
                class="mb-3"
                value-field="id"
                text-field="name"
                :state="validateState('questions')"
                :aria-describedby="questionsLiveFeedback"
              ></b-form-radio-group>

              <div class="invalid-feedback" v-if="!$v.form.emailTo.required">
                This is a required field.
              </div>
            </b-form-group>
          </b-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import * as notify from "../../../../../utils/notify.js";
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";
import { getQuestionsListByCategory } from "../../../../../services/questions";

export default {
  name: "CustomersProjectQuestionare",
  mixins: [validationMixin],
  data() {
    return {
      form: {
        name: null,
        emailTo: [],
        questions: {},
      },
      project: {
        name: null,
        startdate: null,
        enddate: null,
        status: null,
        scope: null,
        participants: [],
        stages: [],
      },
      questionsbycategory: {},
    };
  },
  validations: {
    form: {
      name: {
        required,
      },
      emailTo: {
        required,
      },
      questions: {},
    },
  },
  async mounted() {
    const { data } = await this.getData(this.getParam());
    this.project = {
      ...data,
    };
    await this.getQuestionsListByCategory(this.project.scope);
  },
  methods: {
    async getQuestionsListByCategory(scope) {
      const { data } = await getQuestionsListByCategory(scope);
      this.questionsbycategory = { ...data };
    },
    getParam() {
      return this.$route.params;
    },
    validateState(name) {
      const { $dirty, $error } = this.$v.form[name];
      return $dirty ? !$error : null;
    },
    resetForm() {
      this.form = {
        name: null,
        startdate: null,
        enddate: null,
        participants: [],
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

      this.saveProject();
    },
    async saveProject() {
      try {
        const params = this.$route.params;
        const { id, projectid } = params;
        const response = await axios.put(`projects/${id}`, {
          ...this.form,
        });

        this.$router.push(`/admin/customers/open/project/${id}/${projectid}`);
      } catch (error) {
        notify.authError(error);
      }
    },

    async getData(params) {
      try {
        const response = await axios.get(`projects/${params.projectid}`);
        return response;
      } catch (error) {
        notify.authError(error);
      }
    },
  },
  components: {},
};
</script>