<template>
  <div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
          <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
              <div class="p-5">
                <div v-if="!emailSent">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                    <p class="mb-4">
                      We get it, stuff happens. Just enter your email address
                      below and we'll send you a link to reset your password!
                    </p>
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
                    <LoadingButton
                      text="Reset password"
                      v-bind:isLoading="isLoading"
                    />
                  </form>
                </div>
                <div v-else>
                  <span class="h4">
                    <i class="far fa-check-circle text-success"></i> Check your
                    email!
                  </span>
                </div>
                <hr />
                <div class="text-center">
                  <router-link class="small" to="/register"
                    >Create an Account</router-link
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
    </div>
  </div>
</template>

<script>
import * as notify from "../../utils/notify.js";
import Nav from "../../components/Nav";
import LoadingButton from "../../components/LoadingButton";
import { required, email } from "vuelidate/lib/validators";

export default {
  name: "Forgot",
  components: {
    Nav,
    LoadingButton,
  },
  data() {
    return {
      form: {
        email: this.email,
      },
      isLoading: false,
      emailSent: false,
    };
  },
  validations: {
    form: {
      email: {
        required,
        email,
      },
    },
  },
  methods: {
    async forgot() {
      this.isLoading = true;
      try {
        await axios.post("forgot", {
          ...this.form,
        });
        this.isLoading = false;
        this.emailSent = true;
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

      this.forgot();
    },
    validateState(name) {
      const { $dirty, $error } = this.$v.form[name];
      return $dirty ? !$error : null;
    },
  },
};
</script>