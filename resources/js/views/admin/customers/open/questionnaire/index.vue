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
            <a
              href="#"
              class="btn btn-sm btn-primary btn-icon-split"
              @click="onSubmit()"
            >
              <span class="icon text-white-50">
                <i class="fas fa-arrow-right"></i>
              </span>
              <span class="text">Send</span>
            </a>
            <a
              href="#"
              class="btn btn-sm btn-secondary btn-icon-split ml-2"
              @click="onSaveDraft()"
            >
              <span class="icon text-white-50">
                <i class="fas fa-save"></i>
              </span>
              <span class="text">Save As Draft</span>
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
              <!-- FreeText -->
              <b-form-input
                v-if="question.response_collector === 'FreeText'"
                :id="'modal-name-input' + index"
                :name="'modal-name-input' + index"
                class="mb-2 mr-sm-2 mb-sm-0"
                placeholder="Enter Input"
                v-model="$v.form.questions[category].$each[index].input.$model"
                :state="
                  validateEachState('questions', category, index, 'input')
                "
                :aria-describedby="'modal-input-' + index + '-live-feedback'"
                size="sm"
              ></b-form-input>

              <!-- YesNo -->
              <div v-if="question.response_collector === 'YesNo'">
                <b-form-radio-group
                  v-model="
                    $v.form.questions[category].$each[index].input.$model
                  "
                  :options="yesNoOptions"
                  class="mb-3"
                  value-field="id"
                  text-field="name"
                  :state="
                    validateEachState('questions', category, index, 'input')
                  "
                  :aria-describedby="questionsLiveFeedback"
                ></b-form-radio-group>

                <b-form-group
                  v-if="
                    $v.form.questions[category].$each[index].input.$model ===
                    'yes'
                  "
                  :id="'modal-name-input-question-group-' + index"
                >
                  <label
                    class="require"
                    :for="'modal-name-input-question-' + index"
                    >{{ index + 1 + "." + 1 + ". " + question.question }}</label
                  >
                  <b-form-input
                    :id="'modal-name-input-question-' + index"
                    :name="'modal-name-input-question-' + index"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    placeholder="If yes then ...."
                    v-model="
                      $v.form.questions[category].$each[index].depend.$model
                    "
                    :state="
                      validateEachState('questions', category, index, 'depend')
                    "
                    :aria-describedby="
                      'modal-input-' + index + '-live-feedback'
                    "
                    size="sm"
                  ></b-form-input>
                </b-form-group>
              </div>

              <!-- Ticker -->
              <div v-if="question.response_collector === 'Ticker'">Ticker</div>

              <!-- Form -->
              <div v-if="question.response_collector === 'Form'">
                <q-form
                  :ref="'qform'"
                  :key="index"
                  v-model="
                    $v.form.questions[category].$each[index].input.$model
                  "
                  :index="index"
                  :question="question"
                  :category="category"
                  :state="
                    validateEachState('questions', category, index, 'input')
                  "
                />
              </div>

              <!-- Upload -->
              <b-form-file
                v-if="question.response_collector === 'Upload'"
                v-model="$v.form.questions[category].$each[index].input.$model"
                :state="
                  validateEachState('questions', category, index, 'input')
                "
                placeholder="Choose a file or drop it here..."
                drop-placeholder="Drop file here..."
                :aria-describedby="questionsLiveFeedback"
              ></b-form-file>

              <b-form-invalid-feedback
                v-if="!$v.form.questions[category].$each[index].input.required"
                >input is required</b-form-invalid-feedback
              >
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
import { required, requiredIf } from "vuelidate/lib/validators";
import { getQuestionsListByCategory } from "../../../../../services/questions";
import { YESNO_OPTION } from "../../../../../mixins/constants.js";
import QForm from "./form.vue";

export default {
  name: "CustomersProjectQuestionare",
  mixins: [validationMixin],
  data() {
    return {
      yesNoOptions: YESNO_OPTION,
      form: {
        name: null,
        emailTo: [],
        questions: [],
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
  validations() {
    return {
      form: {
        name: {
          required,
        },
        emailTo: {
          required,
        },
        questions:
          this.questionsbycategory !== undefined &&
          Object.keys(this.questionsbycategory).length > 0
            ? Object.entries(this.questionsbycategory).reduce(function (
                obj,
                each
              ) {
                return {
                  ...obj,
                  [each[0]]: {
                    $each: {
                      input: {
                        required,
                      },
                      depend: {
                        required: requiredIf((value) => value.input === "yes"),
                      },
                    },
                  },
                };
              },
              {})
            : { required },
      },
    };
  },
  async mounted() {
    const params = this.getParam();
    const { data } = await this.getData(params);
    const { id, projectid } = params;

    this.project = {
      ...data,
    };
    const formJsonString = localStorage.getItem(
      "questionnaire-" + id + "-" + projectid
    );
    const form = formJsonString !== "" ? JSON.parse(formJsonString) : this.form;

    this.form = { ...form };

    await this.getQuestionsListByCategory(this.project.scope);
  },
  methods: {
    async getQuestionsListByCategory(scope) {
      const { data } = await getQuestionsListByCategory(scope);

      const temp = {};
      for (const [key, value] of Object.entries(data)) {
        temp[key] = value
          ? value.map((v) => ({
              input: v.response_collector == "YesNo" ? "no" : "",
              depend: "",
            }))
          : [];
      }

      this.questionsbycategory = { ...data };
      this.form.questions = { ...temp };
    },
    getParam() {
      return this.$route.params;
    },
    validateState(name) {
      const { $dirty, $error } = this.$v.form[name];
      return $dirty ? !$error : null;
    },
    validateEachState(name, category, index, each) {
      const { $dirty, $error } =
        this.$v.form[name][category].$each[index][each];
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
    onSaveDraft() {
      const params = this.$route.params;
      const { id, projectid } = params;
      const data = {
        ...this.form,
      };
      localStorage.setItem(
        "questionnaire-" + id + "-" + projectid,
        JSON.stringify(data)
      );
    },
    onSubmit() {
      this.$v.form.$touch();

      if (
        this.$refs.qform &&
        !this.$refs.qform.every((each) => {
          return each.onSubmit();
        })
      ) {
        return;
      }

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
  components: {
    QForm,
  },
};
</script>