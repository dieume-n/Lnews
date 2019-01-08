<template>
    <div>
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">Edit Article</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body">
                    <form @submit.prevent="addArticle()">
                        <div class="form-group">
                            <label for="exampleFormControlInput1"><h3>Title</h3></label>
                            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Title" v-model="article.title">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1"><h3>Content</h3></label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" v-model="article.body"></textarea>
                        </div>
                    </form>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" @click="updateArticle()" :disabled="!submitDisabled">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                article:{
                    id: '',
                    title: '',
                    body: ''
                }
            }
        },
        created() {
            Event.$on('editArticle', (article)=> {
                this.article = article;
            });
        },
        methods:{
            updateArticle(){
                $('#editModal').modal('hide');
                fetch(`./api/article/${this.article.id}`, {
                    method: 'put',
                    body: JSON.stringify(this.article),
                    headers:{
                        'content-type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(response => {
                    this.article.title = '';
                    this.article.body = '';
                    Event.$emit( 'articleUpdated' );
                    alert("Article Updated");
                })
                .catch(error => console.log(error));

            }
        },
        computed:{
            submitDisabled(){
                return (this.article.title != '' && this.article.body != '') ? true : false;
            }
        }
    }
</script>