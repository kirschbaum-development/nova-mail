<template>
  <span>{{ eventCount }}</span>
</template>

<script>
export default {
  props: ['resourceName', 'field'],

  computed: {
    eventCount() {
      return this.field.value && Array.isArray(this.field.value) && this.field.value.length || 0;
    },
  },
}
</script>
