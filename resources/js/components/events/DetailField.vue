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
          >Event</div>
          <div
            class="flex-1 uppercase font-bold text-xs text-80 tracking-wide px-3 py-3 border-l border-50"
          >Column</div>
        </div>
      </div>

      <div v-if="modelEvents.length > 0" class="bg-white rounded-b-lg overflow-hidden">
        <div v-for="(item, index) in modelEvents" :key="index" class="flex items-center">
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
                  v-html="isEvent(item.event) ? item.event : 'updated'"
                  class="font-mono text-sm resize-none block hover:bg-20 min-h-input w-full form-control form-input form-input-row py-4"
                ></textarea>
              </div>
            </div>

            <div class="flex-1 cursor-text">
              <div class="border-l border-50">
                <textarea
                  type="text"
                  :disabled="true"
                  v-html="isEvent(item.event) ? '' : item.event + ' (value=' + item.value + ')'"
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
import InteractsWithModelEvents from '../../mixins/InteractsWithModelEvents';

export default {
  mixins: [InteractsWithModelEvents],

  props: ['resource', 'resourceName', 'resourceId', 'field'],

  computed: {
    modelEvents() {
      return _.map(JSON.parse(this.field.value) || [], (value, key) => {
        return {
          model: value.model,
          event: value.event,
          value: value.value,
        };
      });
    },
  },
}
</script>
