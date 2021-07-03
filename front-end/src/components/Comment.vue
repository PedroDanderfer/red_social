<template>
    <li>
        <ul>
            <li>
                <p>{{ comment.user_name+' '+comment.user_surname }}</p>
                <form action="DELETE" @submit.prevent="this.delete()">
                    <input type="submit" value="Borrar"/>
                </form>
            </li>
            <li><p>{{ '@'+comment.user_user }}</p></li>
            <li><p>{{ comment.content }}</p></li>
            <li><p>{{ comment.created_at }}</p></li>
        </ul>
    </li>
</template>

<script>

import commentService from '@/services/comments';

export default {
    name: 'Comment',
    props:['comment'],

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
                commentService.delete(this.comment.id)
                    .then(res => {
                        if(res.success){
                            window.location.reload();
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