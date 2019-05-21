<template>
  <div>
    <div class="flex items-center mb-3">
      <h4 class="text-90 font-normal text-2xl flex-no-shrink">Mail</h4>
    </div>

    <div class="card mb-6 overflow-hidden">
      <div class="flex border-b border-40 remove-bottom-border px-8">
        <div class="w-full pt-6 pb-2">
          <h3 class="text-90 font-bold text-lg mb-4">Send mail to {{ to }}</h3>

          <select
            name="mail_template_select"
            id="mail-template-select"
            dusk="mail-template-select"
            v-model="selectedTemplate"
            @change="handleTemplateSelection"
            class="form-control form-select mb-4"
            v-if="hasTemplates"
          >
            <option value disabled="disabled">Select Mail Template&hellip;</option>

            <option
              :value="template"
              v-for="(template, index) in mailTemplates"
              :key="index"
              v-text="template.name"
            ></option>
          </select>

          <input
            name="subject"
            id="subject"
            dusk="subject"
            type="text"
            v-model="subject"
            placeholder="Subject"
            class="w-full form-control form-input form-input-bordered"
          >

          <textarea
            name="template_override"
            id="template-override"
            dusk="template-override"
            rows="10"
            v-model="templateOverride"
            class="w-full form-control form-input form-input-bordered py-3 h-auto mt-4"
          ></textarea>
        </div>
      </div>

      <div class="flex justify-between px-8 pb-6">
        <div
          class="help-text"
        >Adjust the mail template or craft an email from scratch above! You can use normal blade syntax and include attributes from this resources model...</div>

        <button
          class="btn btn-default btn-primary inline-flex items-center relative mt-4"
          type="submit"
          @click="handleSendMail"
          :disabled="! canSend"
        >Send Mail</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['resourceId', 'panel'],

  data() {
    return {
      mailTemplates: [],
      selectedTemplate: '',
      templateOverride: '',
      to: '',
      subject: '',
      model: {},
    }
  },

  mounted() {
    this.getMailTemplates();
    this.getMailable();
  },

  computed: {
    hasTemplates() {
      return Boolean(this.mailTemplates.length);
    },

    canSend() {
      return Boolean(this.subject !== '' && this.templateOverride !== '');
    },
  },

  methods: {
    getMailTemplates() {
      Nova.request()
        .get('/nova-mail/templates')
        .then(({ data }) => this.mailTemplates = data.templates || []);
    },

    getMailable() {
      Nova.request()
        .post('/nova-mail/mailable', {
          mailableClass: this.panel.fields[0].model,
          mailableId: this.resourceId,
        })
        .then(({ data }) => {
          this.model = data.model;
          this.to = data.to;
        });
    },

    handleTemplateSelection() {
      this.subject = this.selectedTemplate.subject;
      this.templateOverride = this.selectedTemplate.content;
    },

    handleSendMail() {
      Nova.request()
        .post(`/nova-mail/send/${this.selectedTemplate.id || ''}`, {
          model: this.panel.fields[0].model,
          resourceId: this.resourceId,
          content: this.templateOverride,
          to: this.to,
          subject: this.subject,
        })
        .then(({ data }) => {
          this.$toasted.show(`The mail has been sent.`, { type: 'success' });
          this.resetForm();
        })
        .catch(response => this.$toasted.show(response, { type: 'error' }));
    },

    resetForm() {
      this.selectedTemplate = '';
      this.subject = '';
      this.templateOverride = '';
    }
  },
}
</script>
