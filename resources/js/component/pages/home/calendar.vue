
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

            <DatePicker v-model="date" @dayclick="onDayClick"  mode="date" :model-config="modelConfig"/>
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
                    <router-link to="/home/remind-m">
                        <i>
                            <input type="checkbox" name=""  id="">
                        </i>
                        <span class="text">Reminder</span>
                    </router-link>
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
                    {{ moment(title).format("DD-MM-YYYY") }}
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
                <span class="selected__choose">tháng
                    <i class="fa-sharp fa-solid fa-caret-down"></i>
                </span>
                <div class="sub__choose-item" id="clickSelected">
                    <div class="sub__choose-create">
                        <span class="sub_create-link" @click="getDay">
                            Day
                        </span>
                        <span class="sub_create-link" @click="getMonth">
                           Month 
                        </span>
                        <span class="sub_create-link" @click="getYears">
                            Year
                        </span>
                    </div>
                </div>     
            </div>
            
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
            <fullCalendar ref="fullCalendar"  :options="calendarOptions"  />    
        </main>
    </section>
    <calendarModel @saveCalendar="saveCalendar" v-if="showModel"  :form="newEvent"  @closeModal="closeModal" @showCR="showCR"/>
    <remindModel v-if="showRemind" @closeCR="closeCR" :remind="newRemind" @saveRemind="saveRemind"/>
    <editModel @showEditRemind="showEditRemind" @updateEvent="updateEvent"  @deleteEvent="deleteEvent"   v-if="EditEvent"  :edit="editEvent"  @closeEdit="closeEdit" />
    <editRemind  v-if="EditRemind"  @updateRemind="updateRemind"  @deleteRemind="deleteRemind"  :editr="editRemind"  @closeEditRemind="closeEditRemind" />
    <Loading :active="isLoading" 
        :can-cancel="true" 
        :is-full-page="fullPage"></Loading>
    </template>

<script >
    import moment from "moment";
	import fullCalendar from '@fullcalendar/vue3'
    import calendarModel from '../component/calendarModel.vue'
    import remindModel from '../component/remindModel.vue'
    import editModel from '../component/editModel.vue'
    import editRemind from '../component/editRemind.vue'
	import dayGridPlugin from '@fullcalendar/daygrid'
	import interactionPlugin from '@fullcalendar/interaction'
    import multiMonthPlugin from '@fullcalendar/multimonth'
	import timeGrid from '@fullcalendar/timegrid'
    import allLocales from '@fullcalendar/core/locales-all';
    import Loading from 'vue3-loading-overlay';
    // Import stylesheet
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
                newEvent:{
                    title:'',
                    start:'',
                    end:'',
                    desc:'',
                    color:'',
                    user_id:''
                },
                newRemind:{
                    title:'',
                    start:'',
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
                isEvents:1,
                token:[],
                users:[],
                checked:true    ,
				calendarOptions: {
					plugins: [ interactionPlugin,dayGridPlugin,timeGrid,multiMonthPlugin ],
                    initialView: 'dayGridMonth',
                    eventClick: this.handleEventClick,
                    select: this.handleDateSelect,
                    locales:allLocales,
                    locale:'en-US',
                    timeZone: 'local',
                    selectable: true,
                    editable: true,
                    indexToUpdate: "",
                    slotEventOverlap: false,
                    datesSet: this.handleMonthChange,
                    droppable: true
				},
                modelConfig: {
                    type: 'string',
                    mask: 'YYYY-MM-DD',
                },
                indexToUpdate: "",
                isLoading: false,
                fullPage:true,
            };
           
        },
        
        mounted(){
            this.getEvent();
            this.getInfoAdmin();        
        },
        methods:{
            getEvent(){
                this.$data.calendarOptions.eventSources = [
                {
                    events(start, callback) {
                        const token = localStorage.getItem('token')
                        axios.get('/api/home',{
                            headers:{
                                Authorization: ' Bearer ' + token
                            }
                        })
                        .then(response => {
                                callback(response.data.events)
                        })
                    }
                },
                {
                    events(start, callback) {
                        const token = localStorage.getItem('token')
                        axios.get('/api/home',{
                            headers:{
                                Authorization: ' Bearer ' + token
                            }
                        })
                        .then(response => {
                            callback(response.data.reminds)
                        })
                    }
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
                })
            },
            createPopup(){
                this.showModel = true
            },
            handleEventClick(info){
                this.EditEvent = true
                this.reset();
                this.indexToUpdate = info.event.id
                this.editRemind.title = info.event.title
                this.editRemind.start = info.event.start
                this.editEvent.title = info.event._def.title
                this.editEvent.start = info.event.start
                this.editEvent.end = info.event.end
                this.editEvent.desc = info.event._def.extendedProps.desc
                this.editEvent.color = info.event.backgroundColor
            },
            getDay() {
				let calendarApi = this.$refs.fullCalendar.getApi();
                calendarApi.changeView('timeGridDay');
			},
            getMonth() {
				let calendarApi = this.$refs.fullCalendar.getApi();
                calendarApi.changeView('dayGridMonth');
			},
			getYears() {
				let calendarApi = this.$refs.fullCalendar.getApi();
                calendarApi.changeView('multiMonthYear');
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
            handleDateSelect(e){
                this.showModel = true
                this.setModel(e)
                this.title = e.start.getTime();
                this.refeser()
			},
            refeser(){
                    this.newEvent.title = null,
                    this.newEvent.desc =  null,
                    this.newEvent.color =  null,
                    this.newRemind.title=  null
            },
            setModel(obj){
                let dateTimeStart = obj.startStr.toLocaleString()
                let dateTimeEnd = obj.endStr.toLocaleString()
                this.newEvent.start = dateTimeStart
                this.newEvent.end = dateTimeEnd
                this.newRemind.start = dateTimeStart
            },

            onDayClick(e){
                const date = new Date().toString()
                let calendarApi = this.$refs.fullCalendar.getApi()
                calendarApi.gotoDate(this.date)
            },
            saveRemind(){
                var mythis = this;
                this.isLoading =true;
                axios.post('/api/remind/create', this.newRemind)
                .then(response =>{
                    alert(response.data.message);
                    this.closeCR();
                    this.getEvent();
                    setTimeout(() => {this.isLoading = false},2000)
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
            saveCalendar(){
                var mythis = this;
                this.isLoading =true;
                axios.post('/api/event/create', this.newEvent)
                .then(response =>{
                    alert(response.data.message);
                    this.closeModal();
                    setTimeout(() => {this.isLoading = false},2000)
                    this.getEvent();
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
            updateEvent() {
                var mythis = this;
                this.isLoading =true;
                var edit = '/api/event/edit/' + this.indexToUpdate;
                axios.put(edit, this.editEvent)
               .then(response =>{
                   alert(response.data.message);
                   this.closeEdit();
                   this.getEvent();
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
                var mythis = this;
                var edit = '/api/remind/edit/' + this.indexToUpdate;
                axios.put(edit, this.editRemind)
               .then(response =>{
                   alert(response.data.message);
                   this. closeEditRemind();
                   this.loading = false
                   this.getEvent();

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
                var remove = '/api/event/edit/' + this.indexToUpdate;
                axios.delete(remove)
               .then(response =>{
                   alert(response.data.message);
                   this.closeEdit();
                   this.loading = false
                   this.getEvent();

               })
               .catch(function (error){
                  console.log('Không thể xóa')
               })
            },
            deleteRemind() {
                var remove = '/api/remind/edit/' + this.indexToUpdate;
                axios.delete(remove)
               .then(response =>{
                   alert(response.data.message);
                   this. closeEditRemind();
                   this.loading = false
                   this.getEvent();

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