
<template>
    <div class="menu_hamburger">
        <i class="fa fa-solid fa-bars bx-menu"></i>
    </div>
    <section id="sidebar">
		<a href="#" class="brand">
            <i class="fa fa-solid fa-bars bx-menu"></i>
			<img src="../image/logo.png">
			<span class=".text-title">Lịch</span>
		</a>
		<div class="create">
			<div href="" class="create_choose" >
				<svg width="36" height="36" viewBox="0 0 36 36"><path fill="#34A853" d="M16 16v14h4V20z"></path><path fill="#4285F4" d="M30 16H20l-4 4h14z"></path><path fill="#FBBC05" d="M6 16v4h10l4-4z"></path><path fill="#EA4335" d="M20 16V6h-4v14z"></path><path fill="none" d="M0 0h36v36H0z"></path></svg>
			    <span class="create_text" @click="createPopup" >Create</span>
			</div>
		</div>
		<div class="datehome">
            <div class="subPre">
                <span class="subleft" @click="$refs.calendar.movePrev()">
                    <i class="fa-solid fa-chevron-left" @click="getPrev"></i>
                </span>
                <span class="subright"  @click="$refs.calendar.moveNext()">
                    <i class="fa-solid fa-chevron-right" @click="getNext"></i>
                </span>
            </div>
            <DatePicker v-model="date"  ref="calendar"  color="red" @dayclick="onDayClick" mode="date"  :model-config="modelConfig"/>
		</div>
		<ul class="side-menu top"> 
			<li >
				<span class="text">Lịch của tui</span>
                <i class="fa-solid fa-chevron-right"></i>
			</li>
            <li >
                
				<a >
                    <router-link to="/home">
                        <i>
                            <input type="checkbox" name=""  id="">
                        </i>
                        <span class="text">All</span>
                    </router-link>
				</a>
			</li>
            <li >
                <a >
                    <i>
                        <router-link  to="/home/event-m">
                            <input type="checkbox" id="checkbox" v-model="checked"  name="" >
                        </router-link>
                    </i>
                    <span class="text">Event</span>
				</a>
			</li>
            <li >
				<a >
                    <router-link to="/home/remind-m">
                        <i>
                            <input type="checkbox" name=""  id="">
                        </i>
                        <span class="text">Remind</span>
                    </router-link>
				</a>
			</li>
           
		</ul>
	</section>
	<!-- CONTENT -->
	<section id="content">
        
        <nav>
            <a  class="notification">
                <input type="button" class="btn-gettoday" @click="getToday" value="Hôm nay">
            </a>
            <a  class="notification">
                <i class="fas fa-solid fa-chevron-left"  @click="getNext"></i>
            </a>
            <a  class="notification">
                <i class="fas fa-solid fa-chevron-right" @click="getPrev"></i>
            </a>
            <a  class="title" >
                <span id="externalTitle" class=".fc-event-title-form">
                    Tháng {{ moment(title).format("MM, YYYY") }}
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
            <fullCalendar ref="fullCalendar"   :options="calendarOptions"  />    
        </main>
    </section>
    <div class="modal" v-if="showModel">
        <div class="modal__body">
            <div class="form__center">
                <span @click.prevent="closeModal"><i class="fa-solid fa-xmark"></i></span>
                <strong><i class="fa-solid fa-bars"></i></strong>
            </div>
            <ul  v-if="Object.keys(errorList).length > 0" style="margin: 10px 20px;">
                <li  style="color: red;font-size: 1.5rem;display: block;margin-left: 30px;" v-for="(error, index) in errorList" :key="index">{{ error[0] }}</li>
            </ul>
            <calendarModel @saveCalendar="saveCalendar" :form="newEvent"  @closeModal="closeModal" @showCR="showCR" />
        </div>
    </div>
    <div class="modal" v-if="showRemind">
        <div class="modal__body">
            <div class="form__center">
                <span @click.prevent="closeModal"><i class="fa-solid fa-xmark"></i></span>
                <strong><i class="fa-solid fa-bars"></i></strong>
            </div>
            <ul  v-if="Object.keys(errorList).length > 0" style="margin: 10px 20px;">
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
    
    export default {
        name:'Home',
        components:{
            fullCalendar,calendarModel,editModel,remindModel,editRemind,Loading
        },
        data() {
            return {
                date:null,
                title:'',
                EditEvent: false,
                EditRemind: false,
                showModel: false,
                showRemind:false,
                moment: moment,
                errorList:'',
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
                checked:true    ,
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
                    progressiveEventRendering:true
				},
                modelConfig: {
                    type: 'string',
                    mask: 'YYYY-DD-MM',
                },
                indexToUpdate: "",
                isLoading: false,
                fullPage:true,
                title: new Date(),
                datename:'tháng'
            };
           
        },
        
        mounted(){
            this.getEventSource();
            this.getInfoAdmin();    
            this.refeser();
        },
        methods:{
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
                }
            },
            showEvents(){
                this.showModel = true
                this.showRemind = false
            },
            choose(){
                const startDate = new Date();
                const endDate = new Date(new Date().setDate(startDate.getDate() + 7));
                date.value = [startDate, endDate];
            },
            getEventSource(){
                this.$data.calendarOptions.eventSources = [
                {
                    events(start, failureCallback) {
                        const token = localStorage.getItem('token')
                        axios.get('/api/home/events',{
                            headers:{
                                Authorization: ' Bearer ' + token
                            }
                        })
                        .then(response => {
                            failureCallback(response.data.events)
                        })
                    },
                    color: 'yellow'

                },
                ];
            },
            closeEditRemind(){
               this.EditRemind = false
            },
            getInfoAdmin(){
                const token = localStorage.getItem('token')
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
                this.editEvent.end = info.event.end
                this.editRemind.title = info.event._def.title
                this.editRemind.start = info.event.start
                this. errorList = ''
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

            onDayClick(e){
                const date = new Date().toString()
                let calendarApi = this.$refs.fullCalendar.getApi()
                calendarApi.gotoDate(e.id)                
                this.title = e.ariaLabel
            },
            saveRemind(){
                var mythis = this;
                this.isLoading =true;
                axios.post('/api/remind/create', this.newRemind)
                .then(response =>{
                    alert(response.data.message);
                    this.closeCR();
                    this.getEventSource();
                    setTimeout(() => {this.isLoading = false},2000)
                })
                .catch(function (error){
                    console.log(error.response)
                    if(error.response){
                        if (error.response.status == 422) {
                            mythis.errorList = error.response.data.errors;
                            mythis.isLoading = false
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
                axios.post('/api/event/create', this.newEvent)
                .then(response =>{
                    alert(response.data.message);
                    this.closeModal();
                    setTimeout(() => {this.isLoading = false},2000)
                    this.getEventSource();
                })
                .catch(function (error){
                    if(error.response){
                    if (error.response.status == 422) {
                        mythis.errorList = error.response.data.errors;
                        mythis.isLoading = false
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
                var edit = '/api/event/edit/' + this.indexToUpdate;
                axios.put(edit, this.editEvent)
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
                var edit = '/api/remind/edit/' + this.indexToUpdate;
                axios.put(edit, this.editRemind)
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
                var remove = '/api/event/edit/' + this.indexToUpdate;
                axios.delete(remove)
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
            reset(){
                this.newEvent = {
                    title:null,
                    start:null,
                    end:null,
                    desc:null,
                    color:null
                }
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
			getNext() {
				let calendarApi = this.$refs.fullCalendar.getApi()
                calendarApi.next()
			},
			getPrev() {
				let calendarApi = this.$refs.fullCalendar.getApi()
                calendarApi.prev()
			},
			getToday() {
				let calendarApi = this.$refs.fullCalendar.getApi()
                calendarApi.today()
			},
            closeCR(){
                this.showRemind = false
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
            },
            closeEdit(arg){
                this.EditEvent = false;
            },
        },
        watch: {
            indexToUpdate() {
                return this.indexToUpdate;
            }
        }
    }
</script >   