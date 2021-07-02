<template>
    <div class="registerDisplay">
        <header><h1>Venturi</h1></header>
        <div>
            <h2>Registrate</h2>
            <p>Ingresá a la red social donde mejor podes comunicar lo que pensas</p>
        </div>
        <div>
            <RegisterForm 
                @registrado="auth($event)"
            />
        </div>
    </div>
</template>

<script>
import RegisterForm from '@/components/RegisterForm.vue';
import authService from '@/services/auth';
export default {
  name: 'Register',
   components: {
    RegisterForm
  },
  methods:{
      auth (credentials){
          authService.login(credentials.email, credentials.password)
            .then(res => {
                if(res){
                    console.log(res);
                    this.$router.push('/');
                }else{
                    console.log('Register errors');
                }
            })
      }
  }
}
</script>