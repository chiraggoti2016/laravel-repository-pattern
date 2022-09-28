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
        <b-container class="bv-example-row ml-0 pl-0">
          <b-form @submit.stop.prevent="onSubmit">
            <b-row>
              <b-col cols="5">
                <b-form-group id="example-input-group-1">
                  <label class="require" for="example-input-1">Name</label>
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
                  <label class="require" for="startdate-input"
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
                  <label class="require" for="enddate-input">End Date</label>
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
              <b-col cols="2">
                <label> Status </label>
                <a href="#" class="btn btn-secondary btn-icon-split"
                  ><span class="icon text-white-50"
                    ><i class="fas fa-arrow-right"></i
                  ></span>
                  <span class="text">{{ form.status }}</span></a
                >
              </b-col>
            </b-row>
          </b-form>
        </b-container>

        <div class="table-responsive">
          <b-card
            sub-title="Scope Of Project (select one)"
            class="form-list"
            body-class="require-h6"
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
            body-class="require-h6"
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
                  <b-iconstack font-scale="1">
                    <b-icon stacked icon="square" font-scale="1"></b-icon>
                    <b-icon
                      v-if="data.item.pivot.pvcot === 'partner'"
                      stacked
                      icon="check"
                    ></b-icon>
                  </b-iconstack>
                </template>

                <template #cell(vendor)="data">
                  <b-iconstack font-scale="1">
                    <b-icon stacked icon="square" font-scale="1"></b-icon>
                    <b-icon
                      v-if="data.item.pivot.pvcot === 'vendor'"
                      stacked
                      icon="check"
                    ></b-icon>
                  </b-iconstack>
                </template>

                <template #cell(client)="data">
                  <b-iconstack font-scale="1">
                    <b-icon stacked icon="square" font-scale="1"></b-icon>
                    <b-icon
                      v-if="data.item.pivot.pvcot === 'client'"
                      stacked
                      icon="check"
                    ></b-icon>
                  </b-iconstack>
                </template>

                <template #cell(others)="data">
                  <b-iconstack font-scale="1">
                    <b-icon stacked icon="square" font-scale="1"></b-icon>
                    <b-icon
                      v-if="data.item.pivot.pvcot === 'others'"
                      stacked
                      icon="check"
                    ></b-icon>
                  </b-iconstack>
                </template>

                <template #cell(technical)="data">
                  <b-iconstack font-scale="1">
                    <b-icon stacked icon="square" font-scale="1"></b-icon>
                    <b-icon
                      v-if="data.item.pivot.pvcot === 'technical'"
                      stacked
                      icon="check"
                    ></b-icon>
                  </b-iconstack>
                </template>

                <template #cell(r)="data">
                  <b-iconstack font-scale="1">
                    <b-icon stacked icon="square" font-scale="1"></b-icon>
                    <b-icon
                      v-if="data.item.pivot.raci === 'r'"
                      stacked
                      icon="check"
                    ></b-icon>
                  </b-iconstack>
                </template>

                <template #cell(a)="data">
                  <b-iconstack font-scale="1">
                    <b-icon stacked icon="square" font-scale="1"></b-icon>
                    <b-icon
                      v-if="data.item.pivot.raci === 'a'"
                      stacked
                      icon="check"
                    ></b-icon>
                  </b-iconstack>
                </template>

                <template #cell(c)="data">
                  <b-iconstack font-scale="1">
                    <b-icon stacked icon="square" font-scale="1"></b-icon>
                    <b-icon
                      v-if="data.item.pivot.raci === 'c'"
                      stacked
                      icon="check"
                    ></b-icon>
                  </b-iconstack>
                </template>

                <template #cell(i)="data">
                  <b-iconstack font-scale="1">
                    <b-icon stacked icon="square" font-scale="1"></b-icon>
                    <b-icon
                      v-if="data.item.pivot.raci === 'i'"
                      stacked
                      icon="check"
                    ></b-icon>
                  </b-iconstack>
                </template>

                <template #cell(actions)="data">
                  <action-button
                    :data="data"
                    :meta="editActionButton.meta"
                    name="edit"
                    @click="editActionButtonClick"
                  ></action-button>
                  <action-button
                    :data="data"
                    :meta="deleteActionButton.meta"
                    :classes="deleteActionButton.classes"
                    name="delete"
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

                <template #cell(scope)="data">
                  <p v-if="data.item.scope && scopes[data.item.scope]">
                    {{ scopes[data.item.scope].name }}
                  </p>
                </template>

                <template #cell(status)="data">
                  <p v-if="data.item.status">
                    {{ data.item.status }}
                  </p>
                  <p
                    v-else-if="
                      form.questionaire !== null &&
                      data.item.name === 'Pre-Engagement Questionaire'
                    "
                  >
                    {{ form.questionaire.status }}
                  </p>
                  <p v-else>-</p>
                </template>

                <template #cell(start)="data">
                  <p
                    v-if="
                      data.item.name === 'Pre-Engagement Questionaire' &&
                      form.questionaire &&
                      form.questionaire.startdate
                    "
                  >
                    {{ form.questionaire.startdate }}
                  </p>
                  <p v-else-if="data.item.start">{{ data.item.start }}</p>
                  <p v-else>-</p>
                </template>

                <template #cell(end)="data">
                  <p
                    v-if="
                      data.item.name === 'Pre-Engagement Questionaire' &&
                      form.questionaire &&
                      form.questionaire.enddate
                    "
                  >
                    {{ form.questionaire.enddate }}
                  </p>
                  <p v-else-if="data.item.end">{{ data.item.end }}</p>
                  <p v-else>-</p>
                </template>

                <template #cell(actions)="data">
                  <action-button
                    :data="data"
                    :meta="{
                        ...initActionButton.meta, prefixLink: getLink(data.item.name),
                    }"
                    :classes="initActionButton.classes"
                    name="Initiate"
                    :disabled="
                      data.item.name === 'Pre-Engagement Questionaire' &&
                      form.questionaire !== null
                    "
                  >
                  </action-button>
                  <action-button
                    :data="data"
                    :meta="{
                      ...openActionButton.meta,
                      prefixLink:
                        data.item.name === 'Pre-Engagement Questionaire' &&
                        form.questionaire !== null
                          ? `/admin/customers/open/project/questionnaire/${$route.params.id}/${$route.params.projectid}`
                          : null,
                    }"
                    :classes="openActionButton.classes"
                    name="Open"
                    :disabled="
                      data.item.name === 'Pre-Engagement Questionaire' &&
                      form.questionaire === null
                    "
                  >
                  </action-button>
                  <action-button
                    :data="data"
                    :meta="notesActionButton.meta"
                    :classes="notesActionButton.classes"
                    name="Notes"
                  >
                  </action-button>
                  <action-button
                    :data="data"
                    :meta="reminderActionButton.meta"
                    :classes="reminderActionButton.classes"
                    name="Reminder"
                  >
                  </action-button>
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
      :title="editUserIndex !== null ? 'Edit Participant' : 'Add Participant'"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
      :ok-title="editUserIndex !== null ? 'Edit' : 'Add'"
    >
      <form ref="form" @submit.stop.prevent="handleAddUserSubmit">
        <b-form-group
          id="example-modal-input-group-1"
          label="Name"
          label-for="modal-name-input"
          label-class="require"
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
          label-class="require"
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

        <b-form-group
          id="example-modal-input-group-4"
          label="User Type"
          label-for="modal-pvcot-input"
          label-class="require"
          v-slot="{ ariaDescribedby }"
        >
          <b-form-radio-group
            id="modal-pvcot-input"
            name="modal-pvcot-input"
            v-model="$v.newparticipant.pivot.pvcot.$model"
            :options="pvcotOptions"
            :aria-describedby="ariaDescribedby"
          ></b-form-radio-group>
          <div
            class="invalid-feedback"
            v-if="!$v.newparticipant.pivot.pvcot.required"
          >
            This is a required field.
          </div>
        </b-form-group>

        <b-form-group
          id="example-modal-input-group-5"
          label="RACI"
          label-for="modal-raci-input"
          label-class="require"
          v-slot="{ raciariaDescribedby }"
        >
          <b-form-radio-group
            id="modal-raci-input"
            name="modal-raci-input"
            v-model="$v.newparticipant.pivot.raci.$model"
            :options="raciOptions"
            :aria-describedby="raciariaDescribedby"
          ></b-form-radio-group>
          <div
            class="invalid-feedback"
            v-if="!$v.newparticipant.pivot.raci.required"
          >
            This is a required field.
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
import { PVCOT_OPTIONS, RACI_OPTIONS } from "../../../../mixins/constants";

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
      pvcotOptions: PVCOT_OPTIONS,
      raciOptions: RACI_OPTIONS,
      stageFields: [
        { key: "index", label: "#" },
        { key: "name", label: "Stage" },
        { key: "scope", class: "text-center" },
        { key: "status", class: "text-center" },
        { key: "start", class: "text-center" },
        { key: "end", class: "text-center" },
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
        questionaire: null,
      },
      editUserIndex: null,
      newparticipant: {
        name: null,
        email: null,
        phone: null,
        isNew: true,
        pivot: {
          pvcot: "client",
          raci: "a",
        },
      },
      editActionButton: {
        meta: {
          icon: {
            has: true,
            classes: {
              "fa-edit": true,
            },
          },
          onlyicon: true,
        },
      },
      initActionButton: {
        meta: {
          icon: {
            has: false,
            classes: {
              "fa-arrow-right": true,
            },
          },
          onlyicon: true,
        },
        classes: {
          btn: true,
          "btn-secondary": true,
          "btn-sm": true,
        },
      },
      openActionButton: {
        meta: {
          icon: {
            has: false,
            classes: {
              "fa-check": true,
            },
          },
          onlyicon: true,
        },
        classes: {
          btn: true,
          "btn-primary": true,
          "btn-sm": true,
        },
      },
      notesActionButton: {
        meta: {
          icon: {
            has: false,
            classes: {
              "fa-clipboard": true,
            },
          },
          onlyicon: true,
        },
        classes: {
          btn: true,
          "btn-warning": true,
          "btn-sm": true,
        },
      },
      reminderActionButton: {
        meta: {
          icon: {
            has: false,
            classes: {
              "fa-stopwatch": true,
            },
          },
          onlyicon: true,
        },
        classes: {
          btn: true,
          "btn-info": true,
          "btn-sm": true,
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
          onlyicon: true,
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
          if (
            value === "" ||
            value === null ||
            /[a-z0-9]+@[a-z]+\.[a-z]{2,3}/.test(value) === false
          )
            return true;
          return axios.post("users/email-already-exists", {
            email: value,
            id: vm.id,
          });
        },
      },
      phone: {
        numbercheck: helpers.regex("phone", /^(\+\d{1,3}[- ]?)?\d{10}$/),
      },
      pivot: {
        pvcot: {
          required,
        },
        raci: {
          required,
        },
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
    getLink(name) {
        if(name == 'Pre-Engagement Questionaire') {
            return `/admin/customers/open/project/questionnaire/${this.$route.params.id}/${this.$route.params.projectid}`;
        } else if(name == 'Data Collection') {
            return `/admin/project/hosts/${this.form.slug}`;
        } else if(name == 'License Review') {
            return `/admin/project/licence-review/${this.form.slug}`;
        } else {
            return null;
        }
    },
    async getScopes() {
      const { data } = await getScopesBySlug();
      this.scopeOptions = Object.keys(data).map((key) => ({
        item: data[key].slug,
        name: data[key].name,
      }));
      this.scopes = data;
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
        const params = this.$route.params;
        const { id, projectid } = params;
        const response = await axios.put(`projects/${id}`, {
          ...this.form,
        });

        this.$router.push(`/admin/customers/open/project/${id}/${projectid}`);
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
        email_verified_at: null,
        pivot: {
          pvcot: "client",
          raci: "a",
        },
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
      const { id, name, email, phone, pivot, email_verified_at } = data.item;
      this.$bvModal.show("modal-prevent-closing");
      this.editUserIndex = data.index;
      this.newparticipant = {
        id,
        name,
        email,
        phone,
        pivot,
        email_verified_at,
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