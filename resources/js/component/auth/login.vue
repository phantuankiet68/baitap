<template>
    <div class="main-form">
           <div class="form_login">
               <h2>Login</h2>
               <ul v-if="Object.keys(errorList).length > 0">
                    <li  style="color: red;" v-for="(error, index) in errorList" :key="index">{{ error[0] }}</li>
                 </ul>
               <form @submit.prevent="login">
                   <div class="form_login-sub">
                       <input type="email" class="text"  placeholder="Enter your email" v-model="form.email" maxlength="30" />
                       <div class="form_login-icon">
                          <i class="fa-solid fa-envelope"></i>
                       </div>
                   </div>
                  <div class="form_login-sub">
                        <input :type="passwordFieldType" class="password" name="Password" v-model="form.password" placeholder="Mật khẩu" required="" maxlength="30" />
                        <div class="form_login-icon">
                           <i class="fa fa-unlock-alt " ></i>
                           <i class="fa-solid fa-eye after" @click="switchVisibility"></i>
                        </div>
                    </div>
                   <div class="clear"></div>
                   <div class="submit_login">
                       <input type="submit" value="Sign In">
                   </div>
                   <div class="submit_login">
                        <span>
                           <router-link to="/register"><span>Sign Up</span></router-link>
                        </span>
                   </div>
               </form>

           </div>
       </div>
</template>

<script >
    export default{
       name:'Register',
       data(){
           return {
               errorList:'',
               form:{
                    email: 'admin@gmail.com',
                    password: '',
               },
               passwordFieldType: "password"
           }
       }
       ,
       methods:{
           
            /**
             * save data category
             * @author KietPT
             */
             switchVisibility() {
                this.passwordFieldType = this.passwordFieldType === "password" ? "text" : "password";
            },
             login(){
                var mythis = this;
                axios.post('/api/login', this.form)
                .then(response =>{
                    localStorage.setItem('token', response.data.token)
                    this.$router.push({ name: "HomePage" });

                })
                .catch(function (error){
                    if(error.response){
                        if (error.response.status == 422) {
                            mythis.errorList = error.response.data.errors;
                        }
                        else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                    }
                })
            },
          
           
       }

   }
</script>
