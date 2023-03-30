<template>
   <div class="modal__body__form">
      <form >
         <div class="form__create">
            <input class="border-input"  type="text" v-model="editr.title" placeholder="Thêm tiêu đề"  maxlength="150"> 
         </div>
         <div class="form__create">
            <a class="form__create-event">Lời nhắc</a>
         </div>
         <div class="form__create">
            <span class="item_icons-1"><i class="fa-sharp fa-solid fa-clock"></i></span>
            <VueDatePicker class="form-control" mode="dateTime" v-model="editr.start" auto-apply/>
         </div>
         <div class="form__create">
            <button  class="edit" @click.prevent="updateRemind()">update</button>
            <button  class="delete" @click.prevent="deleteEvent()">delete</button>
         </div>
      </form>
   </div>
 </template>

 <script>

   import VueDatePicker from '@vuepic/vue-datepicker';
   import '@vuepic/vue-datepicker/dist/main.css'

   export default{
      name: "Model",
      props:{
        editr:{
            type: Object,
            default: () =>{}
         }
      },
      components:{
         VueDatePicker
      },
      data() {
         return {
             errorList:'',
         }
      },
      methods:{  
        updateRemind(){
            this.$emit('updateRemind')
        },
        deleteEvent(){
            this.$emit('deleteEvent')
        },
        closeEditRemind(){
            this.$emit('closeEditRemind')
        },
        saveRemind(){
             this.$emit('saveRemind')
        },
   }
}
 </script>