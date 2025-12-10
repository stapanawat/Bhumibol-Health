<script setup lang="ts">
import { computed } from "vue";
import { SelectSeparator, type SelectSeparatorProps } from "reka-ui";
import { cn } from "@/lib/utils";

const props = defineProps<SelectSeparatorProps & { class?: string }>();

const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props;
  return delegated;
});
</script>

<template>
  <SelectSeparator v-bind="delegatedProps" :class="cn('-mx-1 my-1 h-px bg-slate-100', props.class)" />
</template>
