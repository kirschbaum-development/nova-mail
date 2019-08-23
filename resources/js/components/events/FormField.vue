<template>
  <default-field :field="field" :errors="errors">
    <template v-if="field.models.length > 0" slot="field">
      <div :class="{'mt-3': index != 0}" v-for="(modelEvent, index) in modelEvents" :key="index">
        <select-control
          :class="errorClasses"
          :disabled="isReadonly"
          :options="field.models"
          v-model="modelEvent.model"
          class="w-full form-control form-select"
          :id="field.attribute + '-' + index + '-model'"
        >
          <option value selected>{{ __('Choose an option') }}</option>
        </select-control>

        <select-control
          v-if="modelEvent.model"
          v-model="modelEvent.event"
          :options="events(modelEvent)"
          class="mt-2 w-full form-control form-select"
          :id="field.attribute + '-' + index + '-event'"
        >
          <option value selected>{{ __('Choose an option') }}</option>
        </select-control>

        <div class="w-full" v-if="! isEvent(modelEvent.event) && isValidModelEvent(modelEvent)">
          <checkbox-with-label
            class="m-2"
            :checked="modelEvent.anyValue"
            @change="updateCheckedState(modelEvent, $event)"
          >Any Value?</checkbox-with-label>

          <input
            type="text"
            placeholder="Column Value"
            v-model="modelEvent.value"
            v-if="! modelEvent.anyValue"
            :id="field.attribute + '-' + index + '-value'"
            class="w-full form-control form-input form-input-bordered"
          />
        </div>

        <div class="mt-2 flex justify-end">
          <button
            type="button"
            @click.prevent="addModelEvent()"
            class="btn btn-default btn-primary inline-flex items-center"
            v-if="index == modelEvents.length - 1 && isValidModelEvent(modelEvent)"
            :class="{'mr-3': index != 0 || showClearFirstModelEventButton(index, modelEvent)}"
          >Add</button>
          <button
            type="button"
            @click.prevent="removeModelEvent(index)"
            v-if="index != 0 || modelEvents.length > 1"
            class="btn btn-link dim cursor-pointer text-80 pr-2"
          >Remove</button>
          <button
            type="button"
            @click.prevent="clearFirstModelEvent()"
            class="btn btn-link dim cursor-pointer text-80 pr-2"
            v-if="showClearFirstModelEventButton(index, modelEvent)"
          >Clear</button>
        </div>
      </div>
    </template>
    <template v-else slot="field">
      <div
        class="text-80 italic pt-2"
      >To send Mail Templates on a Model event - please update your "nova_mail" config!</div>
    </template>
  </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import Init from '../../mixins/Init';
import InteractsWithModelEvents from '../../mixins/InteractsWithModelEvents';

export default {
  mixins: [
    FormField,
    HandlesValidationErrors,
    Init,
    InteractsWithModelEvents
  ],

  data() {
    return {
      modelEvents: [],
      newModelEvent: {
        model: '',
        event: '',
        anyValue: true,
      },
    }
  },

  mounted() {
    this.$set(this, 'modelEvents', JSON.parse(this.field.value) || []);
    if (this.modelEvents.length == 0) {
      this.addModelEvent();
    }
  },

  methods: {
    events(modelEvent) {
      return modelEvent.model ? this.field.models.find(model => model.value == modelEvent.model).events : [];
    },

    addModelEvent() {
      this.modelEvents.push(_.clone(this.newModelEvent));
    },

    removeModelEvent(index) {
      this.modelEvents.splice(index, 1);
    },

    clearFirstModelEvent() {
      this.removeModelEvent(0);
      this.addModelEvent();
    },

    showClearFirstModelEventButton(index, modelEvent) {
      return index == 0 && this.modelEvents.length == 1 && this.isValidModelEvent(modelEvent);
    },

    isValidModelEvent(modelEvent) {
      return modelEvent.model != '' && modelEvent.event != ''
    },

    updateCheckedState(modelEvent, event) {
      modelEvent.anyValue = !modelEvent.anyValue;
    }
  },

  watch: {
    modelEvents: {
      handler(newValue, oldValue) {
        const data = _.filter(this.modelEvents, modelEvent => {
          return this.isValidModelEvent(modelEvent);
        });
        this.handleChange(JSON.stringify(data));
      },
      deep: true,
    },
  },
}
</script>
