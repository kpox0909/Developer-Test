<template>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header" style="background-color: rgba(0, 123, 255, 0.25);">Post</div>
                <div class="card-body">
                    <form @submit.prevent="createPost" action="/posts" method="post">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input v-model="form.title" type="text" name="title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Text</label>
                            <textarea v-model="form.text" name="text" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" style="background-color: #053569;">Submit</button>
                        </div>
                    </form>        
                </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card mb-3" v-for="post in posts">
            <div class="card-header" style="background-color: rgba(0, 123, 255, 0.25);">
                {{ post.user.profile.first_name + ' ' + post.user.profile.last_name }} -  {{ post.created_at }}
                
                <span class="float-right">
                    <a @click="deletePost(post.id)" href="javascript:void(0)" style="color:red;">delete</a>
                </span>
            </div>
            <div class="card-body">
                <h4>{{ post.title }}</h4>
                {{ post.text }}
            </div>
            <div class="card-footer " style="background-color: rgba(0, 123, 255, 0.25);">
                <ul>
                    <li v-for="comment in post.comments">
                        <small>{{ comment.user.profile.first_name + ' ' + comment.user.profile.last_name }} - {{ comment.text }}</small>
                    </li>
                </ul>
                <input v-model="post.comment_text" type="text" class="form-control">
                <button @click="createComment(post)" class="btn btn-sm btn-primary float-right mt-2" style="background-color: #053569;">Comment</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data () {
        return {
            posts: [],
            form: {}
        }
    },
    created () {
        this.getPosts()
    },
    methods: {
        getPosts () {
            axios.get('/posts').then(response => {
                this.posts = response.data
            })
        },
        createPost () {
            axios.post('/posts', this.form).then(response => {
                this.form = {}
                this.getPosts()
            })
        },
        deletePost (id) {
            axios.delete('/posts/' + id).then(response => {
                this.getPosts()
            })
        },
        createComment (post) {
            const form = {
                post_id: post.id ,
                text: post.comment_text
            }
            axios.post('/comments', form).then(response => {
                this.getPosts()
            })
        }
    }
}
</script>
