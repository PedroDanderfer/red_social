<template>
    <Header/>
    <div class="loginDisplay">
        <div>
            <h2>Ingresá</h2>
            <p>Logeate con tu cuenta para poder empezar a compartir!</p>
        </div>
        <div>
            <LoginForm/>
            <p><router-link :to="`/register`">No tengo una cuenta</router-link></p>
        </div>
    </div>
</template>

<script>
import LoginForm from '@/components/LoginForm.vue';
import authService from '@/services/auth';
import Header from '@/components/Header.vue';

export default {
  name: 'Login',
   components: {
    LoginForm, Header
  },
  
}
</script>

<style lang="scss">
    .loginDisplay{
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
                grid-template-rows:1fr 1fr 1fr;
                grid-gap:10px;
                >div{
                    display:block;
                    width:100%;
                    padding: 10px 15px 10px 15px;

                    >input[type=email], >input[type=password]{
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
                        border: 1px solid #33ff64;
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