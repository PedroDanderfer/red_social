<template>

    <form action="#" @submit.prevent="login(login)">
        <div>
            <p>Correo electronico</p>
            <input type="email" name="email" v-model="this.loginData.email" placeholder="Correo electronico"/>
            <ul v-if="errors.email.status === 'error'" class="errorForm">
                <li v-for="error in errors.email.messages"><p>{{ error }}</p></li>
            </ul>
        </div>
        <div>
            <p>Contraseña</p>
            <input type="password" name="password" v-model="this.loginData.password" placeholder="Contraseña"/>
            <ul v-if="errors.password.status === 'error'" class="errorForm">
                <li v-for="error in errors.password.messages"><p>{{ error }}</p></li>
            </ul>
        </div>
        <div>
            <input type="submit" value="Ingresar"/>
        </div>
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
                    email: {
                        status:null,
                        messages:[]
                    },
                    password: {
                        status:null,
                        messages:[]
                    },
                },
                status: {
                    msg: null,
                    type: 'success',
                }
            }
        },
        methods: {
            login(){

                this.errors.email.status = null;
                this.errors.email.messages = [];

                this.errors.password.status = null;
                this.errors.password.messages = [];

                authService.login(this.loginData.email, this.loginData.password)
                    .then(res => {
                        if(res.success){
                            this.$router.push('/');
                        }else{
                            if(res.errors_validation.email !== undefined){
                                this.errors.email.status = 'error';
                                this.errors.email.messages = res.errors_validation.email;
                            }
                            if(res.errors_validation.password !== undefined){
                                this.errors.password.status = 'error';
                                this.errors.password.messages = res.errors_validation.password;
                            }
                        }
                    })
            }
        }
    }


</script>