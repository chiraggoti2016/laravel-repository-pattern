<template>
  <div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <b-card title="Coming Soon">
      <b-card-text> Dashboard development is in-progress stage. </b-card-text>
    </b-card>
  </div>
</template>

<script>
import chartAreaDemo from "../../chart/demo/chart-area-demo";
import chartPieDemo from "../../chart/demo/chart-pie-demo";

export default {
  name: "Dashboard",
  mounted() {
    chartAreaDemo();
    chartPieDemo();
  },
};
</script>
