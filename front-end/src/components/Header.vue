<template>
    <header>
        <h1><router-link :to="`/`">Venturi</router-link></h1>
    </header>
</template>

<script>

export default {
  name: 'Header',
 
}
</script>

<style lang="scss">

  header{
    width:100%;
    height:50px;
    display:block;
    >h1{
      display:block;
      font-size:30px;
      height:50px;
      width:fit-content;
      margin-left:auto;
      margin-right:auto;
      padding-top:6px;
      >a{
        display:block;
        color:black;
        text-decoration:none;
      }
    }
  }

</style>