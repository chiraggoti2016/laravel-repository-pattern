import Vue from "vue";

import Router from "vue-router";
import store from "./vuex";
import AdminLayout from "./views/admin/layout/index";

Vue.use(Router);

let router = new Router({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "login",
            component: () => import("./views/login/index.vue")
        },
        {
            path: "/register",
            name: "register",
            component: () => import("./views/register/index.vue")
        },
        {
            path: "/verify/user/:id",
            name: "verify",
            props: true,
            component: () => import("./views/verify/index.vue")
        },
        {
            path: "/forgot-password",
            name: "forgot",
            component: () => import("./views/forgot/index.vue")
        },
        {
            path: "/reset/:token",
            name: "reset",
            component: () => import("./views/reset/index.vue")
        },
        /**
         * Admin routes
         */
        {
            path: "/admin",
            name: "admin",
            component: () => import("./views/admin/dashboard.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/pages/page-not-found",
            name: "page-not-found",
            component: () => import("./views/admin/page-not-found.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/partners/add",
            name: "partners-add",
            component: () => import("./views/admin/partners/add.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/partners/edit/:id",
            name: "partners-edit",
            component: () => import("./views/admin/partners/edit.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/partners",
            name: "partners",
            component: () => import("./views/admin/partners/list.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/customers/add",
            name: "customers-add",
            component: () => import("./views/admin/customers/add.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/customers/open/project/:id/:projectid",
            name: "customers-open",
            component: () => import("./views/admin/customers/open/index.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/customers/edit/:id",
            name: "customers-edit",
            component: () => import("./views/admin/customers/edit.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/customers",
            name: "customers",
            component: () => import("./views/admin/customers/list.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/projects",
            name: "projects",
            component: () => import("./views/admin/projects/index.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/projects/add",
            name: "projects-add",
            component: () => import("./views/admin/projects/add.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/projects/edit/:id",
            name: "projects-edit",
            component: () => import("./views/admin/projects/edit.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/projects/view/:id",
            name: "projects-view",
            component: () => import("./views/admin/projects/host-index.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/countries/add",
            name: "countries-add",
            component: () => import("./views/admin/countries/add.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/countries/edit/:id",
            name: "countries-edit",
            component: () => import("./views/admin/countries/edit.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/countries",
            name: "countries",
            component: () => import("./views/admin/countries/list.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/question/categories/add",
            name: "question-categories-add",
            component: () => import("./views/admin/question-categories/add.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/question/categories/edit/:id",
            name: "question-categories-edit",
            component: () => import("./views/admin/question-categories/edit.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/question/categories",
            name: "question-categories",
            component: () => import("./views/admin/question-categories/list.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },


        {
            path: "/admin/questions/add",
            name: "questions-add",
            component: () => import("./views/admin/questions/add.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/questions/edit/:id",
            name: "questions-edit",
            component: () => import("./views/admin/questions/edit.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/questions",
            name: "questions",
            component: () => import("./views/admin/questions/list.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },

    ]
});

// router.beforeEach((to, from, next) => {
//     if (to.matched.some(record => record.meta.requiresAuth)) {
//         if (store.getters.user) {
//             next();
//             return;
//         }
//         next("/");
//     } else {
//         next();
//     }
// });

router.beforeEach((to, from, next) => {
    // document.title = to.meta.title;
    if (to.meta.middleware) {
        const middleware = Array.isArray(to.meta.middleware)
            ? to.meta.middleware
            : [to.meta.middleware];
        const context = { to, from, next, store };
        return middleware[0]({
            ...context,
            next: middlewarePipeline(context, middleware, 1),
        });
    } else {
        return next();
    }
});


export default router;
