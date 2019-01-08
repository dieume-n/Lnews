<template>
  <div>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: !pagination.prevPage }">
            <a class="page-link" href="#" @click ="fetchArticles( pagination.prevPage )">Previous</a>
        </li>
        <li class="page-item disabled">
            <a class="page-link text-dark" href="#">Page {{ pagination.currentPage }} of {{ pagination.lastPage }}</a>
        </li>

        <li class="page-item" :class="{ disabled: !pagination.nextPage }">
            <a class="page-link" href="#" @click ="fetchArticles( pagination.nextPage )">Next</a>
        </li>
      </ul>
    </nav>
    <div class="card card-body mb-2" v-for="article in articles" :key="article.id">
        <h3>{{ article.title.toUpperCase() }}</h3>
        <p>{{ article.body }}</p>
        <div>
            <button type="button" class="btn btn-info text-light mb-2">Edit</button>
        <button type="button" class="btn btn-danger mb-2" @click="deleteArticle(article.id)">Delete</button>
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
        id: "",
        title: "",
        body: ""
      },
      article_id: null,
      pagination: {},
      edit: false
    };
  },
  created() {
    this.fetchArticles();
    Event.$on('articleAdded', ()=> {
        this.fetchArticles();
    });
  },
  methods: {
    fetchArticles(pageUrl) {
      let vm = this;
      pageUrl = pageUrl || "./api/articles";

      fetch(pageUrl)
        .then(response => response.json())
        .then(response => {
          this.articles = response.data;
          vm.makePagination(response.meta, response.links);
        })
        .catch(errors => console.log(errors));
    },
    makePagination(meta, links) {
      let pagination = {
        currentPage: meta.current_page,
        lastPage: meta.last_page,
        nextPage: links.next,
        prevPage: links.prev
      };

      this.pagination = pagination;
    },
    deleteArticle(id){
        if(confirm('Are you sure?')){
            fetch(`./api/article/${id}`, {
                method: 'delete'
            })
            .then(response => response.json())
            .then(data => {
                alert('Article Removed');
                this.fetchArticles();
            })
        }
        
    }
  }
};
</script>