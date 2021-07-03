<template>
  <router-view/>
</template>

<style lang="scss">

@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap');

*{
  margin: 0;
  padding: 0;
  box-sizing:border-box;
  font-family: 'Roboto', sans-serif;
}

body{
  overflow: hidden;
}
#app{
  display:block;
  width:100%;
  height: 100vh;
  overflow:hidden;
  background-color:#f4f4f4;
  max-width:480px;
  margin-left:auto;
  margin-right:auto;
}


.errorForm{
  background-color:white;
  width:1005;
  list-style:none;
  border:1px solid white;
  border-radius: 5px;
  padding: 5px 5px 5px 5px;
  margin-top: 5px;

  >li{
    display:block;
    width:100%;
    margin-top: 2px;

    >p{
      font-size:12px;
      color:red;
    }
  }

  >li:first-of-type{
    margin-top:0;
  }
}
</style>
