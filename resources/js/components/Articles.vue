<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Example Component</div>

                <div class="card-body">
                   
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
     data() {
            return {
                articles: [],
                article: {
                    id: '',
                    title: '',
                    body: '',
                },
                article_id:'',
                pagination:{},
                edit:false
            }
        },
        created() {
         this.fetchArticles();
        },
        method: {
         fetchArticles() {
             fetch
         }
        }
    }
</script>
