<template>
  <span>
    <button
      v-if="!meta.prefixLink"
      :class="classes"
      class="btn btn-icon-split"
      type="button"
      @click="$emit('click', data)"
    >
      <span :v-if="meta.icon.has" class="icon text-white-50">
        <i class="fas" :class="meta.icon.classes"></i>
      </span>
      <span v-if="!onlyicon" class="text">{{ name }}</span>
    </button>
    <router-link
      v-if="meta.prefixLink"
      :class="classes"
      class="btn btn-icon-split"
      :to="meta.prefixLink ? meta.prefixLink + (data.id ? data.id : '') : '#'"
      title="name"
    >
      <slot></slot>
      <span :v-if="meta.icon.has" class="icon text-white-50">
        <i class="fas" :class="meta.icon.classes"></i>
      </span>
      <span v-if="!onlyicon" class="text">{{ name }}</span>
    </router-link>
  </span>
</template>
<script>
export default {
  props: {
    data: {},
    name: {},
    onlyicon: {
      type: Boolean,
      default: false,
    },
    click: {
      type: Function,
      default: () => {},
    },
    classes: {
      type: Object,
      default: () => ({
        btn: true,
        "btn-warning": true,
        "btn-sm": true,
      }),
    },
    meta: {
      type: Object,
      default: () => ({
        prefixLink: null,
        icon: {
          has: false,
          classes: null,
        },
      }),
    },
  },
};
</script>