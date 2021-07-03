<template>
    <li class="PostItem">
            <ul>
                <li>
                    <p>{{ post.user_name+' '+post.user_surname }}</p>
                    <form action="DELETE" @submit.prevent="this.delete()">
                        <input type="submit" value="Borrar"/>
                    </form>
                </li>
                <li>
                    <p>{{ post.user_user }}</p>
                </li>
                <li>
                    <p>{{ post.content }}</p>
                </li>
                <li>
                    <p><router-link :to="`/post/${post.id}`">Ver más</router-link></p>
                    <p>Publicado: {{ post.created_at }}</p>
                </li>
            </ul>
    </li>
</template>

<script>

    import postService from '@/services/posts.js';

    export default {
        name: 'PostItem',
        props: ['post'],

        data:function(){
            return{
                notification:{
                    status:null,
                    message:null
                }
            }
        },

        methods:{
              delete(){
                postService.delete(this.post.id)
                    .then(res => {
                        if(res.success){
                            window.location.reload()
                        }else{
                            if(res.errors){
                                this.notification.success = 'errors';
                                this.notification.errors = res.errors;
                            }else{
                                this.notification.success = 'errors';
                                this.notification.errors = 'Opss... Ocurrio un problema';
                            }

                            this.$emit('notification', this.notification);
                        }
                    });
            }
        }
    }


</script>

<style lang="scss">
    .PostItem{
        width:100%;
        border: 1px solid rgba(0,0,0,0.1);
        border-radius:5px;
        background-color:white;
        padding: 5px 5px 5px 5px;
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
            display:grid;
            grid-template-columns: 70px 1fr;

            >p:first-of-type{
                a{
                    
                color:black;
                }
            }

            >p:last-of-type{
                display:flex;
                justify-self:flex-end;
            }
        }
    }
        
    }
</style>