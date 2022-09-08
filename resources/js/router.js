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
            name: "partnersadd",
            component: () => import("./views/admin/partners/add.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/partners/edit/:id",
            name: "partnersedit",
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
            name: "customersadd",
            component: () => import("./views/admin/customers/add.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/customers/open/project/:id/:projectid",
            name: "customersopen",
            component: () => import("./views/admin/customers/open/index.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/customers/edit/:id",
            name: "customersedit",
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
            name: "projectsadd",
            component: () => import("./views/admin/projects/add.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/projects/edit/:id",
            name: "projectsedit",
            component: () => import("./views/admin/projects/edit.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        },
        {
            path: "/admin/projects/view/:id",
            name: "projectsview",
            component: () => import("./views/admin/projects/host-index.vue"),
            meta: {
                requiresAuth: true,
                layout: AdminLayout
            }
        }
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
