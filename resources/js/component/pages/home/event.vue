
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
                    <router-link to="/home/remind-m">
                        <i>
                            <input type="checkbox" name=""  id="">
                        </i>
                        <span class="text">reminder</span>
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
                    <span class="text">event</span>
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
            <a  class="notification" >
                <span id="externalTitle" class=".fc-event-title-form">
 
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
    <calendarModel @saveCalendar="saveCalendar" v-if="showModel"  :form="newEvent"  @closeModal="closeModal" />
    <editModel  @updateEvent="updateEvent"  @deleteEvent="deleteEvent"   v-if="EditEvent"  :edit="editEvent"  @closeEdit="closeEdit" />
</template>

<script >
	import fullCalendar from '@fullcalendar/vue3'
    import calendarModel from '../component/calendarModel.vue'
    import editModel from '../component/editModel.vue'
	import dayGridPlugin from '@fullcalendar/daygrid'
	import interactionPlugin from '@fullcalendar/interaction'
	import timeGrid from '@fullcalendar/timegrid'
    import allLocales from '@fullcalendar/core/locales-all';
    export default {
        name:'Home',
        components:{
            fullCalendar,calendarModel,editModel
        },
        data() {
            return {
                date: null,
                EditEvent: false,
                showModel: false,
                checked:true,
                newEvent:{
                    title:'',
                    start:'',
                    end:'',
                    desc:'',
                    color:'',
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
				calendarOptions: {
					plugins: [ interactionPlugin,dayGridPlugin,timeGrid ],
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
				},
                modelConfig: {
                    type: 'string',
                    mask: 'YYYY-DD-MM',
                },
                indexToUpdate: "",
            };
           
        },
        
        mounted(){
            this.getEvent();
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
                ];
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
                })
            },
            createPopup(){
                this.showModel = true
            },
            handleEventClick(info){
                this.EditEvent = true
                this.reset();
                this.indexToUpdate = info.event.id
                this.editEvent.title = info.event._def.title
                this.editEvent.start = info.event.start
                this.editEvent.end = info.event.end
                this.editEvent.desc = info.event._def.extendedProps.desc
                this.editEvent.color = info.event.color
                console.log(info)

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
                calendarApi.changeView('dayGridYear');
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
			},
            setModel(obj){
                let dateTimeStart = obj.startStr.substring(0, 10)
                let dateTimeEnd = obj.endStr.substring(0, 10)
                this.newEvent.start = dateTimeStart
                this.newEvent.end = dateTimeEnd
            },

            onDayClick(){
                let calendarApi = this.$refs.fullCalendar.getApi()
                calendarApi.gotoDate(this.date)
            },
            saveCalendar(){
                var mythis = this;
                axios.post('/api/event/create', this.newEvent)
                .then(response =>{
                    alert(response.data.message);
                    this.closeModal();
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
                var edit = '/api/event/edit/' + this.indexToUpdate;
                axios.put(edit, this.editEvent)
               .then(response =>{
                   alert(response.data.message);
                   this.closeEdit();
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