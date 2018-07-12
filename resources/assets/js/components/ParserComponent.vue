<template>
<div class="content">
  <div class="title m-b-md">
    <input type="input"
           v-model="request.s"
           @keydown.enter="parse"
           placeholder='https://habr.com class="stacked-menu__item-link"'>
    <button  @click="parse">OK</button>
  </div>
  <div class="alert alert-danger" v-if="errors.length">
    <ul>
      <li v-for="error in errors">
        {{ error }}
      </li>
    </ul>
  </div>
  {{ html }}
</div>
</template>

<script>
export default {
  mounted() {
    console.log('ParserComponent mounted.');
  },
  data () {
    return {
      request: {
        s: ''
      },
      html: '',
      errors: []
    }
  },
  methods: {
    parse () {
      this.html = '';
      this.errors = [];
      axios.post('/api/p', this.request)
           .then( (res) => {
             this.s = res.data.s;
             this.html = res.data.html;
             // console.info(res)
           })
           .catch( (err) => {
             // по какой-то причине не вижу ответа в консоли браузера
             console.log(err)
           });
    }
  }
}
</script>
