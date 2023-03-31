<template>
   <div class="modal__body__form">
      <form @submit.prevent="saveData()">
         <div class="form__create">
            <input class="border-input" type="text" v-model="edit.title"  placeholder="Thêm tiêu đề và thời gian"  maxlength="150"/> 
         </div>
         <div class="form__create">
            <a class="form__create-event" >Sự kiện</a>
         </div>
         <div class="form__create">
            <span class="item_icons-2"><i class="fa-sharp fa-solid fa-clock"></i></span>
            <flatPickr class="modelEvents" v-model="edit.start"  :config="configs.dateTimePicker"  placeholder="Date Time"/>
            <flatPickr class="modelEvents" v-model="edit.end"  :config="configs.dateTimePicker"  placeholder="Date Time"/>
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
 </template>
 <script>

      import flatPickr from 'vue-flatpickr-component';
      import 'flatpickr/dist/flatpickr.css';
      export default {
      name: "editModel",
      props:{
         edit:{
            type: Object,
            default: () =>{}
         }
      },
      data() {
         return {
            errorList:'',
            configs: {
               dateTimePicker: {
                  enableTime: true,
                  dateFormat: 'Y-m-d H:i'
               },
            }
         }
      },
      components:{
         flatPickr
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