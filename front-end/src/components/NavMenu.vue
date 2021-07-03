<template>
    <nav class="navMenu">
        <ul>   
            <li class="homeBtn"><router-link :to="`/`">Inicio</router-link></li>
            <li class="profileBtn">
                <span @click="displayProfileMenu()">{{ this.user.user }}</span>
                <ul id="ProfileMenu">
                    <li @click="logout()">Cerrar sesión</li>
                    <li><router-link :to="`/profile`">Mi perfil</router-link></li>
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
                },
                ProfileMenu:{
                    status:null,
                }
            }
        },
        methods: {
            displayProfileMenu(){

                let ProfileMenuDOM = document.getElementById('ProfileMenu');
                if(this.ProfileMenu.status === null){
                    this.ProfileMenu.status = true;
                    ProfileMenuDOM.style.transform = "translateY(-180%)";
                    ProfileMenuDOM.style.transition = "0.5s";
                }else{
                    console.log(ProfileMenuDOM.style.transform);
                    this.ProfileMenu.status = null;
                    ProfileMenuDOM.style.transform = "translateX(0%)";
                    ProfileMenuDOM.style.transition = "0.5s";
                }
            },
            logout (){
                authService.logout()
                    .then(res => {
                        if(res.success){
                            this.$router.push('/login');
                        }else{
                            console.log(res.errors);
                        }

                        console.log(res);
                    })
            }
        }
    }


</script>

<style lang="scss">

    .navMenu{
        width:100%;
        height:50px;
        display:block;
        z-index:50;
        padding-left:10px;
        padding-right:10px;
        padding-top:10px;
        
        >ul{
            width:100%;
            height:50px;
            display:grid;
            grid-template-columns: 50px 1fr 50px;
            grid-template-rows: 1fr;
            grid-template-areas:'home create profile';

            .homeBtn{
                grid-area:home;
                width:40px;
                height:40px;
                display:block;
                background-image: url(../../src/assets/icons/home.png);
                background-repeat: no-repeat;
                background-size:contain;
                background-position:center;
                >a{
                    width:40px;
                    height:40px;
                    display:block;
                    text-decoration:none;
                    color:black;
                    font-size:0;
                    
                }
            }

            .profileBtn{
                grid-area:profile;
                width:40px;
                height:40px;
                display:block;
                >span{
                    display:block;
                    font-size:0;
                    width:40px;
                    height:40px;
                    background-image: url(../../src/assets/icons/profile.png);
                    background-repeat: no-repeat;
                    background-size:contain;
                    background-position:center;
                }

                >ul{
                    width:150px;
                    height:70px;
                    background-color:#f4f4f4;
                    position:relative;
                    bottom:0px;
                    right:110px;
                    display:grid;
                    grid-template-columns:1fr;
                    grid-template-rows:1fr 1fr;
                    list-style:none;
                    grid-gap:5px;
                    margin-bottom:10px;
                    border:1px solid rgba(0, 0, 0, 0.1);
                    border-radius:10px;
                    z-index:1;
                    >li{
                        width:100%;
                        text-align:right;
                        padding:5px 10px 5px 5px;
                        color:black;
                        font-size:15px;

                        >a{
                            display:block;
                            width:100%;
                            text-decoration:none;
                            color:black;
                            font-size:15px;
                        }
                    }
                }
            }

        }
    }
</style>