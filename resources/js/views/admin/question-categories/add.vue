<template>
  <question-category-form
    formlabel="Add Question Category"
    formtype="add"
  ></question-category-form>
</template>

<script>
import QuestionCategoryForm from "./form.vue";
export default {
  name: "Addquestion-category",
  components: {
    QuestionCategoryForm,
  },
};
</script>