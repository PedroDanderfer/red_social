<template>
<Notification v-if="notification.status !== null" :text="notification.message" :type="notification.status"></Notification>
    <div>
        <div>
            <ul>
                <li>
                    <p>{{ post.user_name+' '+post.user_surname }}</p>
                    <form action="DELETE" @submit.prevent="this.delete()">
                        <input type="submit" value="Borrar"/>
                    </form>
                </li>
                <li><p>{{ post.user_user }}</p></li>
                <li><p>{{ post.content }}</p></li>
                <li><p>{{ post.created_at }}</p></li>
            </ul>
        </div>
        <div>
            <div>
                <form action="POST" @submit.prevent="this.comment(comment)">
                    <div>
                        <textarea name="content" v-model="this.createCommentData.content"></textarea>
                        <ul v-if="errors.content.status === 'error'" class="errorForm">
                            <li v-for="error in errors.content.messages"><p>{{ error }}</p></li>
                        </ul>
                    </div>
                    <div>
                        <input type="submit" value="Comentar"/>
                    </div>
                </form>
            </div>
            <div>
                <ul>
                    <Comment
                        v-for="comment in comments"
                        :comment="comment"
                        :key="comment.id"
                        @notification="notificationDisplay($event)"
                    ></Comment>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import Comment from '@/components/Comment.vue';
    import commentService from '@/services/comments.js';
    import postService from '@/services/posts.js';
    import Notification from '@/components/Notification.vue';

    export default {
        name: 'Post',
        props: ['post', 'comments'],
        components: {
            Comment,Notification
        },
        data: function(){
            return{
                createCommentData:{
                    content:null,
                    post_id:this.$route.params.id,
                },
                errors:{
                    content:{
                        status:null,
                        messages:[]
                    }
                },
                notification:{
                    status:null,
                    message:null
                }
            }
        },
        methods: {
            notificationDisplay(data){
                console.log(data);
                if(data.errors){  
                    this.notification.status = 'error';
                    this.notification.message = data.errors;
                }else{
                    this.notification.status = 'error';
                    this.notification.message = 'Opss... Ocurrio un problema';
                }
            },

        

            comment(){
                commentService.comment(this.createCommentData)
                    .then(res => {
                        if(res.success){
                            window.location.reload()
                        }else{
                            if(res.errors){
                                this.notification.status = 'error';
                                this.notification.message = res.errors;
                            }else if(res.errors_validation){
                                this.errors.content.status = 'error';
                                this.errors.content.messages = res.errors_validation.content;
                            }else{
                                this.notification.status = 'error';
                                this.notification.message = 'Opss... Ocurrio un problema';
                            }
                        }
                    })
            },
            delete(){
                postService.delete(this.post.id)
                    .then(res => {
                        if(res.success){
                            this.$router.push('/');
                        }else{
                            if(res.errors){
                                this.notification.status = 'error';
                                this.notification.message = res.errors;
                            }else if(res.errors_validation){
                                this.errors.content.status = 'error';
                                this.errors.content.messages = res.errors_validation.content;
                            }else{
                                this.notification.status = 'error';
                                this.notification.message = 'Opss... Ocurrio un problema';
                            }
                        }
                    });
            },

        }
    }


</script>