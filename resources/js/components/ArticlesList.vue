<template>
  <div>
    <h2>Articles</h2>
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
    }
  }
};
</script>