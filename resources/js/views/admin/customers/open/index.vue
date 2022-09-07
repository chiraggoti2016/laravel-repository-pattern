<template>
  <div>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row">
          <div class="col-md-9 d-flex justify-content-start align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">{{ pagelabel }}</h6>
          </div>
          <div class="col-md-3 d-flex justify-content-end align-items-center">
            <a
              href="#"
              class="btn btn-sm btn-primary btn-icon-split"
              @click="onSubmit()"
            >
              <span class="icon text-white-50">
                <i class="fas fa-save"></i>
              </span>
              <span class="text">Save</span>
            </a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <b-container class="bv-example-row">
          <b-form @submit.stop.prevent="onSubmit">
            <b-row>
              <b-col cols="5">
                <b-form-group id="example-input-group-1">
                  <label class="sr-only" for="example-input-1">Name</label>
                  <b-form-input
                    id="example-input-1"
                    name="example-input-1"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    placeholder="Project Name"
                    v-model="$v.form.name.$model"
                    :state="validateState('name')"
                    aria-describedby="input-1-live-feedback"
                  ></b-form-input>
                  <b-form-invalid-feedback id="input-1-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
              <b-col>
                <b-form-group id="example-input-group-2">
                  <label class="sr-only" for="startdate-input"
                    >Start Date</label
                  >

                  <b-form-datepicker
                    id="startdate-input"
                    name="startdate-input"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    placeholder="Start Date"
                    v-model="$v.form.startdate.$model"
                    :state="validateState('startdate')"
                    :date-format-options="{
                      year: 'numeric',
                      month: 'numeric',
                      day: 'numeric',
                    }"
                    aria-describedby="input-2-live-feedback"
                  ></b-form-datepicker>
                  <b-form-invalid-feedback id="input-2-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
              <b-col>
                <b-form-group id="example-input-group-3">
                  <label class="sr-only" for="enddate-input">End Date</label>
                  <b-form-datepicker
                    id="enddate-input"
                    name="enddate-input"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    placeholder="End Date"
                    v-model="$v.form.enddate.$model"
                    :state="validateState('enddate')"
                    :date-format-options="{
                      year: 'numeric',
                      month: 'numeric',
                      day: 'numeric',
                    }"
                    aria-describedby="input-3-live-feedback"
                  ></b-form-datepicker>
                  <b-form-invalid-feedback id="input-3-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
              <b-col>
                <b-form-group id="example-input-group-4">
                  <label class="sr-only" for="example-input-4">Status</label>
                  <b-form-input
                    id="example-input-4"
                    name="example-input-4"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    placeholder="Status"
                    v-model="$v.form.status.$model"
                    :state="validateState('status')"
                    aria-describedby="input-4-live-feedback"
                    disabled
                  ></b-form-input>

                  <b-form-invalid-feedback id="input-4-live-feedback"
                    >This is a required field.</b-form-invalid-feedback
                  >
                </b-form-group>
              </b-col>
            </b-row>
          </b-form>
        </b-container>

        <div class="table-responsive">
          <b-card
            sub-title="Scope Of Project (select one)"
            class="form-list"
            :class="
              $v.form.scope.$dirty && !$v.form.scope.required
                ? $v.form.scope.$invalid
                  ? 'is-invalid'
                  : 'is-valid'
                : ''
            "
          >
            <b-card-text>
              <b-form-radio-group
                v-model="$v.form.scope.$model"
                :options="scopeOptions"
                class="mb-3"
                value-field="item"
                text-field="name"
                :state="validateState('scope')"
                aria-describedby="scope-live-feedback"
              ></b-form-radio-group>

              <div class="invalid-feedback" v-if="!$v.form.scope.required">
                This is a required field.
              </div>
            </b-card-text>
          </b-card>
        </div>

        <div class="table-responsive">
          <b-card
            sub-title="Project Participants"
            class="form-list"
            :class="
              $v.form.participants.$dirty
                ? $v.form.participants.$invalid
                  ? 'is-invalid'
                  : 'is-valid'
                : ''
            "
          >
            <b-card-text>
              <div class="d-flex justify-content-end align-items-center mb-1">
                <a
                  href="#"
                  class="btn btn-sm btn-primary btn-icon-split"
                  v-b-modal.modal-prevent-closing
                >
                  <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                  </span>
                  <span class="text">Add Participant</span>
                </a>
              </div>
            </b-card-text>

            <b-card-text>
              <b-table
                v-if="form.participants.length > 0"
                id="participants-b-table-id"
                small
                :items="form.participants"
                :fields="participantFields"
                responsive="sm"
                caption-top
              >
                <template #cell(index)="data">
                  {{ data.index + 1 }}
                </template>

                <template #table-colgroup="scope">
                  <col
                    v-for="field in scope.fields"
                    :key="field.key"
                    :style="{
                      width: field.key === 'actions' ? '120px' : 'auto',
                    }"
                  />
                </template>

                <!-- email_verified_at -->
                <template #cell(email_verified_at)="data">
                  <b-badge variant="success" v-if="data.item.email_verified_at"
                    >Yes</b-badge
                  >
                  <b-badge v-if="!data.item.email_verified_at">No</b-badge>
                </template>

                <template #cell(partner)="data">
                  <b-form-checkbox
                    id="partner"
                    v-model="data.item.pvcot"
                    value="partner"
                    unchecked-value="-"
                  ></b-form-checkbox>
                </template>

                <template #cell(vendor)="data">
                  <b-form-checkbox
                    id="vendor"
                    v-model="data.item.pvcot"
                    value="vendor"
                    unchecked-value="-"
                  ></b-form-checkbox>
                </template>

                <template #cell(client)="data">
                  <b-form-checkbox
                    id="client"
                    v-model="data.item.pvcot"
                    value="client"
                    unchecked-value="-"
                  ></b-form-checkbox>
                </template>

                <template #cell(others)="data">
                  <b-form-checkbox
                    id="others"
                    v-model="data.item.pvcot"
                    value="others"
                    unchecked-value="-"
                  ></b-form-checkbox>
                </template>

                <template #cell(technical)="data">
                  <b-form-checkbox
                    id="technical"
                    v-model="data.item.pvcot"
                    value="technical"
                    unchecked-value="-"
                  ></b-form-checkbox>
                </template>

                <template #cell(r)="data">
                  <b-form-checkbox
                    id="r"
                    v-model="data.item.raci"
                    value="r"
                    unchecked-value="-"
                  ></b-form-checkbox>
                </template>

                <template #cell(a)="data">
                  <b-form-checkbox
                    id="a"
                    v-model="data.item.raci"
                    value="a"
                    unchecked-value="-"
                  ></b-form-checkbox>
                </template>

                <template #cell(c)="data">
                  <b-form-checkbox
                    id="c"
                    v-model="data.item.raci"
                    value="c"
                    unchecked-value="-"
                  ></b-form-checkbox>
                </template>

                <template #cell(i)="data">
                  <b-form-checkbox
                    id="i"
                    v-model="data.item.raci"
                    value="i"
                    unchecked-value="-"
                  ></b-form-checkbox>
                </template>

                <template #cell(actions)="data">
                  <action-button
                    :data="data"
                    :meta="editActionButton.meta"
                    name="edit"
                    onlyicon
                    @click="editActionButtonClick"
                  ></action-button>
                  <action-button
                    :data="data"
                    :meta="deleteActionButton.meta"
                    :classes="deleteActionButton.classes"
                    name="delete"
                    onlyicon
                    @click="deleteActionButtonClick"
                  ></action-button>
                </template>
              </b-table>

              <p v-if="form.participants.length === 0" class="mb-0">No Data</p>
              <div
                class="invalid-feedback"
                v-if="!$v.form.participants.required"
              >
                Please add at least one participants.
              </div>
            </b-card-text>
          </b-card>
        </div>

        <div class="table-responsive">
          <b-card sub-title="Stages">
            <b-card-text>
              <b-table
                v-if="form.scope && stagesByScope[form.scope]"
                id="stages-b-table-id"
                small
                :items="stagesByScope[form.scope]"
                :fields="stageFields"
                responsive="sm"
                caption-top
              >
                <template #cell(index)="data">
                  {{ data.index + 1 }}
                </template>

                <template #cell(actions)="data">
                  <action-button
                    :data="data"
                    :meta="editActionButton.meta"
                    name="Initiate"
                    @click="editActionButtonClick"
                  ></action-button>
                </template>
              </b-table>
            </b-card-text>
          </b-card>
        </div>
      </div>
    </div>

    <b-overlay :show="busy" no-wrap>
      <template #overlay>
        <div
          ref="dialog"
          tabindex="-1"
          role="dialog"
          aria-modal="false"
          aria-labelledby="form-confirm-label"
          class="text-center p-3"
        >
          <p><strong id="form-confirm-label">Are you sure?</strong></p>
          <div class="d-flex">
            <b-button
              variant="outline-danger"
              class="mr-3"
              @click="onOverlayCancel"
            >
              Cancel
            </b-button>
            <b-button variant="outline-success" @click="onOverlayOK"
              >OK</b-button
            >
          </div>
        </div>
      </template>
    </b-overlay>

    <b-modal
      id="modal-prevent-closing"
      ref="modal"
      title="Add User"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
    >
      <form ref="form" @submit.stop.prevent="handleAddUserSubmit">
        <b-form-group
          id="example-modal-input-group-1"
          label="Name"
          label-for="modal-name-input"
        >
          <b-form-input
            id="modal-name-input"
            name="modal-name-input"
            class="mb-2 mr-sm-2 mb-sm-0"
            placeholder="Name"
            v-model="$v.newparticipant.name.$model"
            :state="validateModalState('name')"
            aria-describedby="modal-input-1-live-feedback"
          ></b-form-input>
          <b-form-invalid-feedback id="modal-input-1-live-feedback"
            >This is a required field.</b-form-invalid-feedback
          >
        </b-form-group>

        <b-form-group
          id="example-modal-input-group-2"
          label="Email"
          label-for="modal-email-input"
        >
          <b-form-input
            id="modal-email-input"
            name="modal-email-input"
            class="mb-2 mr-sm-2 mb-sm-0"
            placeholder="Email"
            v-model="$v.newparticipant.email.$model"
            :state="validateModalState('email')"
            aria-describedby="modal-input-2-live-feedback"
          ></b-form-input>
          <div
            class="invalid-feedback"
            v-if="!$v.newparticipant.email.required"
          >
            This is a required field.
          </div>
          <div class="invalid-feedback" v-if="!$v.newparticipant.email.email">
            Enter vaild email.
          </div>
          <div
            class="invalid-feedback"
            v-if="!$v.newparticipant.email.isEmailAlreadyExists"
          >
            Email already exists.
          </div>
        </b-form-group>

        <b-form-group
          id="example-modal-input-group-3"
          label="Phone"
          label-for="modal-phone-input"
        >
          <b-form-input
            id="modal-phone-input"
            name="modal-phone-input"
            class="mb-2 mr-sm-2 mb-sm-0"
            placeholder="Phone"
            v-model="$v.newparticipant.phone.$model"
            :state="validateModalState('phone')"
            aria-describedby="modal-input-3-live-feedback"
          ></b-form-input>
          <div
            class="invalid-feedback"
            v-if="!$v.newparticipant.phone.required"
          >
            This is a required field.
          </div>
          <div
            class="invalid-feedback"
            v-if="!$v.newparticipant.phone.numbercheck"
          >
            Enter vaild phone number.
          </div>
        </b-form-group>
      </form>
    </b-modal>
  </div>
</template>

<script>
import ActionButton from "./../../components/ActionButton.vue";
import * as notify from "../../../../utils/notify.js";
import { validationMixin } from "vuelidate";
import { required, email, helpers, numeric } from "vuelidate/lib/validators";
import { getScopesBySlug } from "../../../../services/scope";
import { getStagesByScope } from "../../../../services/scope-stage";

export default {
  name: "CustomersProjectOpen",
  mixins: [validationMixin],
  props: {
    pagelabel: {
      type: String,
      default: "Project Details",
    },
  },
  data() {
    return {
      stagesByScope: {},
      busy: false,
      isDeleteFor: null,
      scopeOptions: [],
      stageFields: [
        { key: "index", label: "#" },
        { key: "name", label: "Stage" },
        "scope",
        "start",
        "end",
        "actions",
      ],
      participantFields: [
        { key: "name" },
        { key: "partner", class: "text-center" },
        { key: "vendor", class: "text-center" },
        { key: "client", class: "text-center" },
        { key: "others", class: "text-center" },
        { key: "technical", class: "text-center" },
        { key: "r", class: "text-center participant-red-header-text" },
        { key: "a", class: "text-center participant-red-header-text" },
        { key: "c", class: "text-center participant-red-header-text" },
        { key: "i", class: "text-center participant-red-header-text" },
        { key: "email" },
        { key: "phone" },
        {
          key: "email_verified_at",
          label: "Email Verified",
          class: "text-center",
        },
        { key: "actions", stickyColumn: true },
      ],
      form: {
        name: null,
        startdate: null,
        enddate: null,
        status: null,
        scope: null,
        participants: [],
        stages: [],
      },
      newparticipant: {
        name: null,
        email: null,
        phone: null,
        isNew: true,
        pvcot: "client",
      },
      editActionButton: {
        meta: {
          icon: {
            has: true,
            classes: {
              "fa-edit": true,
            },
          },
        },
      },
      deleteActionButton: {
        meta: {
          icon: {
            has: true,
            classes: {
              "fa-trash": true,
            },
          },
        },
        classes: {
          btn: true,
          "btn-danger": true,
          "btn-sm": true,
        },
      },
    };
  },
  validations: {
    form: {
      name: {
        required,
      },
      startdate: {
        required,
      },
      enddate: {
        required,
      },
      scope: {
        required,
      },
      status: {
        required,
      },
      participants: {
        required,
      },
    },
    newparticipant: {
      name: {
        required,
      },
      email: {
        required,
        email,
        isEmailAlreadyExists: (value, vm) => {
          if (value === "" || value === null) return true;
          return axios.post("users/email-already-exists", {
            email: value,
            id: vm.id,
          });
        },
      },
      phone: {
        required,
        numbercheck: helpers.regex("phone", /^(\+\d{1,3}[- ]?)?\d{10}$/),
      },
    },
  },
  async mounted() {
    await this.getScopes();
    await this.getStagesByScope();
    const { data } = await this.getData(this.getParam());
    this.form = {
      ...data,
    };
  },
  methods: {
    async getScopes() {
      const { data } = await getScopesBySlug();
      this.scopeOptions = Object.keys(data).map((key) => ({
        item: data[key].slug,
        name: data[key].name,
      }));
    },
    async getStagesByScope() {
      const { data } = await getStagesByScope();
      this.stagesByScope = { ...data };
    },
    getParam() {
      return this.$route.params;
    },
    validateState(name) {
      const { $dirty, $error } = this.$v.form[name];
      return $dirty ? !$error : null;
    },
    resetForm() {
      this.form = {
        name: null,
        startdate: null,
        enddate: null,
        participants: [],
      };

      this.$nextTick(() => {
        this.$v.$reset();
      });
    },
    onSubmit() {
      this.$v.form.$touch();
      if (this.$v.form.$anyError) {
        return;
      }

      this.saveProject();
    },
    async saveProject() {
      try {
        const id = this.$route.params.id;
        const response = await axios.put(`customers/${id}`, {
          ...this.form,
        });

        this.$router.push("/admin/customers");
      } catch (error) {
        notify.authError(error);
      }
    },
    validateModalState(name) {
      const { $dirty, $error } = this.$v.newparticipant[name];
      return $dirty ? !$error : null;
    },
    resetModal() {
      this.newparticipant = {
        id: null,
        name: "",
        email: "",
        phone: "",
        isNew: true,
      };
      this.editUserIndex = null;

      this.$v.$reset();
    },
    handleOk(bvModalEvent) {
      // Prevent modal from closing
      bvModalEvent.preventDefault();
      // Trigger submit handler
      this.handleAddUserSubmit();
    },
    handleAddUserSubmit() {
      this.$v.newparticipant.$touch();
      if (this.$v.newparticipant.$anyError) {
        return;
      }

      // Push / Update
      if (this.editUserIndex != null && this.editUserIndex != -1) {
        this.form.participants[this.editUserIndex] = {
          ...this.newparticipant,
          isNew: false,
        };
      } else
        this.form.participants.push({
          ...this.newparticipant,
          isNew: true,
          id: null,
        });

      this.$root.$emit("bv::refresh::table", "participants-b-table-id");
      this.resetModal();

      // Hide the modal manually
      this.$nextTick(() => {
        this.$bvModal.hide("modal-prevent-closing");
      });
    },
    async getData(params) {
      try {
        const response = await axios.get(`projects/${params.projectid}`);
        return response;
      } catch (error) {
        notify.authError(error);
      }
    },
    editActionButtonClick(data) {
      const { id, name, email, phone } = data.item;
      this.$bvModal.show("modal-prevent-closing");
      this.editUserIndex = data.index;
      this.newparticipant = {
        id,
        name,
        email,
        phone,
      };
      this.$v.$reset();
    },
    deleteActionButtonClick(data) {
      this.isDeleteFor = "participant";
      this.editUserIndex = data.index;
      this.busy = true;
    },

    onOverlayCancel() {
      this.isDeleteFor = null;
      this.busy = false;
    },
    onOverlayOK() {
      if (this.isDeleteFor == "participant") {
        if (this.editUserIndex > -1) {
          this.form.participants.splice(this.editUserIndex, 1);
        }
        this.$root.$emit("bv::refresh::table", "participants-b-table-id");
      }

      this.busy = false;
      this.isDeleteFor = null;
    },
  },
  components: {
    ActionButton,
  },
};
</script>