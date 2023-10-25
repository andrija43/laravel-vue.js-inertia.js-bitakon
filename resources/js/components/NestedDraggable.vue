<template>
  <draggable
    class="dragArea"
    tag="ul"
    :list="tasks"
    :group="{ name: 'g' }"
    item-key="text"
    @start="dragging = true"
    @end="dragging = false"
  >
    <template #item="{ element }">
      <li>
        <div
          class="d-flex justify-content-between align-items-center p-2 border rounded"
        >
          <p>
            <i class="fa fa-arrows-alt" aria-hidden="true"></i>
            {{ element.text }}
          </p>
          <div>
            <button class="btn btn-light btn-sm" @click="edit(element.id)">
              <i class="fas fa-pen"></i>
            </button>
            <button class="btn btn-light btn-sm" @click="remove(element.id)">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        </div>
        <nested-draggable :tasks="element.children" />
      </li>
    </template>
  </draggable>
</template>

<script setup>
"use strict";

import draggable from "vuedraggable"
import { menu } from "@/composables/menuComposable"
import { ref } from "vue"
defineProps({
  tasks: {
    required: true
  }
})
const dragging = ref(false)
const remove = (id) => {
  menu.contentId = id
  menu.removeItem()
}
const edit = (id) => {
  menu.contentId = id
  menu.editItem()
}
</script>
