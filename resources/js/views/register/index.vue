<template>
  <div>
    <div class="container">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Create an Account</h1>
            </div>
            <form class="user auth-form" @submit.stop.prevent="onSubmit">
              <b-row>
                <b-col sm="6" class="mb-3 mb-sm-0">
                  <b-form-group id="example-input-group-1">
                    <b-form-input
                      type="text"
                      id="exampleFirstName"
                      name="exampleFirstName"
                      class="form-control form-control-user"
                      placeholder="First Name"
                      v-model="$v.form.first_name.$model"
                      :state="validateState('first_name')"
                      aria-describedby="firstNameHelp"
                    ></b-form-input>

                    <div
                      class="invalid-feedback"
                      v-if="!$v.form.first_name.required"
                    >
                      This is a required field.
                    </div>
                  </b-form-group>
                </b-col>
                <b-col sm="6">
                  <b-form-group id="example-input-group-2">
                    <b-form-input
                      type="text"
                      id="exampleLastName"
                      name="exampleLastName"
                      class="form-control form-control-user"
                      placeholder="Last Name"
                      v-model="$v.form.last_name.$model"
                      :state="validateState('last_name')"
                      aria-describedby="last_nameHelp"
                    ></b-form-input>

                    <div
                      class="invalid-feedback"
                      v-if="!$v.form.last_name.required"
                    >
                      This is a required field.
                    </div>
                  </b-form-group>
                </b-col>
              </b-row>
              <b-form-group id="example-input-group-3">
                <b-form-input
                  type="email"
                  id="exampleInputEmail"
                  name="exampleInputEmail"
                  class="form-control form-control-user"
                  placeholder="Enter Email Address"
                  v-model="$v.form.email.$model"
                  :state="validateState('email')"
                  aria-describedby="emailHelp"
                ></b-form-input>

                <div class="invalid-feedback" v-if="!$v.form.email.required">
                  This is a required field.
                </div>
                <div class="invalid-feedback" v-if="!$v.form.email.email">
                  Enter vaild email.
                </div>
              </b-form-group>
              <b-row>
                <b-col sm="6" class="mb-3 mb-sm-0">
                  <b-form-group id="example-input-group-4">
                    <b-form-input
                      type="password"
                      id="examplePassword"
                      name="examplePassword"
                      class="form-control form-control-user"
                      placeholder="Password"
                      v-model="$v.form.password.$model"
                      :state="validateState('password')"
                      aria-describedby="passwordHelp"
                    ></b-form-input>

                    <div
                      class="invalid-feedback"
                      v-if="!$v.form.password.required"
                    >
                      This is a required field.
                    </div>
                  </b-form-group>
                </b-col>
                <b-col sm="6">
                  <b-form-group id="example-input-group-4">
                    <b-form-input
                      type="password"
                      id="exampleRepeatPassword"
                      name="exampleRepeatPassword"
                      class="form-control form-control-user"
                      placeholder="Repeat Password"
                      v-model="$v.form.password_confirm.$model"
                      :state="validateState('password_confirm')"
                      aria-describedby="password_confirmHelp"
                    ></b-form-input>

                    <div
                      class="invalid-feedback"
                      v-if="!$v.form.password_confirm.sameAsPassword"
                    >
                      Passwords must be identical
                    </div>
                  </b-form-group>
                </b-col>
              </b-row>

              <LoadingButton
                text="Register Account"
                v-bind:isLoading="isLoading"
              />
            </form>
            <hr />
            <div class="text-center">
              <router-link class="small" to="/forgot-password"
                >Forgot Password?</router-link
              >
            </div>
            <div class="text-center">
              <router-link class="small" to="/"
                >Already have an account? Login</router-link
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import * as notify from "../../utils/notify.js";
import Nav from "../../components/Nav";
import LoadingButton from "../../components/LoadingButton";
import { required, email, sameAs, minLength } from "vuelidate/lib/validators";

export default {
  name: "Register",
  components: {
    Nav,
    LoadingButton,
  },
  data() {
    return {
      form: {
        first_name: "",
        last_name: "",
        email: "",
        password: "",
        password_confirm: "",
      },
      isLoading: false,
    };
  },
  validations: {
    form: {
      first_name: {
        required,
      },
      last_name: {
        required,
      },
      email: {
        required,
        email,
      },
      password: {
        required,
        minLength: minLength(6),
      },
      password_confirm: {
        sameAsPassword: sameAs("password"),
      },
    },
  },

  methods: {
    async register() {
      this.isLoading = true;
      try {
        var response = await axios.post("register", {
          ...this.form,
        });

        this.isLoading = false;

        if (response.data.must_verify_email) {
          this.$router.push(`/verify/user/${response.data.id}`);
        } else {
          let message =
            "Your account has been created successfully. Please Log in.";
          let toast = Vue.toasted.show(message, {
            theme: "toasted-primary",
            position: "top-right",
            duration: 5000,
          });
          this.$router.push("/");
        }
      } catch (error) {
        notify.authError(error);
        this.isLoading = false;
      }
    },
    onSubmit() {
      this.$v.form.$touch();
      if (this.$v.form.$anyError) {
        return;
      }

      this.register();
    },
    validateState(name) {
      const { $dirty, $error } = this.$v.form[name];
      return $dirty ? !$error : null;
    },
  },
};
</script>