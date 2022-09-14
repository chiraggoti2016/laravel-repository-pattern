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
            class="require"
            :for="'input-' + index + '-field' + fieldIndex"
            >{{ field.input }}</label
          >

          <b-form-input
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
import { required } from "vuelidate/lib/validators";

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
      form: {
        fields: this.question.fields
          ? this.question.fields.map((field) => ({ input: null }))
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
              required,
            },
          },
        },
      },
    };
  },

  methods: {
    validateEachState(name, index, each) {
      const { $dirty, $error } = this.$v.form[name].$each[index][each];
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