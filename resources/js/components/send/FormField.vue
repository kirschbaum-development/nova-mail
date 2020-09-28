<template>
  <div>
    <div class="card mb-6 overflow-hidden">
      <div class="flex w-2/3 justify-between px-8 pt-4">
        <div
          class="help-text mr-4"
        >Adjust an existing mail template or craft an email from scratch! You can use normal blade syntax and include attributes from this resources model&hellip;</div>
      </div>

      <div class="flex border-b border-40 remove-bottom-border px-8 py-4">
        <div class="w-full pb-2">
          <select
            name="mail_template_select"
            id="mail-template-select"
            dusk="mail-template-select"
            v-model="selectedTemplate"
            class="form-control form-select mb-4"
            v-if="hasTemplates"
          >
            <option value disabled="disabled">Select Mail Template&hellip;</option>

            <option
              :value="template"
              v-for="(template, index) in templates"
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
          />

          <input
              name="delay-override"
              id="delay-override"
              dusk="delay-override"
              type="number"
              v-model="delayInMinutes"
              placeholder="Send Delay (in minutes)"
              class="w-full form-control form-input form-input-bordered mt-4"
          />

          <textarea
            name="template_override"
            id="template-override"
            dusk="template-override"
            rows="10"
            v-model="body"
            placeholder="Body"
            class="w-full form-control form-input form-input-bordered py-3 h-auto mt-4"
          ></textarea>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import Init from '../../mixins/Init';
import InteractsWithTemplates from '../../mixins/InteractsWithTemplates';

export default {
  mixins: [FormField, HandlesValidationErrors, InteractsWithTemplates],

  data() {
    return {
      selectedTemplate: '',
      body: '',
      subject: '',
      delayInMinutes: 0
    }
  },

  methods: {
    /**
     * Catch-all for any field update.
     */
    handleAnyFieldChange() {
      this.handleChange(this.mailFields);
    },
  },

  computed: {
    mailFields() {
      return JSON.stringify({
        subject: this.subject,
        body: this.body,
        resourceId: this.resourceId,
        resourceName: this.resourceName,
        send_delay_in_minutes: this.delayInMinutes,
        selectedTemplate: this.selectedTemplate,
      });
    },
  },

  watch: {
    subject(newValue, oldValue) {
      this.handleAnyFieldChange();
    },

    body(newValue, oldValue) {
      this.handleAnyFieldChange();
    },

    selectedTemplate(newValue, oldValue) {
      this.subject = newValue.subject;
      this.body = newValue.content;
      this.delayInMinutes = newValue.send_delay_in_minutes;
      this.handleAnyFieldChange();
    }
  },
}
</script>
