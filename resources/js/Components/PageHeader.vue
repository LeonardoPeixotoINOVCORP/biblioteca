<script setup>
const props = defineProps({
  title: {
    type: String,
    required: true
  }
})
</script>

<template>
  <div class="flex items-center justify-between h-8">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ title }}
    </h2>
    <slot name="actions"></slot> <!-- Para botões adicionais -->
  </div>
</template>