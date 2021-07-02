<template>
    <nav>
        <ul>   
            <li>Inicio</li>
            <li>
                {{ this.user.user }}
                <ul>
                    <li @click="logout()">Cerrar sesión</li>
                    <li>Mi perfil</li>
                </ul>
            </li>
        </ul>
    </nav>

</template>

<script>

    import userService from '@/services/users';
    import authService from '@/services/auth';

    export default {
        name: 'NavMenu',
    
        created: function(){

            authService.verificarAutenticacion()
                .then(res => {
                if (res !== null) {
                    this.user.id = res.id;
                    this.user.user = res.user;
                    this.user.name = res.name;
                    this.user.surname = res.surname;
                    this.user.email = res.email;
                } else {
                     this.$router.push('/login');
                }
                });
        },

        data: function() {
            return {
                user:{
                    id: null,
                    user: null,
                    name: null,
                    surname: null,
                    email: null,
                }
            }
        },
        methods: {
            logout (){
                authService.logout()
                    .then(res => {
                        if(res.success){
                            this.$router.push('/login');
                        }else{
                            console.log(res.errors);
                        }
                    })
            }
        }
    }


</script>