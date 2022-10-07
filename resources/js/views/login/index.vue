<template>
  <div>
    <div class="container">
      <!---- Navbar -->
      <!-- Outer Row -->
      <div class="row justify-content-center" v-if="verificationStatus">
        <div class="col-xl-10 col-lg-12 col-md-9">
          <div
            class="alert alert-dismissible fade show mt-5"
            v-bind:class="verificationAlertClasses"
            role="alert"
          >
            <div>{{ verificationMessage }}</div>
            <button
              type="button"
              class="close"
              data-dismiss="alert"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 col-md-6">
          <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
              <!-- Nested Row within Card Body -->
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">Login</h1>
                </div>
                <form class="user auth-form" @submit.stop.prevent="onSubmit">
                  <b-form-group id="example-input-group-1">
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

                    <div
                      class="invalid-feedback"
                      v-if="!$v.form.email.required"
                    >
                      This is a required field.
                    </div>
                    <div class="invalid-feedback" v-if="!$v.form.email.email">
                      Enter vaild email.
                    </div>
                  </b-form-group>

                  <b-form-group id="example-input-group-2">
                    <b-form-input
                      type="password"
                      id="exampleInputPassword"
                      name="exampleInputPassword"
                      class="form-control form-control-user"
                      placeholder="Enter Password"
                      v-model="$v.form.password.$model"
                      :state="validateState('password')"
                      aria-describedby="passwordHelp"
                    ></b-form-input>

                    <b-form-invalid-feedback id="passwordHelp"
                      >This is a required field.</b-form-invalid-feedback
                    >
                  </b-form-group>

                  <div class="form-group">
                    <div class="custom-control custom-checkbox small">
                      <input
                        type="checkbox"
                        class="custom-control-input"
                        id="customCheck"
                      />
                      <label class="custom-control-label" for="customCheck"
                        >Remember Me</label
                      >
                    </div>
                  </div>
                  <button
                    type="submit"
                    class="btn btn-primary btn-user btn-block"
                  >
                    Login
                  </button>
                </form>
                <hr />
                <div class="text-center">
                  <router-link class="small" to="/forgot-password"
                    >Forgot Password?</router-link
                  >
                </div>
                <div class="text-center">
                  <router-link class="small" to="/register"
                    >Create an Account</router-link
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Nav from "../../components/Nav";
import * as notify from "../../utils/notify.js";
import { required, email } from "vuelidate/lib/validators";

export default {
  name: "Login",
  components: {
    Nav,
  },
  data() {
    return {
      form: {
        email: null,
        password: null,
      },
      loading: false,
      verificationStatus: this.$route.query.verification_status ? true : false,
      verificationMessage: "",
      verificationAlertClasses: {
        "alert-success": false,
        "alert-danger": false,
      },
    };
  },
  validations: {
    form: {
      email: {
        required,
        email,
      },
      password: {
        required,
      },
    },
  },
  created: function () {
    if (this.$route.query.verification_status === "success") {
      this.verificationMessage =
        "Your account has been verified. Please log in.";
      this.verificationAlertClasses["alert-success"] = true;
    } else if (this.$route.query.verification_status === "error") {
      this.verificationMessage = "Your account could not be verified.";
      this.verificationAlertClasses["alert-danger"] = true;
    }
  },
  methods: {
    async login() {
      try {
        const response = await axios.post("login", { ...this.form });

        localStorage.setItem("token", response.data.token);
        this.$store.dispatch("user", response.data.user);
        this.$router.push("/admin");
      } catch (error) {
        notify.authError(error);
      }
    },
    onSubmit() {
      this.$v.form.$touch();
      if (this.$v.form.$anyError) {
        return;
      }

      this.login();
    },
    validateState(name) {
      const { $dirty, $error } = this.$v.form[name];
      return $dirty ? !$error : null;
    },
  },
};
</script>

<style>
</style>