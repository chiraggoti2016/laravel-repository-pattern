<template>
  <customer-form formlabel="Add Customer" formtype="add"></customer-form>
</template>

<script>
import CustomerForm from "./form.vue";
export default {
  name: "AddCustomer",
  components: {
    CustomerForm,
  },
};
</script>