<template>
  <question-category-form
    formlabel="Edit Question Category"
    formtype="edit"
  ></question-category-form>
</template>

<script>
import QuestionCategoryForm from "./form.vue";
export default {
  name: "Editquestion-category",
  components: {
    QuestionCategoryForm,
  },
};
</script>