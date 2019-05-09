<template>
  <div>
    <h4 class="text-90 font-normal text-2xl mb-3">Mail</h4>

    <div class="card mb-6 overflow-hidden">
      <div class="flex border-b border-40 remove-bottom-border px-8">
        <div class="w-full pt-6 pb-2">
          <h3 class="text-90 font-bold text-lg mb-4">Send Mail</h3>

          <input
            name="from"
            id="from"
            dusk="from"
            type="text"
            v-model="from"
            class="w-full form-control form-input form-input-bordered mb-2"
            :placeholder="panel.fields[0].from"
          >

          <input
            name="subject"
            id="subject"
            dusk="subject"
            type="text"
            v-model="subject"
            :placeholder="selectedTemplate.subject || panel.fields[0].subject"
            class="w-full form-control form-input form-input-bordered mb-2"
          >

          <select
            name="mail_template_select"
            id="mail-template-select"
            dusk="mail-template-select"
            v-model="selectedTemplate"
            class="form-control form-select mb-2"
          >
            <option value disabled="disabled">Select Mail Template</option>
            <option
              :value="template"
              v-for="(template, index) in mailTemplates"
              :key="index"
            >{{ template.name }}</option>
          </select>

          <textarea
            name="template_override"
            id="template-override"
            dusk="template-override"
            rows="10"
            v-model="templateOverride"
            class="w-full form-control form-input form-input-bordered py-3 h-auto"
          ></textarea>
        </div>
      </div>

      <div class="flex justify-between px-8 pb-4 border-b border-40">
        <button
          class="btn btn-default btn-primary inline-flex items-center relative mt-4"
          type="submit"
          @click="handleSendMail"
        >Send Mail</button>
      </div>
      <div class="flex border-b border-40 remove-bottom-border px-8">
        <div class="w-full py-6">
          <h3 class="text-90 font-bold text-lg mb-4">Mail History</h3>

          <sent-mail :initial-mail="mail" v-for="(mail, index) in mails.resources" :key="index"></sent-mail>
        </div>
      </div>

      <div class="bg-20 rounded-b" v-if="hasPagination">
        <nav class="flex justify-between items-center">
          <button
            class="btn btn-link py-3 px-4"
            :class="paginationClass(hasNextLink)"
            :disabled="! hasNextLink"
            @click="getMails(mails.next_page_url)"
          >Older</button>

          <button
            class="btn btn-link py-3 px-4"
            :class="paginationClass(hasPrevLink)"
            :disabled="! hasPrevLink"
            @click="getMails(mails.prev_page_url)"
          >Newer</button>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
import SentMail from './SentMail'

export default {
  props: ['resourceName', 'resourceId', 'panel'],

  components: {
    SentMail
  },

  data() {
    return {
      mailTemplates: [],
      selectedTemplate: '',
      templateOverride: '',
      from: '',
      subject: '',
      baseMailUri: '/nova-api/nova-sent-mails',
      mails: {
        next_page_url: '',
        prev_page_url: '',
        resources: {},
      }
    }
  },

  mounted() {
    this.getMailTemplates()
    this.getMails(this.mailsUri);
  },

  computed: {
    mailsUri() {
      return `${this.baseMailUri}?page=1`
    },

    hasMails() {
      return Boolean(this.mails.length)
    },

    hasNextLink() {
      return Boolean(this.mails.next_page_url)
    },

    hasPrevLink() {
      return Boolean(this.mails.prev_page_url)
    },

    hasPagination() {
      return this.hasNextLink || this.hasPrevLink
    },

    mailsQueryParams() {
      return `&orderBy=created_at&orderByDirection=desc&viaResource=${this.resourceName}&viaResourceId=${this.resourceId}&viaRelationship=mails&relationshipType=hasMany`
    },
  },

  methods: {
    getMailTemplates() {
      axios.get('/nova-mail/templates').then(({ data }) => this.mailTemplates = data.templates || []);
    },

    paginationClass(isActive) {
      return isActive ? 'text-primary dim' : 'test-80 opacity-50'
    },

    getMails(uri) {
      axios.get(`${uri}${this.mailsQueryParams}`).then(({ data }) => this.mails = data)
    },

    handleSendMail() {
      axios.post(`/nova-mail/send/${this.selectedTemplate.id || ''}`, {
        model: this.panel.fields[0].model,
        resourceId: this.resourceId,
        content: this.templateOverride,
        from: this.from,
        subject: this.subject || this.selectedTemplate.subject,
      }).then(({ data }) => {
        this.getMails(this.mailsUri)
        this.resetForm()
        this.$toasted.show(`The mail has been sent.`, { type: 'success' });
      }).catch(response => this.$toasted.show(response, { type: 'error' }))
    },

    resetForm() {
      this.from = ''
      this.subject = ''
      this.templateOverride = ''
      this.selectedTemplate = ''
    }
  },

  watch: {
    selectedTemplate(newValue, oldValue) {
      this.templateOverride = this.selectedTemplate.content
    },
  },
}
</script>
