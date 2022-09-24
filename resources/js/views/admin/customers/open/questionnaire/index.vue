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
          <div
            class="col-md-3 d-flex justify-content-end align-items-center"
            v-if="isProjectQuestionaireSend"
          >
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
        <div class="table-responsive" v-if="isProjectQuestionaireSend">
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
              <b-form-group v-slot="{ ariaemailToDescribedby }">
                <b-form-checkbox-group
                  v-model="$v.form.emailTo.$model"
                  :options="project.participants"
                  :aria-describedby="ariaemailToDescribedby"
                  name="emailTo"
                  value-field="id"
                  text-field="name"
                  :state="validateState('emailTo')"
                  class="mb-3"
                ></b-form-checkbox-group>
              </b-form-group>

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
              v-slot="{ questionsLiveFeedback }"
              v-for="(question, index) in questions"
              :key="index"
            >
              <label
                >{{ index + 1 + ". " + question.question }}
                <i
                  v-if="question.information !== ''"
                  class="fas fa-info-circle"
                  v-b-popover.hover.top="question.information"
                ></i
              ></label>
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
                    >{{
                      index + 1 + "." + 1 + ". " + question.sub_question
                    }}</label
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
              <b-input-group
                v-if="question.response_collector === 'Ticker'"
                class="mt-3 w-15 ticker"
              >
                <b-input-group-prepend>
                  <b-button
                    variant="outline-info"
                    class="btn-sm"
                    @click="
                      $v.form.questions[category].$each[index].input.$model =
                        parseFloat(
                          $v.form.questions[category].$each[index].input.$model
                        ) - 1
                    "
                  >
                    <span class="icon">
                      <i class="fas fa-minus"></i>
                    </span>
                  </b-button>
                </b-input-group-prepend>

                <b-form-input
                  :id="'modal-name-input' + index"
                  :name="'modal-name-input' + index"
                  class="mb-2 mb-sm-0"
                  v-model="
                    $v.form.questions[category].$each[index].input.$model
                  "
                  :state="
                    validateEachState('questions', category, index, 'input')
                  "
                  :aria-describedby="'modal-input-' + index + '-live-feedback'"
                  size="sm"
                  type="number"
                ></b-form-input>

                <b-input-group-append>
                  <b-button
                    variant="outline-secondary"
                    class="btn-sm"
                    @click="
                      $v.form.questions[category].$each[index].input.$model =
                        parseFloat(
                          $v.form.questions[category].$each[index].input.$model
                        ) + 1
                    "
                  >
                    <span class="icon">
                      <i class="fas fa-plus"></i>
                    </span>
                  </b-button>
                </b-input-group-append>
              </b-input-group>

              <!-- Form -->
              <div v-if="question.response_collector === 'Form'">
                <q-form
                  :ref="'qform'"
                  :key="index"
                  @update="
                    $v.form.questions[category].$each[index].input.$model =
                      $event
                  "
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
              <div v-if="question.response_collector === 'Upload'">
                <b-form-file
                  :state="
                    validateEachState('questions', category, index, 'input')
                  "
                  @change="
                    onChangeUploadEachState(
                      $event,
                      'questions',
                      category,
                      index,
                      'input'
                    )
                  "
                  :no-traverse="true"
                  placeholder="Choose a file or drop it here..."
                  drop-placeholder="Drop file here..."
                  :aria-describedby="questionsLiveFeedback"
                ></b-form-file>

                <div
                  v-if="
                    $v.form.questions[category].$each[index].input.$model !==
                      null ||
                    $v.form.questions[category].$each[index].input.$model !==
                      undefined ||
                    $v.form.questions[category].$each[index].input.$model !==
                      {} ||
                    $v.form.questions[category].$each[index].input.$model
                      .length !== []
                  "
                >
                  <b-img
                    v-if="
                      $v.form.questions[category].$each[index].input.$model
                        .type !== undefined &&
                      $v.form.questions[category].$each[
                        index
                      ].input.$model.type.match(/image/) !== ''
                    "
                    :src="
                      $v.form.questions[category].$each[index].input.$model
                        ? $v.form.questions[category].$each[index].input.$model
                            .file_url
                        : ''
                    "
                    fluid
                    alt="Responsive image"
                  ></b-img>
                </div>
              </div>

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
import { uploadFile } from "../../../../../services/upload";
import { YESNO_OPTION } from "../../../../../mixins/constants.js";
import QForm from "./form.vue";

export default {
  name: "CustomersProjectQuestionare",
  mixins: [validationMixin],
  data() {
    return {
      parentData: null,
      yesNoOptions: YESNO_OPTION,
      form: {
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

    this.form.emailTo =
      data.questionaire !== null && data.questionaire.users !== undefined
        ? data.questionaire.users.map((user) => user.id)
        : [];

    await this.getQuestionsListByCategory(this.project.scope, params);
  },
  computed: {
    isProjectQuestionaireSend() {
      return (
        this.project?.questionaire === null ||
        (this.project.questionaire !== null &&
          this.project.questionaire?.status !== "send")
      );
    },
  },
  methods: {
    async getQuestionsListByCategory(scope, params) {
      const { data } = await getQuestionsListByCategory(scope, {
        id: params.id,
        project_id: params.projectid,
      });

      const temp = {};
      for (const [key, value] of Object.entries(data)) {
        temp[key] = value
          ? value.map((v) => ({
              input: v.questionaire_question
                ? v.questionaire_question.input
                : v.response_collector == "YesNo"
                ? "no"
                : v.response_collector == "Upload"
                ? null
                : v.response_collector == "Ticker"
                ? 0
                : "",
              depend: v.questionaire_question
                ? v.questionaire_question.depend
                : null,
              question_id: v.id,
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
    async onChangeUploadEachState($event, name, category, index, each) {
      const { $model } = this.$v.form[name][category].$each[index][each];
      const { target } = $event;
      const fileList = target.files;
      const formData = new FormData();
      if (!fileList.length) return;

      Array.from(Array(fileList.length).keys()).map((x) => {
        formData.append("file", fileList[x], fileList[x].name);
      });

      const response = await uploadFile(formData);
      const { data } = response;
      console.log("response---", $model, data);
      this.form[name][category][index][each] = data; //data.file;
    },
    resetForm() {
      this.form = {
        emailTo: null,
        questions: [],
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
      this.saveProject(true);
      let message = "data has been save as draft successfully.";

      Vue.toasted.show(message, {
        theme: "toasted-primary",
        position: "top-right",
        duration: 5000,
      });
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
    async saveProject(draft = false) {
      try {
        const params = this.$route.params;
        const { id, projectid } = params;
        const response = await axios.post(`questionaires/send/${projectid}`, {
          ...this.form,
          status: draft ? "draft" : "send",
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