<template>

    <form action="#" @submit.prevent="register(registro)">
        <div>
            <p>Nombre de usuario</p>
            <input type="text" name="user" v-model="this.registerData.user" placeholder="Nombre de usuario"/>
        </div>
        <div>
            <p>Nombre</p>
            <input type="text" name="name" v-model="this.registerData.name" placeholder="Nombre"/>
        </div>
        <div>
            <p>Apellido</p>
            <input type="text" name="surname" v-model="this.registerData.surname" placeholder="Apellido"/>
        </div>
        <div>
            <p>Correo electronico</p>
            <input type="email" name="email" v-model="this.registerData.email" placeholder="Correo electronico"/>
        </div>
        <div>
            <p>Contraseña</p>
            <input type="password" name="password" v-model="this.registerData.password" placeholder="Contraseña"/>
        </div>
        <div>
            <p>Confirmar contraseña</p>
            <input type="password" name="confirm_password" v-model="this.registerData.confirm_password" placeholder="Confirmar contraseña"/>
        </div>
        <input type="submit" value="Registrarme"/>
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
                    user: null,
                    name: null,
                    surname: null,
                    email: null,
                    password: null,
                    confirm_password:null
                },
                status: {
                    msg: null,
                    type: 'success',
                }
            }
        },
        methods: {
            register(){
                userService.register(this.registerData)
                    .then(res => {
                        if(res.success){
                            this.$emit('registrado', this.registerData);
                        }else{
                            console.log(res.errors);
                        }
                    })
            }
        }
    }


</script>