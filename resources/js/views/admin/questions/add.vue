<template>
  <question-form formlabel="Add Question" formtype="add"></question-form>
</template>

<script>
import QuestionForm from "./form.vue";
export default {
  name: "Addquestion",
  components: {
    QuestionForm,
  },
};
</script>