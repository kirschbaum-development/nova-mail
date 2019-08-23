Nova.booting((Vue, router, store) => {
    Vue.component('form-send-mail', require('./components/send/FormField'));
    Vue.component('index-model-events', require('./components/events/IndexField'));
    Vue.component('detail-model-events', require('./components/events/DetailField'));
    Vue.component('form-model-events', require('./components/events/FormField'));
})
