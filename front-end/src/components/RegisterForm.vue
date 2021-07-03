<template>

    <form action="#" @submit.prevent="register(registro)">
        <div>
            <p>Nombre de usuario</p>
            <input type="text" name="user" v-model="this.registerData.user" placeholder="Nombre de usuario"/>
            <ul v-if="errors.user.status === 'error'" class="errorForm">
                <li v-for="error in errors.user.messages"><p>{{ error }}</p></li>
            </ul>
        </div>
        <div>
            <p>Nombre</p>
            <input type="text" name="name" v-model="this.registerData.name" placeholder="Nombre"/>
            <ul v-if="errors.name.status === 'error'" class="errorForm">
                <li v-for="error in errors.name.messages"><p>{{ error }}</p></li>
            </ul>
        </div>
        <div>
            <p>Apellido</p>
            <input type="text" name="surname" v-model="this.registerData.surname" placeholder="Apellido"/>
            <ul v-if="errors.surname.status === 'error'" class="errorForm">
                <li v-for="error in errors.surname.messages"><p>{{ error }}</p></li>
            </ul>
        </div>
        <div>
            <p>Correo electronico</p>
            <input type="email" name="email" v-model="this.registerData.email" placeholder="Correo electronico"/>
            <ul v-if="errors.email.status === 'error'" class="errorForm">
                <li v-for="error in errors.email.messages"><p>{{ error }}</p></li>
            </ul>
        </div>
        <div>
            <p>Contraseña</p>
            <input type="password" name="password" v-model="this.registerData.password" placeholder="Contraseña"/>
            <ul v-if="errors.password.status === 'error'" class="errorForm">
                <li v-for="error in errors.password.messages"><p>{{ error }}</p></li>
            </ul>
        </div>
        <div>
            <p>Confirmar contraseña</p>
            <input type="password" name="confirm_password" v-model="this.registerData.confirm_password" placeholder="Confirmar contraseña"/>
            <ul v-if="errors.confirm_password.status === 'error'" class="errorForm">
                <li v-for="error in errors.confirm_password.messages"><p>{{ error }}</p></li>
            </ul>
        </div>
        <div>
            <input type="submit" value="Registrarme"/>
        </div>
    </form>

</template>

<script>

    import userService from '@/services/users';

    export default {
        name: 'RegisterForm',
    
        data: function() {
            return {
                registerData:{
                    user: null,
                    name: null,
                    surname: null,
                    email: null,
                    password: null,
                    confirm_password:null
                },
                errors: {
                    user: {
                        status:null,
                        messages:[]
                    },
                    name: {
                        status:null,
                        messages:[]
                    },
                    surname: {
                        status:null,
                        messages:[]
                    },
                    email: {
                        status:null,
                        messages:[]
                    },
                    password: {
                        status:null,
                        messages:[]
                    },
                    confirm_password:{
                        status:null,
                        messages:[]
                    }
                },
                status: {
                    msg: null,
                    type: 'success',
                }
            }
        },
        methods: {
            register(){

                this.errors.user.status = null;
                this.errors.user.messages = [];

                this.errors.name.status = null;
                this.errors.name.messages = [];

                this.errors.surname.status = null;
                this.errors.surname.messages = [];

                this.errors.email.status = null;
                this.errors.email.messages = [];

                this.errors.password.status = null;
                this.errors.password.messages = [];

                this.errors.confirm_password.status = null;
                this.errors.confirm_password.messages = [];

                userService.register(this.registerData)
                    .then(res => {
                        if(res.success){
                            this.$emit('registrado', this.registerData);
                        }else{
                            if(res.errors_validation.user !== undefined){
                                this.errors.user.status = 'error';
                                this.errors.user.messages = res.errors.user;
                            }
                            if(res.errors_validation.name !== undefined){
                                this.errors.name.status = 'error';
                                this.errors.name.messages = res.errors.name;
                            }
                            if(res.errors_validation.surname !== undefined){
                                this.errors.surname.status = 'error';
                                this.errors.surname.messages = res.errors.surname;
                            }
                            if(res.errors_validation.email !== undefined){
                                this.errors.email.status = 'error';
                                this.errors.email.messages = res.errors.email;
                            }
                            if(res.errors_validation.password !== undefined){
                                this.errors.password.status = 'error';
                                this.errors.password.messages = res.errors.password;
                            }
                            if(res.errors_validation.confirm_password !== undefined){
                                this.errors.confirm_password.status = 'error';
                                this.errors.confirm_password.messages = res.errors_validation.confirm_password;
                            }
                            
                        }
                    })
            }
        }
    }


</script>