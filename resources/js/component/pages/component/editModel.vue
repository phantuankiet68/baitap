<template>
    <div class="modal">

         <div class="modal__body">
             <div class="form__center">
               <span @click.prevent="closeModal"><i class="fa-solid fa-xmark"></i></span>
               <strong><i class="fa-solid fa-bars"></i></strong>
             </div>
             <ul class="alert alert-warning"  v-if="Object.keys(errorList).length > 0">
                  <li  style="color: red;" v-for="(error, index) in errorList" :key="index">{{ error[0] }}</li>
             </ul>
             <div class="modal__body__form">
                 <form @submit.prevent="saveData()">
                     <div class="form__create">
                        <input class="border-input" type="text" v-model="edit.title"  placeholder="Thêm tiêu đề và thời gian"  maxlength="150"/> 
                     </div>
                      <div class="form__create">
                        <a class="form__create-event" >Sự kiện</a>
                        <a class="form__create-remindar" @click.prevent="showEditRemind"> Lời nhắc
                        </a>
                     </div>
                     <div class="form__create">
                        <span class="item_icons-2"><i class="fa-sharp fa-solid fa-clock"></i></span>
                        <VueDatePicker class="form-control"  mode="dateTime"  v-model="edit.start" auto-apply />
                        <VueDatePicker class="form-control"  mode="dateTime" v-model="edit.end" auto-apply/>
                     </div>
                     <div class="form__create">
                        <span class="item_icons-2"><i class="fa-sharp fa-solid fa-bars-staggered"></i></span>
                        <input type="text" class="text-input" v-model="edit.desc"  placeholder="Thêm mô tả và các tệp đính kèm" maxlength="250"> 
                     </div>
                     <hr />
                     <div class="form__create">
                        <span class="item_icons-2"><i class="fa-solid fa-calendar-days"></i></span>
                        <input  type="color" v-model="edit.color" class="form__create-color" id="get" onchange="fetch()"/>
                        <input type="text" id="put" v-model="edit.color" class="hiden"/><br />
                     </div>
                     <div class="form__create">
                        <button  class="edit" @click.prevent="updateEvent()">update</button>
                        <button  class="delete" @click.prevent="deleteEvent()">delete</button>
                     </div>
                 </form>
             </div>
         </div>
    </div>
 </template>
 <script>

      import VueDatePicker from '@vuepic/vue-datepicker';
      import '@vuepic/vue-datepicker/dist/main.css'
      export default {
      name: "Model",
      props:{
         edit:{
            type: Object,
            default: () =>{}
         }
      },
      data() {
         return {
             errorList:'',
         }
      },
      components:{
         VueDatePicker 
      },
      mounted(){
        this.eventId = this.$route.params.id;
      },
      methods:{
         closeModal(){
            this.$emit('closeEdit')
         },
         showEditRemind(){
            this.$emit('showEditRemind')
         },
         updateEvent(){
            this.$emit('updateEvent')
         },
         deleteEvent(){
            this.$emit('deleteEvent')
         },
         
      }
   }
 </script>