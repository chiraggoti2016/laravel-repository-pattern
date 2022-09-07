<template>
  <ul
    class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
    id="accordionSidebar"
  >
    <!-- Sidebar - Brand -->
    <router-link
      class="sidebar-brand d-flex align-items-center justify-content-center"
      to="/"
    >
      <!-- <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div> -->
      <div class="sidebar-brand-text mx-3">
        <img src="/images/logo.svg" />
      </div>
    </router-link>

    <!-- Divider -->
    <hr class="sidebar-divider my-0" />

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <router-link class="nav-link" to="/admin">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></router-link
      >
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <!-- Heading -->
    <div class="sidebar-heading">Lists</div>

    <!-- Nav Item - Tables -->
    <li class="nav-item" v-if="isAdmin()">
      <router-link class="nav-link" to="/admin/partners">
        <i class="fas fa-fw fa-table"></i>
        <span>Partners</span></router-link
      >
    </li>
    <li class="nav-item" v-if="isAdmin()">
      <router-link class="nav-link" to="/admin/countries">
        <i class="fas fa-fw fa-table"></i>
        <span>Countries</span></router-link
      >
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item" v-if="isPartner()">
      <router-link class="nav-link" to="/admin/customers">
        <i class="fas fa-fw fa-table"></i>
        <span>Customers</span></router-link
      >
    </li>

    <div class="sidebar-heading">Lists</div>
    <li class="nav-item">
        <router-link class="nav-link" to="/admin/projects">
            <i class="fas fa-fw fa-table"></i> <span>Projects</span>
        </router-link>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block" />

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
  </ul>
  <!-- End of Sidebar -->
</template>

<script>
export default {
  name: "Sidebar",
};
</script>
