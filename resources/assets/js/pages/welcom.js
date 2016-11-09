require('../components')
import Greeting from '../components/Greeting.vue'

var app = new Vue({
    name: 'App',
    el: '#app',
    components: { Greeting },
    data: {
        test: 'This is from the welcome page component'
    }
})
