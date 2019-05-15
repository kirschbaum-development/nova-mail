<template>
    <tr>
        <td>
            From...
        </td>

        <td>
            {{ mail.subject }}
        </td>

        <td>
            <span class="whitespace-no-wrap text-left" v-html="mail.content"></span>
        </td>

        <td>
            <span class="whitespace-no-wrap text-left" v-text="date"></span>
        </td>

        <td class="td-fit text-right pr-6">
            <span>
                <a :href="mailUrl"
                   class="cursor-pointer text-70 hover:text-primary mr-3"
                   data-testid="users-items-0-view-button"
                   dusk="1-view-button"
                   title="View">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         width="22" height="18" viewBox="0 0 22 16"
                         aria-labelledby="view" role="presentation"
                         class="fill-current">
                        <path d="M16.56 13.66a8 8 0 0 1-11.32 0L.3 8.7a1 1 0 0 1 0-1.42l4.95-4.95a8 8 0 0 1 11.32 0l4.95 4.95a1 1 0 0 1 0 1.42l-4.95 4.95-.01.01zm-9.9-1.42a6 6 0 0 0 8.48 0L19.38 8l-4.24-4.24a6 6 0 0 0-8.48 0L2.4 8l4.25 4.24h.01zM10.9 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"></path>
                    </svg>
                </a>
            </span>
        </td>
    </tr>
</template>

<script>
    export default {
        props: {
            initialMail: {
                type: Object,
                require: true
            }
        },

        data() {
            return {
                mail: {},
            }
        },

        mounted() {
            axios.get(`/nova-mail/sent-mail/${this.initialMail.id.value}`).then(({ data }) => this.mail = data.mail)
        },

        computed: {
            date() {
                let now = moment();
                let date = moment.utc(this.mail.created_at).tz(moment.tz.guess());
                if (date.isSame(now, 'minute')) {
                    return 'just now';
                }
                if (date.isSame(now, 'day')) {
                    return `at ${date.format('LT')}`;
                }
                if (date.isSame(now, 'year')) {
                    return `on ${date.format('MMM D')}`;
                }
                return `on ${date.format('ll')}`;
            },

            mailUrl() {
                return `/nova/resources/nova-sent-mails/${this.mail.id}`;
            }
        },
    }
</script>
