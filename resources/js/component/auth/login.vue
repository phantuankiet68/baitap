<template>
    <div class="main-form" >
           <div class="form_login">
               <h2>Login</h2>
                <div class="error-waring">
                    <span class="error-fix" v-for="(error, index) in errorList" :key="index" >{{ error }}</span>
                 </div>
               <form >
                   <div class="form_login-sub">
                       <input type="email" class="text"  v-model="form.email"   autocomplete="new-eamil"  maxlength="30" placeholder="Enter your email" />
                       <div class="form_login-icon">
                          <i class="fa-solid fa-envelope before"></i>
                       </div>
                   </div>
                   <div class="error">
                        <span v-for="(error, index) in errorEmail" :key="index">{{ error }}</span>
                   </div>
                  <div class="form_login-sub">
                        <input :type="passwordFieldType" class="password" name="password"  v-model="form.password" placeholder="Mật khẩu"   autocomplete="new-password" maxlength="30" />
                        <div class="form_login-icon">
                           <i class="fa fa-unlock-alt before" ></i>
                        </div>
                        <div class="form_login-news">
                           <i class="fa-solid fa-eye after" @click="showEyePass" v-if="showEye"></i>
                           <i class="fa-solid fa-eye-slash after" @click="hidenEyePass" v-if="hideEye"></i>
                        </div>
                    </div>
                    <div class="error">
                        <span v-for="(error, index) in errorPassword" :key="index">{{ error }}</span>
                   </div>
                   <div class="clear"></div>
                   <div class="submit_login">
                       <input type="submit" value="Sign In" @click.prevent="login">
                   </div>
                   <div class="submit_login">
                        <span>
                           <router-link to="/register"><span>Sign Up</span></router-link>
                        </span>
                   </div>
               </form>

           </div>
           <Loading :active="isLoading" 
            :can-cancel="true" 
            :is-full-page="fullPage"></Loading>
       </div>
</template>

<script >
    import Loading from 'vue3-loading-overlay';
    import 'vue3-loading-overlay/dist/vue3-loading-overlay.css';
    export default{
       name:'Register',
       components:{
         Loading
       },
       data(){
           return {
               errorList:'',
               errorEmail:'',
               errorPassword:'',
               form:{
                    email: '',
                    password: '',
               },
               passwordFieldType: "password",
               showEye:false,
               hideEye:true,
               isLoading: false,
               fullPage:true,
           }

       },
       mounted() {
         this.form.email = ""
       }
       ,
       methods:{
           
            /**
             * save data category
             * @author KietPT
             */
            showEyePass() {
                this.showEye = false,
                this.hideEye = true,
                this.passwordFieldType = this.passwordFieldType === "password" ? "text" : "password";
            },
            hidenEyePass() {
                this.showEye = true,
                this.hideEye = false,
                this.passwordFieldType = this.passwordFieldType === "password" ? "text" : "password";
            },
            login(){
                this.isLoading =true;
                var mythis = this;
                axios.post('/api/login', this.form)
                .then(response =>{
                    localStorage.setItem('token', response.data.token)
                    setTimeout(() => {this.isLoading = false},2000)
                    this.$router.push({ name: "HomePage" });

                })
                .catch(function (error){
                    if(error.response){
                        if (error.response.status == 422) {
                            mythis.errorEmail = error.response.data.errors.email;
                            mythis.errorPassword = error.response.data.errors.password;
                            mythis.isLoading = false;
                        }
                        else if (error.response.status == 401) {
                            mythis.errorList = error.response.data.errors;
                            mythis.isLoading = false;
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
