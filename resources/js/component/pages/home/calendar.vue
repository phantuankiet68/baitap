
<template>
    <div class="menu_hamburger">
        <i class="fa fa-solid fa-bars bx-menu"></i>
    </div>
    <section id="sidebar">
        <sidebar @createPopup="createPopup" />
        <div class="datehome">
            <DatePicker v-model="date"  ref="calendar"  color="red" @dayclick="onDayClick" mode="date"  :model-config="modelConfig"/>
		</div>
		<ul class="side-menu top"> 
			<li >
				<span class="text">Lịch của tui</span>
                <i class="fa-solid fa-chevron-right"></i>
			</li>
            <li >
				<a >
                    <i>
                        <router-link  to="/home">
                            <input type="checkbox" id="checkbox" v-model="checked"  name="" >
                        </router-link>
                    </i>
                    <span class="text">All</span>
				</a>
			</li>
            <li >
				<a >
                    <router-link to="/home/event-m">
                        <i>
                            <input type="checkbox" name=""  id="">
                        </i>
                        <span class="text">Event</span>
                    </router-link>
				</a>
			</li>
            <li >
				<a >
                    <router-link to="/home/remind-m">
                        <i>
                            <input type="checkbox" name=""  id="">
                        </i>
                        <span class="text">Reminder</span>
                    </router-link>
				</a>
			</li>
           
		</ul>
    </section>
	<!-- CONTENT -->
	<section id="content">    
        <nav>
            <a  class="notification" >
                <input type="button" class="btn-gettoday" @click="getToday" value="Hôm nay">
            </a>
            <a  class="notification" @click="$refs.calendar.movePrev()">
                <i class="fas fa-solid fa-chevron-left"  @click="getPrev"></i>
            </a>
            <a  class="notification" @click="$refs.calendar.moveNext()">
                <i class="fas fa-solid fa-chevron-right" @click="getNext"></i>
            </a>
            <a  class="title" >
                <span id="externalTitle" class=".fc-event-title-form">
                   Tháng {{ moment(dateNowHome).format("MM, YYYY") }}
                </span>
            </a>
            <router-link to="/home" class="exit-controll"><i class='bx bx-left-arrow-alt'></i></router-link>
            <form action="#">
                <div class="form-input">
                </div>
            </form>
            <a href="#" class="notification">
                <i class="fa-solid fa-magnifying-glass"></i>
            </a>
            <a href="#" class="notification">
                <i class="fa-solid fa-circle-info"></i>
            </a>
            <a href="#" class="notification">
                <i class="fa-solid fa-gear"></i>
            </a>
            <div class="selected">
                <span class="selected__choose">
                    {{ datename }}
                    <i class="fa-sharp fa-solid fa-caret-down"></i>
                </span>
                <div class="sub__choose-item" id="clickSelected">
                    <div class="sub__choose-create">
                        <span class="sub_create-link" @click="getDay">
                            Ngày
                        </span>
                        <span class="sub_create-link" @click="getMonth">
                           Tháng
                        </span>
                        <span class="sub_create-link" @click="getYears">
                            Năm
                        </span>
                    </div>
                </div>     
            </div>
            <h3>{{ name }}</h3>
            <a href="#" class="profile">
                <img src="../image/avata.jpg">
                <div class="sub_create-img" id="clickMenu">
                    <div class="sub_create">
                        <a @click="logout" class="sub_create-link">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <p >
                                Đăng xuất
                            </p>
                        </a>
                    </div>
                </div>
            </a>
        </nav>
        <main class="main" @click.prevent="closeModal">
            <fullCalendar ref="fullCalendar"   :options="calendarOptions"/>    
        </main>
    </section>
    <div class="modal" v-if="showModel">
        <div class="modal__body">
            <div class="form__center">
                <span @click.prevent="closeModal"><i class="fa-solid fa-xmark"></i></span>
                <strong><i class="fa-solid fa-bars"></i></strong>
            </div>
            <ul v-if="Object.keys(errorList).length > 0" style=" margin:20px 50px; ">
                <li  style="color: red; padding:1px;font-size: 1.5rem; line-height: normal;display: block;"  v-for="(error, index) in errorList" :key="index" >
                    <span > {{ error[0] }}</span>
                </li>
            </ul>
            <calendarModel @saveCalendar="saveCalendar" :form="newEvent"  @closeModal="closeModal" @showCR="showCR" />
        </div>
    </div>
    <div class="modal" v-if="showRemind">
        <div class="modal__body">
            <div class="form__center">
                <span @click.prevent="closeCR"><i class="fa-solid fa-xmark"></i></span>
                <strong><i class="fa-solid fa-bars"></i></strong>
            </div>
            <ul style="margin: 10px 20px;">
                <li  style="color: red;font-size: 1.6rem;display: block;margin-left: 30px;margin-top: 10px;" v-for="(error, index) in errorList" :key="index">{{ error[0] }}</li>
            </ul>
            <remindModel v-if="showRemind" @closeCR="closeCR" :remind="newRemind" @saveRemind="saveRemind" @showEvents="showEvents"/>
        </div>
    </div>
    <div class="modal" v-if="EditEvent">
        <div class="modal__body">
            <div class="form__center">
                <span @click.prevent="closeEdit"><i class="fa-solid fa-xmark"></i></span>
                <strong><i class="fa-solid fa-bars"></i></strong>
            </div>
            <ul  v-if="Object.keys(errorList).length > 0" style="margin: 10px 20px;">
                <li  style="color: red;font-size: 1.5rem;display: block;    margin-left: 30px;" v-for="(error, index) in errorList" :key="index">{{ error[0] }}</li>
            </ul>
            <editModel @showEditRemind="showEditRemind" @updateEvent="updateEvent"  @deleteEvent="deleteEvent"   :edit="editEvent"  @closeEdit="closeEdit" />
        </div>
    </div>
    <div class="modal" v-if="EditRemind">
        <div class="modal__body">
            <div class="form__center">
                <span @click.prevent="closeEditRemind"><i class="fa-solid fa-xmark"></i></span>
                <strong><i class="fa-solid fa-bars"></i></strong>
            </div>
            <ul  v-if="Object.keys(errorList).length > 0" style="margin: 10px 20px;">
                <li  style="color: red;font-size: 1.5rem;display: block;    margin-left: 30px;" v-for="(error, index) in errorList" :key="index">{{ error[0] }}</li>
            </ul>
            <editRemind @updateRemind="updateRemind"  @deleteEvent="deleteEvent"  :editr="editRemind"  @closeEditRemind="closeEditRemind" />
        </div>
    </div>
    <Loading :active="isLoading" 
        :can-cancel="true" 
        :is-full-page="fullPage"></Loading>
</template>
<script >
    import moment from "moment";
    import sidebar from './layouts/sidebar.vue'
	import fullCalendar from '@fullcalendar/vue3'
    import calendarModel from '@/pages/component/calendarModel.vue'
    import remindModel from '@/pages/component/remindModel.vue'
    import editModel from '@/pages/component/editModel.vue'
    import editRemind from '@/pages/component/editRemind.vue'
	import dayGridPlugin from '@fullcalendar/daygrid'
	import interactionPlugin, { Draggable } from '@fullcalendar/interaction'
    import multiMonthPlugin from '@fullcalendar/multimonth'
	import timeGrid from '@fullcalendar/timegrid'
    import allLocales from '@fullcalendar/core/locales-all';
    import Loading from 'vue3-loading-overlay';
    import 'vue3-loading-overlay/dist/vue3-loading-overlay.css';
    import {TOKEN} from '../../constant/index.js'
    
    export default {
        name:'Home',
        components:{
            fullCalendar,calendarModel,editModel,remindModel,editRemind,Loading,sidebar
        },
        data() {
            return {
                date:null,
                dateNowHome:null,
                EditEvent: false,
                EditRemind: false,
                showModel: false,
                showRemind:false,
                moment: moment,
                errorList:[],
                newEvent:{
                    isEvents:'1',
                    title:'',
                    start:'',
                    end:'',
                    desc:'',
                    color:'',
                    user_id:''
                },
                newRemind:{
                    isEvents:'2',
                    title:'',
                    start:'',
                    color:'#6200ee',
                    desc:'1',
                    user_id:''
                },
                editEvent:{
                    title:'',
                    start:'',
                    end:'',
                    desc:'',
                    color:'',
                    user_id:''
                },
                editRemind:{
                    title:'',
                    start:'',
                },
                token:[],
                users:[],
                name:'',
				calendarOptions: {
					plugins: [ interactionPlugin,dayGridPlugin,timeGrid,multiMonthPlugin ],
                    initialView: 'dayGridMonth',
                    dateClick: this.handleDateClick,
                    eventClick: this.handleEventClick,
                    locales:allLocales,
                    locale:'en-US',
                    timeZone: 'local',
                    editable: true,
                    indexToUpdate: "",
                    timeZone: 'UTC',
                    showNonCurrentDates:true,
                    datesSet:this.handleDateProfile,
                    events: [],
				},
                indexToUpdate: "",
                isLoading: false,
                fullPage:true,
                datename:'tháng',
                dataCalendar: [],
                modelConfig: {
                    type: 'string',
                    mask: 'YYYY-DD-MM',
                },
                date:'',
                checked:true  
            };
           
        },
        
        mounted(){
            this.getEventSource();
            this.getInfoAdmin();    
            this.refeser();
        },
        methods:{
            handleDateProfile(e){
                this.dateNowHome = e.startStr
            },
            refeser(){
                this.newEvent = {
                    isEvents:'1',
                    title:'',
                    start:'',
                    end:'',
                    desc:'',
                    color:'',
                    user_id:''
                },
                this.newRemind ={
                    isEvents:'2',
                    title:'',
                    start:'',
                    color:'#6200ee',
                    desc:'1',
                    user_id:''
                },
                this.errorList = ""
            },
            showEvents(){
                this.showModel = true
                this.showRemind = false
                this.error[0] = null
            },
            getEventSource(){
                // this.$data.calendarOptions.eventSources = [
                // {
                //     events(start, Callback) {
                        const token = localStorage.getItem(TOKEN)
                        axios.get('/api/home',{
                            headers:{
                                Authorization: ' Bearer ' + token
                            }
                        })
                        .then(response => {
                            const events = [];
                            response.data.events.forEach(item => {
                                events.push({
                                    ...item,
                                    dateEndCustom: item.end,
                                });
                            });
                            this.calendarOptions.events = events;
                            // Callback(response.data.events)
                        })
                //     },
                //     color: 'yellow'

                // },
                // ];
            },
            getInfoAdmin(){
                const token = localStorage.getItem(TOKEN)
                axios.get('/api/user',{
                    headers:{
                        Authorization: ' Bearer ' + token
                    }
                })
                .then(response => {
                   this.newEvent.user_id = response.data[0].id;
                   this.newRemind.user_id = response.data[0].id;
                   this.name = response.data[0].email;
                })
            },
            createPopup(){
                this.showModel = true
                this.refeser();
            },
            handleEventClick(info){
                if(info.event._def.extendedProps.isEvents == 1){
                    this.EditEvent = true
                }
                if(info.event._def.extendedProps.isEvents == 2){
                    this.EditRemind = true
                }
                this.indexToUpdate = info.event.id
                this.editEvent.title = info.event._def.title
                this.editEvent.desc = info.event._def.extendedProps.desc
                this.editEvent.start = info.event.start
                this.editEvent.color = info.event.backgroundColor
                this.editEvent.end = info.event._def.extendedProps.dateEndCustom
                this.editRemind.title = info.event._def.title
                this.editRemind.start = info.event.start
            },
           
            handleDateClick(e){
                this.showModel = true
                this.setModel(e)
                this.refeser();
			},
            refeser(){
                    this.newEvent.title = null,
                    this.newEvent.desc =  null,
                    this.newEvent.color =  null,
                    this.newRemind.title=  null
            },
            setModel(obj){
                let dateTimeStart = obj.dateStr.toLocaleString()
                let dateTimeEnd = obj.dateStr.toLocaleString()
                this.newEvent.start = dateTimeStart
                this.newEvent.end = dateTimeEnd
                this.newRemind.start = dateTimeStart
                if(this.showModel){
                    this.newEvent.isEvents = "1"
                }
                else{
                    this.newEvent.isEvents = "2"
                }
            },

            saveRemind(){
                var mythis = this;
                this.isLoading =true;
                const token = localStorage.getItem(TOKEN)
                axios.post('/api/remind/create', this.newRemind,{
                    headers:{
                        Authorization: ' Bearer ' + token
                    }
                })
                .then(response =>{
                    alert(response.data.message);
                    setTimeout(() => {this.isLoading = false},2000)
                    this.closeCR();
                    this.getEventSource();
                    this
                })
                .catch(function (error){
                    console.log(error.response)
                    if(error.response){
                        if (error.response.status == 422) {
                            mythis.errorList = error.response.data.errors;
                            setTimeout(() => {mythis.isLoading = false},2000)
                        }
                        else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                    }
                })
            },
            saveCalendar(){
                var mythis = this;
                this.isLoading =true;
                const token = localStorage.getItem(TOKEN)
                axios.post('/api/event/create', this.newEvent,{
                    headers:{
                        Authorization: ' Bearer ' + token
                    }
                })
                .then(response =>{
                    setTimeout(() => {this.isLoading = false},2000)
                    alert(response.data.message);
                    this.closeModal();
                    this.getEventSource();
                })
                .catch(function (error){
                    if(error.response){
                    if (error.response.status == 422) {
                        mythis.errorList = error.response.data.errors;
                        setTimeout(() => {mythis.isLoading = false},2000)
                    }
                    else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                }
                })
            },
            updateEvent() {
                var mythis = this;
                this.isLoading =true;
                const token = localStorage.getItem(TOKEN)
                var edit = '/api/event/edit/' + this.indexToUpdate;
                axios.put(edit, this.editEvent,{
                    headers:{
                        Authorization: ' Bearer ' + token
                    }
                })
               .then(response =>{
                   alert(response.data.message);
                   this.closeEdit();
                   this.getEventSource();
                   setTimeout(() => {this.isLoading = false},2000)
               })
               .catch(function (error){
                   if(error.response){
                       if (error.response.status == 404) {
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
            updateRemind() {
                this.isLoading =true;
                var mythis = this;
                const token = localStorage.getItem(TOKEN)
                var edit = '/api/remind/edit/' + this.indexToUpdate;
                axios.put(edit, this.editRemind,{
                    headers:{
                        Authorization: ' Bearer ' + token
                    }
                })
               .then(response =>{
                   alert(response.data.message);
                   this. closeEditRemind();
                   this.loading = false
                   this.getEventSource();
                   setTimeout(() => {this.isLoading = false},2000)

               })
               .catch(function (error){
                   if(error.response){
                       if (error.response.status == 404) {
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

            deleteEvent() {
                this.isLoading =true;
                const token = localStorage.getItem(TOKEN)
                var remove = '/api/event/edit/' + this.indexToUpdate;
                axios.delete(remove,{
                    headers:{
                        Authorization: ' Bearer ' + token
                    }
                })
               .then(response =>{
                   alert(response.data.message);
                   this.closeEdit();
                   this.getEventSource();
                   setTimeout(() => {this.isLoading = false},2000)
               })
               .catch(function (error){
                  console.log('Không thể xóa')
               })
            },
           
            logout(){
                localStorage.removeItem('token')
                this.$router.push("/")
            },
            getDay() {
				let calendarApi = this.$refs.fullCalendar.getApi();
                calendarApi.changeView('timeGridDay');
                this.datename = "Ngày"
			},
            getMonth() {
				let calendarApi = this.$refs.fullCalendar.getApi();
                calendarApi.changeView('dayGridMonth');
                this.datename = "Tháng"
			},
			getYears() {
				let calendarApi = this.$refs.fullCalendar.getApi();
                calendarApi.changeView('multiMonthYear');
                this.datename = "Năm"
			},
			getNext(e) {
				let calendarApi = this.$refs.fullCalendar.getApi()
                calendarApi.next()
                
			},
			getPrev(e) {
				let calendarApi = this.$refs.fullCalendar.getApi()
                calendarApi.prev()
			},
			getToday() {
				let calendarApi = this.$refs.fullCalendar.getApi()
                calendarApi.today()
                
			},
            closeCR(){
                this.showRemind = false
                this.errorList = ""
            },
            showCR(){
               this.showRemind = true
               this.showModel = false;
            },
            showEditRemind(){
                this.EditRemind = true
                this.EditEvent = false;
            },
            closeModal(arg){
                this.showModel = false;
                this.errorList = ""
            },
            closeEdit(arg){
                this.EditEvent = false;
            },
            onDayClick(e){
                const date = new Date().toString()
                let calendarApi = this.$refs.fullCalendar.getApi()
                calendarApi.gotoDate(e.id)                
            },
            closeEditRemind(){
               this.EditRemind = false
            },
        },
        watch: {
            indexToUpdate() {
                return this.indexToUpdate;
            }
        }
    }
</script >   