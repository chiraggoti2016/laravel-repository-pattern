<template>
  <country-form formlabel="Add Country" formtype="add"></country-form>
</template>

<script>
import CountryForm from "./form.vue";
export default {
  name: "Addcountry",
  components: {
    CountryForm,
  },
};
</script>