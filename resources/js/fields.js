Nova.booting(Vue => {
    Vue.component('form-send-mail', require('./components/send/FormField'));
    Vue.component('index-events', require('./components/events/IndexField'));
    Vue.component('detail-events', require('./components/events/DetailField'));
    Vue.component('form-events', require('./components/events/FormField'));
});
