<template>
    <div class="loginDisplay">
        <header><h1>Venturi</h1></header>
        <div>
            <h2>Ingresá</h2>
            <p>Logeate con tu cuenta para poder empezar a compartir!</p>
        </div>
        <div>
            <LoginForm/>
        </div>
    </div>
</template>

<script>
import LoginForm from '@/components/LoginForm.vue';
import authService from '@/services/auth';

export default {
  name: 'Login',
   components: {
    LoginForm
  },
  
}
</script>