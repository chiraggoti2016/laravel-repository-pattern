<template>
  <b-card header="Form Fields" class="mb-2">
    <b-row v-if="question.fields.length > 0">
      <b-col
        cols="3"
        :id="'input-group-input-' + index + '-field' + fieldIndex"
        v-for="(field, fieldIndex) in question.fields"
        :key="fieldIndex"
      >
        <b-form-group>
          <label
            :class="field.isOptional === 'no' ? 'require' : ''"
            :for="'input-' + index + '-field' + fieldIndex"
            >{{ field.input }}</label
          >

          <!-- Input -->
          <b-form-input
            v-if="optionsRequireInput.indexOf(field.type) == -1"
            :type="field.type"
            :id="'input-' + index + '-field' + fieldIndex"
            :name="'input-' + index + '-field' + fieldIndex"
            class="mb-2 mr-sm-2 mb-sm-0"
            :placeholder="field.input"
            v-model="$v.form.fields.$each[fieldIndex].input.$model"
            :state="validateEachState('fields', fieldIndex, 'input')"
            :aria-describedby="
              'input-' + index + '-field' + fieldIndex + '-live-feedback'
            "
          ></b-form-input>

          <b-form-select
            v-if="inputSelect === field.type"
            :id="'input-' + index + '-field' + fieldIndex"
            :name="'input-' + index + '-field' + fieldIndex"
            class="mb-2 mr-sm-2 mb-sm-0"
            :options="field.options"
            v-model="$v.form.fields.$each[fieldIndex].input.$model"
            :state="validateEachState('fields', fieldIndex, 'input')"
            :aria-describedby="
              'input-' + index + '-field' + fieldIndex + '-live-feedback'
            "
          >
            <template #first>
              <b-form-select-option :value="null" disabled>{{
                field.input
              }}</b-form-select-option>
            </template>
          </b-form-select>

          <!-- radio -->
          <b-form-radio-group
            v-if="inputRadio === field.type"
            :id="'input-' + index + '-field' + fieldIndex"
            :name="'input-' + index + '-field' + fieldIndex"
            class="mb-2 mr-sm-2 mb-sm-0"
            :options="field.options"
            v-model="$v.form.fields.$each[fieldIndex].input.$model"
            :state="validateEachState('fields', fieldIndex, 'input')"
            :aria-describedby="
              'input-' + index + '-field' + fieldIndex + '-live-feedback'
            "
          ></b-form-radio-group>

          <!-- checkbox -->
          <b-form-checkbox-group
            v-if="inputCheckbox === field.type"
            :id="'input-' + index + '-field' + fieldIndex"
            :name="'input-' + index + '-field' + fieldIndex"
            class="mb-2 mr-sm-2 mb-sm-0"
            :options="field.options"
            v-model="$v.form.fields.$each[fieldIndex].input.$model"
            :state="validateEachState('fields', fieldIndex, 'input')"
            :aria-describedby="
              'input-' + index + '-field' + fieldIndex + '-live-feedback'
            "
          ></b-form-checkbox-group>

          <b-form-invalid-feedback
            id="'input-'+index+'-field' + fieldIndex + '-live-feedback'"
            >This is a required field.</b-form-invalid-feedback
          >
        </b-form-group>
      </b-col>
    </b-row>
  </b-card>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, requiredIf } from "vuelidate/lib/validators";
import {
  INPUT_CHECKBOX,
  INPUT_RADIO,
  INPUT_SELECT,
  OPTIONS_REQUIRE_INPUT,
} from "../../../../../mixins/constants";

export default {
  name: "CustomersProjectQuestionareForm",
  mixins: [validationMixin],
  props: ["value", "question", "category", "index", "state"],
  computed: {
    inputVal: {
      get() {
        return this.value;
      },
      set(val) {
        this.$emit("input", val);
      },
    },
  },
  data() {
    return {
      optionsRequireInput: OPTIONS_REQUIRE_INPUT,
      inputSelect: INPUT_SELECT,
      inputRadio: INPUT_RADIO,
      inputCheckbox: INPUT_CHECKBOX,
      form: {
        fields: this.question.fields
          ? this.question.fields.map((field, fieldIndex) => ({
              input:
                this.question.questionaire_question &&
                this.question.questionaire_question.input[fieldIndex] !==
                  undefined
                  ? this.question.questionaire_question.input[fieldIndex].input
                  : null,
              field,
            }))
          : [],
      },
    };
  },
  validations() {
    return {
      form: {
        fields: {
          $each: {
            input: {
              // required,
              required: requiredIf(function (nestedModel) {
                return nestedModel.field.isOptional === "no";
              }),
            },
          },
        },
      },
    };
  },

  methods: {
    validateEachState(name, index, each) {
      const { $dirty, $error } = this.$v.form[name].$each[index][each];
      this.$emit(
        "update",
        this.form.fields.map((field) => ({ input: field.input }))
      );
      return $dirty ? !$error : null;
    },
    resetForm() {
      this.form = {
        fields: [{ input: null }],
      };

      this.$nextTick(() => {
        this.$v.$reset();
      });
    },
    onSubmit() {
      this.$v.form.$touch();
      if (this.$v.form.$anyError) {
        return false;
      }
      return true;
    },
  },
};
</script>