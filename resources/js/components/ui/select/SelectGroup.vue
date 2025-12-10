<script setup lang="ts">
import { computed } from "vue";
import { SelectGroup, type SelectGroupProps } from "reka-ui";
import { cn } from "@/lib/utils";

const props = defineProps<SelectGroupProps & { class?: string }>();

const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props;
  return delegated;
});
</script>

<template>
  <SelectGroup :class="cn('p-1', props.class)" v-bind="delegatedProps">
    <slot />
  </SelectGroup>
</template>
