import FormSendMailField from './components/send/FormField'
import IndexEventsField from './components/events/IndexField'
import DetailEventsField from './components/events/DetailField'
import FormEventsField from './components/events/FormField'

Nova.booting((app, store) => {
    app.component('form-send-mail', FormSendMailField);
    app.component('index-events', IndexEventsField);
    app.component('detail-events', DetailEventsField);
    app.component('form-events', FormEventsField);
})