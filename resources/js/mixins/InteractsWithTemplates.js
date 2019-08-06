export default {
    data() {
        return {
            templates: [],
        }
    },

    mounted() {
        this.getTemplates();
    },

    methods: {
        getTemplates() {
            Nova.request()
                .get('/nova-mail/templates')
                .then(({ data }) => this.templates = data.templates || []);
        },
    },

    computed: {
        hasTemplates() {
            return Boolean(this.templates.length);
        },
    },
}