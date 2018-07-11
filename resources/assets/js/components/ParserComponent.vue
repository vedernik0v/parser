<template>
  <div class="title m-b-md">
    <input type="input"
           v-model="request.s"
           @keydown.enter="parse"
           placeholder='https://habr.com class="stacked-menu__item-link"'>
    <button  @click="parse">OK</button>
  </div>
  <div class="alert alert-danger">
    <ul>
      <li v-for="error in response.errors">
        {{ error }}
      </li>
    </ul>
  </div>
  <dev> {{ response.html }} </dev>
</template>

<script>
export default {
  mounted() {
    console.log('ParserComponent mounted.')
  },
  data () {
    return {
      request: {
        s: ''
      },
      response: {
        html: '',
        errors: []
      }
    }
  },
  methods: {
    parse () {
      axios.post('/api/p', this.request)
           .then((res) => {
             this.response = res.data
           })
           .catch((err) => {
             console.log(err)
           })
    }
  }
}
</script>
