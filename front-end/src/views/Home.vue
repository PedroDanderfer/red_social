<template>
    <div class="HomeDisplay">
        <header><h1>Venturi</h1></header>
        <div>
            <h2>Home</h2>
        </div>
        <NavMenu/>
    </div>
</template>

<script>
import authService from '@/services/auth';
import NavMenu from '@/components/NavMenu.vue';

export default {
  name: 'Home',
  components: {
    NavMenu
  },
  
}
</script>