import {createRouter, createWebHistory} from 'vue-router'

//pages
import HomePage from './component/pages/home/index.vue'
//error
import Error from './component/pages/home/notFound.vue'


//Remind
import pageRemind from './component/pages/home/remind.vue'
//Remind
import pageEvent from './component/pages/home/event.vue'
//login
import Login from './component/auth/login.vue'
//login
import Register from './component/auth/register.vue'
//Auth 
import {getToken} from './utils/auth.js'


const routes = [
     //login
    {
        path: '/',
        component: Login,
        name:'Login',
        meta:{
            requiresAuth:false
        }
    },
     //page
    {
        path:'/home',
        name: 'HomePage',
        component:HomePage,
        meta:{
            requiresAuth:true
        }

    },
    //page eventFillter
    {
        path:'/home/event-m',
        name: 'pageEvent',
        component:pageEvent,
        meta:{
            requiresAuth:true
        }
    },
    //page eventModel
    {
        path:'/home/remind-m',
        name: 'pageRemind',
        component:pageRemind,
        meta:{
            requiresAuth:true
        }
    },
     //page
    {
        path:'/register',
        name: 'RegisterHome',
        component:Register,
        meta:{
            requiresAuth:false
        }
    },
     //Error
    {
        path:'/:pathMatch(.*)*',
        name: 'Error',
        component:Error,
    }
]






const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to,from)=>{
    if(to.meta.requiresAuth && !localStorage.getItem('token')){
       return { name: 'Login' }
    }
    if(to.meta.requiresAuth == false && localStorage.getItem('token')){
        return { name: 'HomePage' }
    } 
 })

export default router