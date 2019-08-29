<template>
  <default-field :field="field" :errors="errors">
    <template v-if="field.eventables.length > 0" slot="field">
      <div :class="{'mt-3': index != 0}" v-for="(event, index) in events" :key="index">
        <select-control
          :class="errorClasses"
          :disabled="isReadonly"
          :options="field.eventables"
          v-model="event.model"
          class="w-full form-control form-select"
          :id="field.attribute + '-' + index + '-model'"
        >
          <option value selected>{{ __('Choose an option') }}</option>
        </select-control>

        <select-control
          v-if="event.model"
          v-model="event.name"
          :options="getEvents(event)"
          class="mt-2 w-full form-control form-select"
          :id="field.attribute + '-' + index + '-event'"
        >
          <option value selected>{{ __('Choose an option') }}</option>
        </select-control>

        <div class="w-full" v-if="! isEvent(event.name) && isValidEvent(event)">
          <checkbox-with-label
            class="m-2"
            :checked="event.anyValue || false"
            @change="updateCheckedState(event, $event)"
          >Any Value?</checkbox-with-label>

          <input
            type="text"
            placeholder="Column Value"
            v-model="event.value"
            v-if="! event.anyValue"
            :id="field.attribute + '-' + index + '-value'"
            class="w-full form-control form-input form-input-bordered"
          />
        </div>

        <div class="mt-2 flex justify-end">
          <button
            type="button"
            @click.prevent="addEvent()"
            class="btn btn-default btn-primary inline-flex items-center"
            v-if="index == events.length - 1 && isValidEvent(event)"
            :class="{'mr-3': index != 0 || showClearFirstEventButton(index, event)}"
          >Add</button>
          <button
            type="button"
            @click.prevent="removeEvent(index)"
            v-if="index != 0 || events.length > 1"
            class="btn btn-link dim cursor-pointer text-80 pr-2"
          >Remove</button>
          <button
            type="button"
            @click.prevent="clearFirstEvent()"
            class="btn btn-link dim cursor-pointer text-80 pr-2"
            v-if="showClearFirstEventButton(index, event)"
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
import InteractsWithEvents from '../../mixins/InteractsWithEvents';

export default {
  mixins: [
    FormField,
    HandlesValidationErrors,
    Init,
    InteractsWithEvents
  ],

  data() {
    return {
      events: [],
      newEvent: {
        id: null,
        model: '',
        name: '',
        anyValue: true,
      },
    }
  },

  mounted() {
    if (this.field.value) {
      this.$set(this, 'events', _.map(this.field.value, event => {
        return {
          ...event,
          anyValue: event.value ? false : true,
        };
      }));
    }

    if (this.events.length == 0) {
      this.addEvent();
    }
  },

  methods: {
    getEvents(event) {
      return event.model ? this.field.eventables.find(model => model.value == event.model).events : [];
    },

    addEvent() {
      this.events.push(_.clone(this.newEvent));
    },

    removeEvent(index) {
      this.events.splice(index, 1);
    },

    clearFirstEvent() {
      this.removeEvent(0);
      this.addEvent();
    },

    showClearFirstEventButton(index, event) {
      return index == 0 && this.events.length == 1 && this.isValidEvent(event);
    },

    isValidEvent(event) {
      return event.model != '' && event.name != ''
    },

    updateCheckedState(event, e) {
      event.anyValue = !event.anyValue;

      if (event.anyValue) {
        event.value = null;
      }
    }
  },

  watch: {
    events: {
      handler(newValue, oldValue) {
        const data = _.filter(this.events, event => {
          return this.isValidEvent(event);
        });
        this.handleChange(JSON.stringify(data));
      },
      deep: true,
    },
  },
}
</script>
