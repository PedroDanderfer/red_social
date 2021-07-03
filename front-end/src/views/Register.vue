<template>
    <Header/>
    <div class="registerDisplay">
        <Notification v-if="notification.status !== null" :text="notification.message" :type="notification.status"></Notification>
        <div>
            <h2>Registrate</h2>
            <p>Ingresá a la red social donde mejor podes comunicar lo que pensas</p>
        </div>
        <div>
            <RegisterForm 
                @registrado="auth($event)"
            />
            <p><router-link :to="`/login`">Ya tengo cuenta</router-link></p>
        </div>
    </div>
</template>

<script>
import RegisterForm from '@/components/RegisterForm.vue';
import authService from '@/services/auth';
import Header from '@/components/Header.vue';
import Notification from '@/components/Notification.vue';

export default {
  name: 'Register',
   components: {
    RegisterForm, Header, Notification
  },
  data:function(){
      return{
          notification:{
              status:null,
              message:null
          }
      }
  },
  methods:{
      auth (credentials){
          authService.login(credentials.email, credentials.password)
            .then(res => {
                if(res.success){
                    this.$router.push('/');
                }else{
                    if(res.errors){
                        this.notification.status = 'error';
                        this.notification.message = res.error;
                    }else{
                        this.notification.status = 'error';
                        this.notification.message = 'Oops... ocurrio un problema';
                    }
                }
            })
      }
  }
}
</script>
<style lang="scss">

    .registerDisplay{
        display:block;
        width:100%;
        height:calc(100vh - 50px);
        overflow-y:scroll;
        padding: 10px 10px 10px 10px;

        >div:first-of-type{
            padding: 10px 15px 10px 15px;
            display:block;

            >p{
                margin-top:2px;
            }
        }

        >div:last-of-type{
            >form{
                display:grid;
                grid-template-columns:1fr;
                grid-template-rows:1fr 1fr 1fr 1fr 1fr 1fr 1fr;
                grid-gap:10px;
                >div{
                    display:block;
                    width:100%;
                    padding: 10px 15px 10px 15px;

                    >input[type=text],>input[type=email], >input[type=password]{
                        width:100%;
                        height:35px;
                        outline:none;
                        border:1px solid rgba(0, 0, 0, 0.3);
                        border-radius:5px;
                        margin-top: 3px;
                        padding:5px 5px 5px 5px;
                    }

                    >input[type=submit]{
                        width:100%;
                        height: 35px;
                        background-color: #33ff64;
                        outline:none;
                        border: 1px solid lime;
                        border-radius: 5px;
                        font-size:15px;
                    }
                }
            }

            >p{
                width:90%;
                height: 35px;
                margin-left:auto;
                margin-right:auto;
                >a{
                    display:block;
                    text-align:center;
                    text-decoration:none;
                    color:black;
                    height:35px;
                    width:100%;
                    padding-top:8px;
                    font-size:14px;
                }
            }
        }
    }

</style>
