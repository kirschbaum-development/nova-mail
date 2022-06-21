<template>
  <div>
    <div class="py-3 px-8">
      <p class="leading-normal help-text">
        Adjust an existing mail template or craft an email from scratch! You can use normal blade syntax and include attributes from this resources model&hellip;
      </p>
    </div>
    <div v-if="hasTemplates">
      <DefaultField :field="field" fieldName="Mail Template">
        <template #field>
          <select
            name="mail_template_select"
            id="mail-template-select"
            dusk="mail-template-select"
            v-model="selectedTemplate"
            class="w-full block form-control form-select form-select-bordered"
          >
            <option value disabled="disabled">Select Mail Template&hellip;</option>
            <option
              :value="template"
              v-for="(template, index) in templates"
              :key="index"
              v-text="template.name"
            ></option>
          </select>
        </template>
      </DefaultField>
    </div>
    <div>
      <DefaultField :field="field" fieldName="Subject">
        <template #field>
          <input
            name="subject"
            id="subject"
            dusk="subject"
            type="text"
            v-model="subject"
            placeholder="Subject"
            class="w-full form-control form-input form-input-bordered"
            required
          />
        </template>
      </DefaultField>
    </div>
    <div>
      <DefaultField :field="field" fieldName="Send Delay">
        <template #field>
          <input
            name="send-delay-in-minutes"
            id="send-delay-in-minutes"
            dusk="send-delay-in-minutes"
            type="number"
            v-model="delayInMinutes"
            placeholder="Send Delay (in minutes)"
            class="w-full form-control form-input form-input-bordered mt-4"
          />
        </template>
      </DefaultField>
    </div>
    <div>
      <DefaultField :field="field" fieldName="Body">
        <template #field>
          <textarea
            name="template_override"
            id="template-override"
            dusk="template-override"
            rows="10"
            v-model="body"
            placeholder="Body"
            class="w-full form-control form-input form-input-bordered py-3 h-auto mt-4"
            required
          ></textarea>

        </template>
      </DefaultField>
    </div>
  </div>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import InteractsWithTemplates from '../../mixins/InteractsWithTemplates';

export default {
  mixins: [FormField, HandlesValidationErrors, InteractsWithTemplates],

  props: ['field'],

  data() {
    return {
      selectedTemplate: '',
      body: '',
      subject: '',
      delayInMinutes: null
    }
  },

  methods: {
    /**
     * Catch-all for any field update.
     */
    handleAnyFieldChange() {
      this.value = this.mailFields;
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

    delayInMinutes(newValue, oldValue) {
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
