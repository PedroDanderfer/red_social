<template>
    <div class="createPostForm">
        <form action="POST" @submit.prevent="post(post)">
            <div>
                <textarea name="content" v-model="this.createPostData.content"></textarea>
                <ul v-if="errors.content.status === 'error'" class="errorForm">
                    <li v-for="error in errors.content.messages"><p>{{ error }}</p></li>
                </ul>
            </div>
            <div>
                <input type="submit" value="Publicar"/>
            </div>
        </form>
    </div>
</template>

<script>
import postService from '@/services/posts';

export default {
    name: 'CreatePostForm',
    data: function(){
        return{
            createPostData:{
                content:null
            },
            errors: {
                content: {
                    status:null,
                    messages:[]
                },
            }
        }
    },
    methods: {
        post(){

            this.errors.content.status = null;
            this.errors.content.messages = [];

            postService.post(this.createPostData)
                .then(res => {
                    if(res.success){
                        window.location.reload()
                    }else{
                        
                        if(res.errors){

                            console.log('mandar error al padre');

                        }else if(res.errors_validation){
                            this.errors.content.status = 'error';
                            this.errors.content.messages = res.errors_validation.content;
                        }else{
                            data = [];
                            data['type'] = 'errors';
                            data['message'] = 'Opss... Ocurrio un problema';
                            this.$emit("notification", data);
                        }
                    }
                })
        }
    }
}
</script>

<style lang="scss">
    .createPostForm{
        width:100%;
        padding: 5px 5px 5px 5px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius:5px;
        background-color:white;
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
</style>