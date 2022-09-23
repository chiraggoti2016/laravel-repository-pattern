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
                  <label class="require" for="input-question">Question</label>
                  <b-form-input
                    id="input-question"
                    name="input-question"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    placeholder="Question"
                    v-model="$v.form.question.$model"
                    :state="validateState('question')"
                    aria-describedby="question-live-feedback"
                  ></b-form-input>

                  <b-form-invalid-feedback id="question-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
            </b-row>
            <b-row>
              <b-col>
                <b-form-group id="example-input-group-3">
                  <label class="require" for="example-input-3"
                    >Information</label
                  >
                  <b-form-input
                    id="example-input-3"
                    name="example-input-3"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    placeholder="Information"
                    v-model="$v.form.information.$model"
                    :state="validateState('information')"
                    aria-describedby="input-3-live-feedback"
                  ></b-form-input>

                  <b-form-invalid-feedback id="input-3-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
            </b-row>
            <b-row>
              <b-col>
                <b-form-group id="example-input-group-4">
                  <label class="require" for="example-input-4"
                    >Response Collector</label
                  >
                  <b-form-select
                    id="example-input-4"
                    name="example-input-4"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    v-model="$v.form.response_collector.$model"
                    :options="responseCollectorOptions"
                    :state="validateState('response_collector')"
                    aria-describedby="input-4-live-feedback"
                  >
                    <template #first>
                      <b-form-select-option :value="null" disabled
                        >Select Response Collector</b-form-select-option
                      >
                    </template>
                  </b-form-select>

                  <b-form-invalid-feedback id="input-4-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
              <b-col>
                <b-form-group id="example-input-group-5">
                  <label class="require" for="example-input-5">Scope</label>
                  <b-form-select
                    id="example-input-3"
                    name="example-input-3"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    v-model="$v.form.scope.$model"
                    :options="scopesOptions"
                    :state="validateState('scope')"
                    aria-describedby="input-5-live-feedback"
                  >
                    <template #first>
                      <b-form-select-option :value="null" disabled
                        >Select Scope</b-form-select-option
                      >
                    </template>
                  </b-form-select>

                  <b-form-invalid-feedback id="input-5-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
              <b-col>
                <b-form-group id="example-input-group-6">
                  <label class="require" for="example-input-6">Category</label>
                  <b-form-select
                    id="example-input-6"
                    name="example-input-6"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    v-model="$v.form.category.$model"
                    :options="questionCategoriesOptions"
                    :state="validateState('category')"
                    aria-describedby="input-6-live-feedback"
                  >
                    <template #first>
                      <b-form-select-option :value="null" disabled
                        >Select Category</b-form-select-option
                      >
                    </template>
                  </b-form-select>

                  <b-form-invalid-feedback id="input-6-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
            </b-row>
            <!-- YesNo -->
            <b-row v-if="form.response_collector === 'YesNo'">
              <b-col>
                <b-form-group id="example-input-group-2">
                  <label for="example-input-2">Sub Question</label>
                  <b-form-input
                    id="example-input-2"
                    name="example-input-2"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    placeholder="Sub Question"
                    v-model="$v.form.sub_question.$model"
                    :state="validateState('sub_question')"
                    aria-describedby="input-2-live-feedback"
                  ></b-form-input>

                  <b-form-invalid-feedback id="input-2-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
            </b-row>
            <!-- Form -->
            <b-row v-if="form.response_collector === 'Form'">
              <div class="table-responsive">
                <b-card
                  sub-title="Form Fields"
                  class="form-list"
                  :class="
                    $v.form.fields.$dirty
                      ? $v.form.fields.$invalid
                        ? 'is-invalid'
                        : 'is-valid'
                      : ''
                  "
                >
                  <b-card-text>
                    <b-table
                      responsive="sm"
                      borderless
                      small
                      :items="form.fields"
                      :fields="formFields"
                    >
                      <!-- email_verified_at -->
                      <template #cell(input)="data">
                        <b-form-input
                          :id="'modal-name-input' + data.index"
                          :name="'modal-name-input' + data.index"
                          class="mb-2 mr-sm-2 mb-sm-0"
                          placeholder="Enter Input"
                          v-model="data.item.input"
                          :state="
                            validateEachState('fields', data.index, 'input')
                          "
                          aria-describedby="modal-input-1-live-feedback"
                          size="sm"
                        ></b-form-input>

                        <b-form-invalid-feedback
                          v-if="
                            !$v.form.fields.$each[data.index].input.required
                          "
                          >input is required</b-form-invalid-feedback
                        >
                      </template>

                      <template #cell(type)="data">
                        <b-form-select
                          :id="'input-type' + data.index"
                          :name="'input-type' + data.index"
                          class="mb-2 mr-sm-2 mb-sm-0"
                          v-model="data.item.type"
                          :options="typeOptions"
                          :state="
                            validateEachState('fields', data.index, 'type')
                          "
                          aria-describedby="input-3-live-feedback"
                          size="sm"
                        >
                          <template #first>
                            <b-form-select-option :value="null" disabled
                              >Select Type</b-form-select-option
                            >
                          </template>
                        </b-form-select>
                        <b-form-invalid-feedback
                          v-if="!$v.form.fields.$each[data.index].type.required"
                          >type is required</b-form-invalid-feedback
                        >
                      </template>

                      <!-- options -->
                      <template #cell(options)="data">
                        <b-form-tags
                          class="mb-2 mr-sm-2 mb-sm-0"
                          :id="'input-options' + data.index"
                          :name="'input-options' + data.index"
                          :input-id="'input-options' + data.index"
                          v-model="data.item.options"
                          :state="
                            validateEachState('fields', data.index, 'options')
                          "
                          :tag-validator="tagValidator"
                          :input-attrs="{
                            'aria-describedby': 'tags-validation-help',
                          }"
                          separator=" "
                          aria-describedby="input-options-live-feedback"
                          size="sm"
                          :disabled="
                            optionsRequireInput.indexOf(data.item.type) === -1
                          "
                        ></b-form-tags>
                        <b-form-invalid-feedback
                          v-if="
                            !$v.form.fields.$each[data.index].options.required
                          "
                          >options is required</b-form-invalid-feedback
                        >
                      </template>

                      <!-- isOptional -->
                      <template #cell(isOptional)="data">
                        <b-form-select
                          :id="'input-isOptional' + data.index"
                          :name="'input-isOptional' + data.index"
                          class="mb-2 mr-sm-2 mb-sm-0"
                          v-model="data.item.isOptional"
                          :options="yesNoOptions"
                          value-field="id"
                          text-field="name"
                          :state="
                            validateEachState(
                              'fields',
                              data.index,
                              'isOptional'
                            )
                          "
                          aria-describedby="input-3-live-feedback"
                          size="sm"
                        >
                          <template #first>
                            <b-form-select-option :value="null" disabled
                              >Select Type</b-form-select-option
                            >
                          </template>
                        </b-form-select>
                        <b-form-invalid-feedback
                          v-if="
                            !$v.form.fields.$each[data.index].isOptional
                              .required
                          "
                          >is optional is required</b-form-invalid-feedback
                        >
                      </template>

                      <template #cell(actions)="data">
                        <action-button
                          :data="data"
                          :meta="addActionButton.meta"
                          :classes="addActionButton.classes"
                          name="Add"
                          @click="addActionButtonClick"
                        ></action-button>

                        <action-button
                          v-if="data.index > 0"
                          :data="data"
                          :meta="deleteActionButton.meta"
                          :classes="deleteActionButton.classes"
                          name="Delete"
                          @click="deleteActionButtonClick"
                        ></action-button>
                      </template>
                    </b-table>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.form.fields.$invalid"
                    >
                      Please add at least one field.
                    </div>
                  </b-card-text>
                </b-card>
              </div>
            </b-row>
          </b-form>
        </b-container>
      </div>
    </div>
  </div>
</template>

<script>
import ActionButton from "./../components/ActionButton.vue";
import * as notify from "../../../utils/notify.js";
import { reactive, toRefs } from "vue";
import { validationMixin } from "vuelidate";
import {
  required,
  requiredIf,
  email,
  helpers,
  numeric,
} from "vuelidate/lib/validators";
import { getScopesBySlug } from "../../../services/scope";
import { getAllQuestionCategories } from "../../../services/question-categories";
import {
  INPUT_TYPE_OPTIONS,
  OPTIONS_REQUIRE_INPUT,
  RESPONSE_COLLECTOR_OPTIONS,
  YESNO_OPTION,
  RESPONSE_COLLECTOR_FORM,
} from "../../../mixins/constants";

export default {
  name: "AddQuestion",
  mixins: [validationMixin],
  props: {
    formtype: {
      type: String,
      default: "add",
    },
    formlabel: {
      type: String,
      default: "Add Question",
    },
  },
  data() {
    return {
      loading: false,
      busy: false,
      responseCollectorOptions: RESPONSE_COLLECTOR_OPTIONS,
      scopesOptions: [],
      questionCategoriesOptions: [],
      typeOptions: INPUT_TYPE_OPTIONS,
      yesNoOptions: YESNO_OPTION,
      optionsRequireInput: OPTIONS_REQUIRE_INPUT,
      formFields: [
        "input",
        "type",
        {
          key: "options",
          label: "Options",
          class: "w40p",
        },
        "isOptional",
        {
          key: "actions",
          label: "Actions",
          stickyColumn: true,
          class: "w20p",
        },
      ],
      form: {
        question: null,
        sub_question: null,
        information: null,
        response_collector: null,
        scope: null,
        category: null,
        fields: [{ input: null, type: null, isOptional: "no", options: [] }],
      },
      addActionButton: {
        meta: {
          icon: {
            has: true,
            classes: {
              "fa-plus": true,
            },
          },
        },
        classes: {
          btn: true,
          "btn-secondary": true,
          "btn-sm": true,
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
    };
  },
  validations: {
    form: {
      question: {
        required,
      },
      sub_question: {},
      information: {
        required,
      },
      response_collector: {
        required,
      },
      scope: {
        required,
      },
      category: {
        required,
      },
      fields: {
        $each: {
          input: {
            required: requiredIf(function () {
              return RESPONSE_COLLECTOR_FORM === this.form.response_collector;
            }),
          },
          type: {
            required: requiredIf(function () {
              return RESPONSE_COLLECTOR_FORM === this.form.response_collector;
            }),
          },
          isOptional: {
            required: requiredIf(function () {
              return RESPONSE_COLLECTOR_FORM === this.form.response_collector;
            }),
          },
          options: {
            required: requiredIf(function (nestedModel) {
              return OPTIONS_REQUIRE_INPUT.indexOf(nestedModel.type) != -1;
            }),
          },
        },
      },
    },
  },
  async mounted() {
    await this.getScopesBySlug();
    await this.getQuestionCategories();
    if (this.formtype === "edit") {
      const { data } = await this.getData(this.$route.params.id);
      this.form = {
        ...data,
      };
    }
  },
  methods: {
    async getScopesBySlug() {
      const { data } = await getScopesBySlug();
      this.scopesOptions = data
        ? Object.keys(data).map((each) => ({
            text: data[each].name,
            value: data[each].slug,
          }))
        : [];
    },
    async getQuestionCategories() {
      const { data } = await getAllQuestionCategories();
      this.questionCategoriesOptions = data
        ? data.map((each) => ({
            text: each.category,
            value: each.slug,
          }))
        : [];
    },
    validateState(name) {
      const { $dirty, $error } = this.$v.form[name];
      return $dirty ? !$error : null;
    },
    validateEachState(name, index, each) {
      const { $dirty, $error } = this.$v.form[name].$each[index][each];
      return $dirty ? !$error : null;
    },
    resetForm() {
      this.form = {
        question: null,
        sub_question: null,
        information: null,
        response_collector: null,
        scope: null,
        category: null,
        fields: [{ input: null, type: null, isOptional: "no", options: [] }],
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
        this.addQuestion();
      } else {
        this.editQuestion();
      }
    },
    async addQuestion() {
      try {
        const response = await axios.post("questions", {
          ...this.form,
        });
        this.loading = false;

        this.$router.push("/admin/questions");
      } catch (error) {
        notify.authError(error);
      }
    },
    async editQuestion() {
      try {
        const id = this.$route.params.id;
        const response = await axios.put(`questions/${id}`, {
          ...this.form,
        });
        this.loading = false;

        this.$router.push("/admin/questions");
      } catch (error) {
        notify.authError(error);
      }
    },
    validateModalState(name) {
      const { $dirty, $error } = this.$v.newuser[name];
      return $dirty ? !$error : null;
    },
    async getData(id) {
      try {
        const response = await axios.get(`questions/${id}`);
        return response;
      } catch (error) {
        notify.authError(error);
      }
    },
    deleteActionButtonClick(data) {
      if (data.index > -1) {
        this.form.fields.splice(data.index, 1);
      }
    },
    addActionButtonClick(data) {
      if (data.index > -1) {
        this.form.fields.splice(data.index + 1, 0, {
          input: null,
          type: null,
          isOptional: "no",
          options: [],
        });
      }
    },
    tagValidator(tag) {
      return tag === tag.toLowerCase() && tag.length > 1 && tag.length < 15;
    },
  },
  components: {
    ActionButton,
  },
};
</script>