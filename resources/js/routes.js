export const routes = [
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import(/* webpackChunkName: "404" */ './Pages/404.vue')
    },
    {
        path: '/home',
        name: 'home',
        component: () => import(/* webpackChunkName: "home" */ './Pages/Home.vue')
    },
    {
        path: '/keluhan-pelanggan',
        name: 'keluhan_pelanggan',
        component: () => import(/* webpackChunkName: "keluhan_pelanggan" */ './Pages/KeluhanPelanggan.vue')
    },
    {
        path: '/keluhan-pelanggan/:id',
        name: 'detail_keluhan_pelanggan',
        component: () => import(/* webpackChunkName: "detail_keluhan_pelanggan" */ './Pages/DetailKeluhanPelanggan.vue')
    },
    {
        path: '/keluhan-pelanggan/create',
        name: 'create_keluhan_pelanggan',
        component: () => import(/* webpackChunkName: "create_keluhan_pelanggan" */ './Pages/CreateKeluhanPelanggan.vue')
    },
    {
        path: '/keluhan-pelanggan/edit/:id',
        name: 'edit_keluhan_pelanggan',
        component: () => import(/* webpackChunkName: "edit_keluhan_pelanggan" */ './Pages/EditKeluhanPelanggan.vue')
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: () => import(/* webpackChunkName: "dashboard" */ './Pages/Dashboard.vue')
    },
];