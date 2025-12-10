<script setup lang="ts">
import { type HTMLAttributes, computed } from 'vue'
import { ComboboxGroup, ComboboxLabel, useForwardProps } from 'reka-ui'
import { cn } from '@/lib/utils'

const props = defineProps<{ class?: HTMLAttributes['class'], heading?: string }>()

const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props

  return delegated
})

const forwarded = useForwardProps(delegatedProps)
</script>

<template>
  <ComboboxGroup
    v-bind="forwarded"
    :class="cn('overflow-hidden p-1 text-foreground [&_[data-reka-combobox-group-label]]:px-2 [&_[data-reka-combobox-group-label]]:py-1.5 [&_[data-reka-combobox-group-label]]:text-xs [&_[data-reka-combobox-group-label]]:font-medium [&_[data-reka-combobox-group-label]]:text-muted-foreground', props.class)"
  >
    <ComboboxLabel v-if="heading" class="px-2 py-1.5 text-xs font-medium text-muted-foreground">
        {{ heading }}
    </ComboboxLabel>
    <slot />
  </ComboboxGroup>
</template>
