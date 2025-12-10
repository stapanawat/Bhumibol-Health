<script setup lang="ts">
import { ref, computed, watch, nextTick } from 'vue';
import {
  ComboboxRoot,
  ComboboxInput,
  ComboboxContent,
  ComboboxItem,
  ComboboxEmpty,
  ComboboxGroup,
  useForwardPropsEmits,
} from 'reka-ui';
import { Check, X } from 'lucide-vue-next';

interface Category {
  id: number | string;
  name_th: string;
}

const props = defineProps<{
  modelValue: string | number | null;
  categories: Category[];
}>();

const emits = defineEmits(['update:modelValue', 'create']);

const query = ref('');
const open = ref(false);

const selectedCategory = computed(() => {
    if (!props.modelValue) return null;
    return props.categories.find(c => String(c.id) === String(props.modelValue)) || { id: props.modelValue, name_th: props.modelValue };
});

const filteredCategories = computed(() => {
    if (query.value === '') return props.categories;
    return props.categories.filter((category) => {
        return category.name_th.toLowerCase().includes(query.value.toLowerCase());
    });
});

const inputRef = ref<InstanceType<typeof ComboboxInput> | null>(null);

function handleSelect(val: any) {
    emits('update:modelValue', val.id);
    query.value = '';
    open.value = false;
    nextTick(() => {
        if (inputRef.value?.$el) {
            inputRef.value.$el.value = '';
        }
    });
}

function handleCreate() {
    if (!query.value) return;
    emits('update:modelValue', query.value); 
    query.value = '';
    open.value = false;
    nextTick(() => {
        if (inputRef.value?.$el) {
            inputRef.value.$el.value = '';
        }
    });
}

function clearSelection() {
    emits('update:modelValue', '');
    query.value = '';
    nextTick(() => {
        if (inputRef.value?.$el) {
            inputRef.value.$el.value = '';
            inputRef.value.$el.focus();
        }
    });
}

function handleBackspace(e: KeyboardEvent) {
    if (!query.value && props.modelValue) {
        clearSelection();
    }
}
</script>

<template>
    <div class="group">
        <div class="flex items-center justify-between mb-2">
            <label class="block text-sm font-medium leading-6 text-foreground">
                Category
            </label>
            <button
                type="button"
                @click="clearSelection"
                v-if="modelValue"
                class="inline-flex items-center gap-1 rounded-md border border-input bg-background px-2 py-1 text-xs font-medium text-muted-foreground transition-all hover:bg-accent hover:text-accent-foreground"
            >
                <X class="w-3 h-3" />
                Clear
            </button>
        </div>

        <ComboboxRoot
            v-model:open="open"
            v-model:searchTerm="query" 
            class="relative w-full"
        >
            <div
                class="relative w-full rounded-md border border-input bg-background px-3 py-2 text-sm shadow-sm transition-all focus-within:ring-1 focus-within:ring-ring"
                @click="open = true"
            >
                <div class="flex flex-wrap gap-2 items-center min-h-[24px]">
                    
                    <!-- Selected Chip -->
                    <div v-if="selectedCategory" class="inline-flex items-center gap-1 rounded-full border border-transparent bg-secondary px-2.5 py-0.5 text-xs font-semibold text-secondary-foreground hover:bg-secondary/80 animate-in fade-in zoom-in-95 duration-200">
                        {{ (selectedCategory as Category).name_th }}
                        <button type="button" @click.stop="clearSelection" class="ml-1 text-muted-foreground hover:text-foreground">
                             <X class="w-3 h-3" />
                        </button>
                    </div>

                    <!-- Input -->
                    <ComboboxInput
                        ref="inputRef"
                        class="flex-1 bg-transparent border-none focus:ring-0 focus:outline-none text-sm py-1 placeholder:text-muted-foreground min-w-[100px]"
                        :placeholder="modelValue ? '' : 'Select or create...'"
                        @input="(e) => query = (e.target as HTMLInputElement).value"
                        @keydown.enter.prevent="handleCreate"
                        @keydown.delete="handleBackspace"
                    />
                </div>
            </div>

            <!-- Suggestions Dropdown -->
            <ComboboxContent
                class="absolute left-0 right-0 top-full mt-2 max-h-60 overflow-auto rounded-md border border-border bg-popover text-popover-foreground shadow-md z-50 p-1"
            >
                <ComboboxEmpty class="p-4 text-center text-sm text-muted-foreground">
                    No category found.
                    <button type="button" class="block w-full mt-2 text-primary hover:underline font-medium" @click="handleCreate">
                        Create "{{ query }}"
                    </button>
                </ComboboxEmpty>

                <ComboboxGroup>
                    <ComboboxItem
                        v-for="category in filteredCategories"
                        :key="category.id"
                        :value="category"
                        @select="handleSelect(category)"
                        class="relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none data-[highlighted]:bg-accent data-[highlighted]:text-accent-foreground"
                    >
                        <Check v-if="String(modelValue) === String(category.id)" class="mr-2 h-4 w-4" />
                        <span :class="{'ml-6': String(modelValue) !== String(category.id)}">{{ category.name_th }}</span>
                    </ComboboxItem>
                </ComboboxGroup>
            </ComboboxContent>
        </ComboboxRoot>

        <p class="mt-2 text-[0.8rem] text-muted-foreground">
             Press Enter to create a new category.
        </p>
    </div>
</template>
