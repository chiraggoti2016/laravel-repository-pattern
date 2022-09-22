<template>
    <span>
        <a href="#" :class="classes" class="btn btn-icon-split" v-b-modal.modal-prevent-closing >
            <span class="icon text-white-50"> <i class="fas" :class="meta.icon.classes"></i> </span> <span class="text">Edit</span>
        </a>
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
            }),
        },
    },
};
</script>