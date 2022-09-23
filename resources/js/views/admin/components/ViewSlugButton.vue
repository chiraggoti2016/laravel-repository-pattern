<template>
  <span>
    <button
      v-if="disabled || !meta.prefixLink"
      :class="classes"
      class="btn btn-icon-split"
      type="button"
      @click="$emit('click', data)"
      :disabled="disabled"
    >
      <span :v-if="meta.icon.has" class="icon text-white-50">
        <i class="fas" :class="meta.icon.classes"></i>
      </span>
      <span v-if="!meta.onlyicon" class="text">{{ name }}</span>
    </button>
    <router-link
      v-else
      :class="classes"
      class="btn btn-icon-split"
      :to="
        meta.prefixLink ? meta.prefixLink + (data.slug ? data.slug : '') : '#'
      "
      title="name"
      :disabled="disabled"
    >
      <slot></slot>
      <span :v-if="meta.icon.has" class="icon text-white-50">
        <i class="fas" :class="meta.icon.classes"></i>
      </span>
      <span v-if="!meta.onlyicon" class="text">{{ name }}</span>
    </router-link>
  </span>
</template>
<script>
export default {
  props: {
    data: {},
    name: {},
    disabled: {
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
        onlyicon: false,
      }),
    },
  },
};
</script>