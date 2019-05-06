<template>
  <div class="py-4 border-t border-40">
    <div class="text-80 text-sm">Sent {{ date }}</div>
    <br>
    <div class="italic">
      <template v-if="mail.content">
        <div v-html="mail.content"></div>
      </template>
      <template v-else>Content not available..</template>
    </div>
  </div>
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
    axios.get(`/nova-mail/mail/${this.initialMail.id.value}`).then(({ data }) => this.mail = data.mail)
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
  },
}
</script>
