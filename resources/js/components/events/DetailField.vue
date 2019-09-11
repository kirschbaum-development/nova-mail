<template>
  <panel-item :field="field">
    <template slot="value">
      <div
        style="background-clip: border-box;"
        class="relative rounded-t-lg shadow bg-30 border border-60"
      >
        <div class="flex border-b border-50">
          <div class="flex-1 uppercase font-bold text-xs text-80 tracking-wide px-3 py-3">Model</div>
          <div
            class="flex-1 uppercase font-bold text-xs text-80 tracking-wide px-3 py-3 border-l border-50"
          >Event Name</div>
          <div
            class="flex-1 uppercase font-bold text-xs text-80 tracking-wide px-3 py-3 border-l border-50"
          >Column</div>
          <div
            class="flex-1 uppercase font-bold text-xs text-80 tracking-wide px-3 py-3 border-l border-50"
          >Value</div>
        </div>
      </div>

      <div v-if="events.length > 0" class="bg-white rounded-b-lg overflow-hidden">
        <div v-for="(item, index) in events" :key="index" class="flex items-center">
          <div class="flex flex-grow border-b border-50">
            <div class="flex-1 cursor-text">
              <textarea
                type="text"
                :disabled="true"
                v-html="item.model"
                class="font-mono text-sm resize-none block hover:bg-20 min-h-input w-full form-control form-input form-input-row py-4"
              />
            </div>

            <div class="flex-1 cursor-text">
              <div class="border-l border-50">
                <textarea
                  type="text"
                  :disabled="true"
                  v-html="item.event"
                  class="font-mono text-sm resize-none block hover:bg-20 min-h-input w-full form-control form-input form-input-row py-4"
                ></textarea>
              </div>
            </div>

            <div class="flex-1 cursor-text">
              <div class="border-l border-50">
                <textarea
                  type="text"
                  :disabled="true"
                  v-html="item.column"
                  class="font-mono text-sm resize-none block hover:bg-20 min-h-input w-full form-control form-input form-input-row py-4"
                ></textarea>
              </div>
            </div>

            <div class="flex-1 cursor-text">
              <div class="border-l border-50">
                <textarea
                  type="text"
                  :disabled="true"
                  v-html="itemValueHtml(item)"
                  class="font-mono text-sm resize-none block hover:bg-20 min-h-input w-full form-control form-input form-input-row py-4"
                ></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="bg-white overflow-hidden">
        <div class="flex items-center">
          <div class="flex flex-grow border-b border-50">
            <textarea
              type="text"
              :disabled="true"
              class="text-center font-mono text-sm resize-none block hover:bg-20 min-h-input w-full form-control form-input form-input-row py-4"
            >No Model Events attached...</textarea>
          </div>
        </div>
      </div>
    </template>
  </panel-item>
</template>

<script>
import InteractsWithEvents from '../../mixins/InteractsWithEvents';

export default {
  mixins: [InteractsWithEvents],

  props: ['resource', 'resourceName', 'resourceId', 'field'],

  methods: {
    itemValueHtml(item) {
      return item.value ? item.column + ' == ' + item.value : '';
    }
  },

  computed: {
    events() {
      return _.map(this.field.value, (event, key) => {
        return {
          model: event.model,
          event: event.name,
          column: event.column,
          value: event.value,
        };
      });
    },
  },
}
</script>
