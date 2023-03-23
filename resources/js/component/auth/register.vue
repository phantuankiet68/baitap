<template>
    <div class="main-form">
            <div class="form_login">
                <h2>Register</h2>
                <ul v-if="Object.keys(errorList).length > 0">
                    <li  style="color: red;" v-for="(error, index) in errorList" :key="index">{{ error[0] }}</li>
                 </ul>
                <form @submit.prevent="saveRegister">
                    <div class="form_login-sub">
                        <input type="text" class="text"  placeholder="Enter your name" v-model="form.name" maxlength="30"/>
                        <div class="form_login-icon">
                           <i class="fa-solid fa-envelope"></i>
                        </div>
                    </div>
                    <div class="form_login-sub">
                        <input type="text" class="text"  placeholder="Enter your email" v-model="form.email" maxlength="30"/>
                        <div class="form_login-icon">
                           <i class="fa-solid fa-envelope"></i>
                        </div>
                    </div>
                    <div class="form_login-sub">
                        <input :type="passwordFieldType" class="password" name="Password" placeholder="Mật khẩu" v-model="form.password" required="" maxlength="30" />
                        <div class="form_login-icon">
                           <i class="fa fa-unlock-alt " ></i>
                           <i class="fa-solid fa-eye after" @click="switchVisibility"></i>
                        </div>
                    </div>
                    <div class="form_login-sub">
                        <input :type="passwordFieldType" class="password"  placeholder="Enter your password" v-model="form.c_password" maxlength="30"/>
                        <div class="form_login-icon">
                           <i class="fa fa-unlock-alt"></i>
                           <i class="fa-solid fa-eye after" @click="switchVisibility"></i>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="submit_login">
                        <input type="submit" value="Sign Up">
                    </div>
                    <div class="submit_login">
                        <router-link to="/"><span>Sign In</span></router-link>
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
                   name:'tuấn Kiệt',
                   email:'admin@gmail.com',
                   password:'',
                   c_password:''
               },
               passwordFieldType: "password"
           }
       }
       ,
       methods:{
            switchVisibility() {
                this.passwordFieldType = this.passwordFieldType === "password" ? "text" : "password";
            },
            /**
             * save data category
             * @author KietPT
             */
             saveRegister(){
                var mythis = this;
                axios.post('/api/register', this.form)
                .then(response =>{
                    console.log(response.data)
                    alert(response.data.message);
                    this.form = {
                        name:'',
                        email:'',
                        password:'',
                        c_password:''
                    }
                    this.$router.push({ name: "Login" });
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