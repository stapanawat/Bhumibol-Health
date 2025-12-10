<script setup lang="ts">
import { type HTMLAttributes, computed } from 'vue'
import { ComboboxRoot, useForwardPropsEmits } from 'reka-ui'
import { cn } from '@/lib/utils'

const props = withDefaults(defineProps<{ class?: HTMLAttributes['class'], open?: boolean, modelValue?: string }>(), {
  open: true,
  modelValue: '',
})

const emits = defineEmits(['update:modelValue', 'update:open'])

const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props

  return delegated
})

const forwarded = useForwardPropsEmits(delegatedProps, emits)
</script>

<template>
  <ComboboxRoot
    v-bind="forwarded"
    :class="cn('flex h-full w-full flex-col overflow-hidden rounded-md bg-popover text-popover-foreground', props.class)"
  >
    <slot />
  </ComboboxRoot>
</template>
