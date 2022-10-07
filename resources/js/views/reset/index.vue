<template>
  <div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
          <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-2">Reset your password</h1>
                </div>
                <form class="user auth-form" @submit.stop.prevent="onSubmit">
                  <b-form-group id="example-input-group-1">
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

                  <b-form-group id="example-input-group-2">
                    <b-form-input
                      type="password"
                      id="exampleRepeatPassword"
                      name="exampleRepeatPassword"
                      class="form-control form-control-user"
                      placeholder="Repeat Password"
                      v-model="$v.form.password_confirm.$model"
                      :state="validateState('password_confirm')"
                      aria-describedby="exampleRepeatPasswordHelp"
                    ></b-form-input>

                    <div
                      class="invalid-feedback"
                      v-if="!$v.form.password_confirm.sameAsPassword"
                    >
                      Passwords must be identical
                    </div>
                  </b-form-group>
                  <button
                    type="submit"
                    class="btn btn-primary btn-user btn-block"
                  >
                    Reset Password
                  </button>
                </form>
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
import * as notify from "../../utils/notify.js";
import Nav from "../../components/Nav";
import { required, sameAs, minLength } from "vuelidate/lib/validators";

export default {
  name: "Reset",
  components: {
    Nav,
  },
  data() {
    return {
      form: {
        password: "",
        password_confirm: "",
      },
    };
  },
  validations: {
    form: {
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
    async reset() {
      try {
        const response = await axios.post("reset", {
          ...this.form,
          token: this.$route.params.token,
        });

        let toast = this.$toasted.show("Password updated successfully", {
          theme: "toasted-primary",
          position: "top-right",
          duration: 5000,
        });

        this.$router.push("/");
      } catch (error) {
        notify.authError(error);
      }
    },
    onSubmit() {
      this.$v.form.$touch();
      if (this.$v.form.$anyError) {
        return;
      }

      this.reset();
    },
    validateState(name) {
      const { $dirty, $error } = this.$v.form[name];
      return $dirty ? !$error : null;
    },
  },
};
</script>