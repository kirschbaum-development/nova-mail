Nova.booting((Vue, router, store) => {
    Vue.component('index-send-mail', require('./components/IndexField'));
    Vue.component('detail-send-mail', require('./components/DetailField'));
    Vue.component('form-send-mail', require('./components/FormField'));
})
