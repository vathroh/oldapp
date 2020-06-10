<template>
  <div class="progress">
    <div
      class="progress-bar progress-bar-info progress-bar-stripped"
      role="progressbar"
      :style="{width:getProgress}"
    >{{getProgress}}</div>
  </div>
</template>

<script>
export default {
  props: {
    progress: {
      type: Number,
      default: 0
    }
  },
  computed: {
    getProgress() {
      return Math.round(this.progress) + "%";
    },
    formData() {
      let formData = new FormData();
      formData.set("is_last", this.chunks.length === 1);
      formData.set("file", this.chunks[0], `${this.file.name}.part`);
      return formData;
    }
  }
};
</script>