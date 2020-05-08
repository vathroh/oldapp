<template>
  <div>
    <div class="input-group">
      <input
        type="text"
        :value="getFilesName()"
        readonly
        class="form-control"
        placeholder="Pilih gambar."
      />
      <span class="input-group-btn">
        <button class="btn btn-default" type="button" @click="showFilePicker">
          <i class="fas fa-paperclip"></i>
        </button>
      </span>
    </div>
    <input type="file" ref="file" style="display:none;" @change="onChange" multiple />
  </div>
</template>

<script>
export default {
  watch: {
    chunks(n, o) {
      if (n.length > 0) {
        this.upload();
      }
    }
  },
  data() {
    return {
      files: [],
      chunks: [],
      uploaded: 0
    };
  },
  methods: {
    showFilePicker() {
      this.$refs.file.click();
    },
    onChange(event) {
      this.files = event.target.files;
      this.$emit("file-change", this.files);
    },
    getFilesName() {
      let filesName = [];
      if (this.files.length > 0) {
        for (let file of this.files) {
          filesName.push(file.name);
        }
      }
      return filesName.join(", ");
    }
  }
};
</script>