<template>
    <Header/>
    <div class="PostDisplay">
        <Post
          :post="post"
          :comments="comments"
          :key="post.id"
        ></Post>
    </div>
    <NavMenu/>
</template>

<script>
import authService from '@/services/auth';
import postService from '@/services/posts';
import NavMenu from '@/components/NavMenu.vue';
import Header from '@/components/Header.vue';
import Post from '@/components/Post.vue';


export default {
  name: 'Home',
  components: {
    NavMenu,Post, Header
  },

  created: function(){
      postService.byId(this.$route.params.id)
        .then(res => {
            if(res.success){
              this.comments  = res.comments.slice();
              this.comments = this.comments.reverse();
              this.post = res.post;
            }else{
              console.log('errors');
            }
        })
  },

  data: function(){
    return{
      post:[],
      comments:[]
    }
  }
  
}
</script>

<style lang="scss">
  .PostDisplay{
    width:100%;
    height:calc(100vh - 100px);
    overflow-y:scroll;

    padding: 10px 10px 10px 10px;

    >div{
      >div:first-of-type{
      width:100%;
      padding:10px 10px 10px 10px;
      border:1px solid rgba(0,0,0,0.1);
      border-radius:5px;
      background-color:white;

      >ul{
        list-style:none;

        >li:first-of-type{
            font-size:15px;
            display:grid;
            grid-template-columns: 1fr 70px;

            >p{
                display:flex;
                align-self:center;
            }

            >form{
                display:flex;
                justify-self:flex-end;
                height:30px;
                width:30px;

                >input[type=submit]{
                    width:30px;
                    height:30px;
                    background-image: url(../../src/assets/icons/trash.png);
                    background-repeat: no-repeat;
                    background-size:contain;
                    background-position:center;
                    background-color:transparent;
                    border: 1px solid transparent;
                    outline:none;
                    font-size:0;
                }
            }
        }
        >li:nth-of-type(2){
            font-size:14px;
        }

        >li:nth-of-type(3){
            font-size:15px;
            margin-top:10px;
        }

        >li:last-of-type{
            margin-top:10px;
            font-size: 13px;
        }
      }
    }

    >div:last-of-type{
      margin-top:10px;
      width:100%;
      padding:10px 10px 10px 10px;
      border:1px solid rgba(0,0,0,0.1);
      border-radius:5px;
      background-color:white;

      >div:first-of-type{
        width:100%;
        display:block;
        >form{
          width:100%;
            display:grid;
            grid-template-columns: 1fr;
            grid-template-rows: 1fr 40px;
          
          >div:first-of-type{
              textarea{
                  width:100%;
                  resize:none;
                  height:80px;
                  outline:none;
                  border:1px solid transparent;
                  font-size:14px;
                  padding:5px 5px 5px 5px;
              }   
          }

          >div:last-of-type{
              width: 100px;
              height: 30px;
              align-self:center;
              justify-self:flex-end;

              input[type=submit]{
                  width: 100%;
                  height: 30px;
                  outline:none;
                  border:1px solid transparent;
                  border-radius:5px;
                  background-color:#33ff64;
                  font-size:12.5px;
              }
          }
        }
      }

      >div:last-of-type{
        width:100%;
        margin-top:10px;
        >ul{
          list-style:none;
          width:100%;
          display:grid;
          grid-template-columns:1fr;
          grid-gap:10px;

          >li{
            width:100%;
            margin-top:10px;
            border-bottom:1px solid rgba(0,0,0,0.2);
            padding:5px 5px 5px 5px;

            >ul{
                list-style:none;

                >li:first-of-type{
                    font-size:15px;
                    display:grid;
                    grid-template-columns: 1fr 70px;

                    >p{
                      display:flex;
                      align-self:center;
                    }

                    >form{
                        display:flex;
                        justify-self:flex-end;
                        height:30px;
                        width:30px;

                        >input[type=submit]{
                            width:30px;
                            height:30px;
                            background-image: url(../../src/assets/icons/trash.png);
                            background-repeat: no-repeat;
                            background-size:contain;
                            background-position:center;
                            background-color:transparent;
                            border: 1px solid transparent;
                            outline:none;
                            font-size:0;
                        }
                    }
                }
                >li:nth-of-type(2){
                    font-size:14px;
                }

                >li:nth-of-type(3){
                    font-size:15px;
                    margin-top:10px;
                }

                >li:last-of-type{
                    margin-top:10px;
                    font-size: 13px;
                }
            }
          }
        }
      }
    }
    }

    
  }
</style>