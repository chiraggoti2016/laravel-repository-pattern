<template>
  <customer-form formlabel="Edit Customer" formtype="edit"></customer-form>
</template>

<script>
import CustomerForm from "./form.vue";
export default {
  name: "EditCustomer",
  components: {
    CustomerForm,
  },
};
</script>