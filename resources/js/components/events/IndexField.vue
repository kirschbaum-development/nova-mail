<template>
  <span>{{ eventCount }}</span>
</template>

<script>
export default {
  props: ['resourceName', 'field'],

  computed: {
    eventCount() {
      return JSON.parse(this.field.value).length;
    },
  },
}
</script>
