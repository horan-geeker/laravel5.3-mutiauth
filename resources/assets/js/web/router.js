/**
 * Created by He on 2017/2/26.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        component: require('./components/container/container.vue'),
    },
    {
        path: '/login',
        component: require('./components/login/login.vue'),
    },
    {
        path: '/home',
        component: require('./components/home/home.vue'),
    },
    {
        path: '/register',
        component: require('./components/register/register.vue'),
    },
    {
        path: '/password/email',
        component: require('./components/password-reset/email.vue'),
    },
    {
        path: '/password/reset',
        component: require('./components/password-reset/reset.vue'),
    },
]

const router = new VueRouter({
    routes,
    base: '/',
    linkActiveClass: 'active',
    mode: 'history'
})

module.exports = router