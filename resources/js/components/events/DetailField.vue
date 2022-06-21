<template>
  <PanelItem :index="index" :field="field">
    <template #value>
      <div class="relative">
        <div class="overflow-hidden overflox-x-auto relative">
          <table class="w-full table-default">
            <thead class="bg-gray-50 dark:bg-gray-800">
              <tr>
                <th class="text-left px-2 whitespace-nowrap uppercase text-xxs text-gray-500 tracking-wide py-2">Model</th>
                <th class="text-left px-2 whitespace-nowrap uppercase text-xxs text-gray-500 tracking-wide py-2">Event Name</th>
                <th class="text-left px-2 whitespace-nowrap uppercase text-xxs text-gray-500 tracking-wide py-2">Column</th>
                <th class="text-left px-2 whitespace-nowrap uppercase text-xxs text-gray-500 tracking-wide py-2">Value</th>
              </tr>
            </thead>
            <tbody v-if="events.length > 0">
              <tr class="group" v-for="(item, index) in events" :key="index">
                <td class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 cursor-pointer whitespace-nowrap dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                  <div class="text-left">
                    <span class="text-90 whitespace-nowrap" v-html="item.model"></span>
                  </div>
                </td>
                <td class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 cursor-pointer whitespace-nowrap dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                  <div class="text-left">
                    <span class="text-90 whitespace-nowrap" v-html="item.event"></span>
                  </div>
                </td>
                <td class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 cursor-pointer whitespace-nowrap dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                  <div class="text-left">
                    <span v-if="item.column" class="text-90 whitespace-nowrap" v-html="item.column"></span>
                    <span v-else><p>—</p></span>
                  </div>
                </td>
                <td class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 cursor-pointer whitespace-nowrap dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                  <div class="text-left">
                    <span v-if="item.value != null" class="text-90 whitespace-nowrap" v-html="itemValueHtml(item)"></span>
                    <span v-else><p>—</p></span>
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody v-else>
              <tr class="group">
                <td colspan="4" class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 cursor-pointer whitespace-nowrap dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900 text-center">
                  No Model Events attached...
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </template>
  </PanelItem>
</template>

<script>
import InteractsWithEvents from '../../mixins/InteractsWithEvents';

export default {
  mixins: [InteractsWithEvents],

  props: ['resource', 'resourceName', 'resourceId', 'field'],

  methods: {
    itemValueHtml(item) {
      if (item.value) {
        return item.column + ' == ' + item.value;
      }

      return item.value == '' ? item.column + ' == ' + '""' : '';
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
