<template>

    <form action="#" @submit.prevent="login(login)">
        <div>
            <p>Correo electronico</p>
            <input type="email" name="email" v-model="this.loginData.email" placeholder="Correo electronico"/>
        </div>
        <div>
            <p>Contraseña</p>
            <input type="password" name="password" v-model="this.loginData.password" placeholder="Contraseña"/>
        </div>
        <input type="submit" value="Registrarme"/>
    </form>

</template>

<script>

    import authService from '@/services/auth';

    export default {
        name: 'LoginForm',
    
        data: function() {
            return {
                loginData:{
                    email: null,
                    password: null,
                },
                errors: {
                    email: null,
                    password: null,
                },
                status: {
                    msg: null,
                    type: 'success',
                }
            }
        },
        methods: {
            login(){
                authService.login(this.loginData.email, this.loginData.password)
                    .then(res => {
                        if(res.success){
                            this.$router.push('/');
                        }else{
                            console.log(res.errors);
                        }
                    })
            }
        }
    }


</script>