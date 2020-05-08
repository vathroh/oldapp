<template>
  <div class="container">
    <div class="admin-page-title">Buat Artikel Baru</div>
    <div class="wrap-form">
      <div class="bg-form">
        <div class="form-group">
          <input type="title" class="form-control" id="title" placeholder="title" />
        </div>
        <div class="form-group">
          <textarea class="form-control" id="body" placeholder="body" rows="8"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    create() {
      const formData = new formData();
      formData.append("title", this.$refs.title.value);
      formData.append("body", this.$refs.body.value);
      formData.append("user_id", this.userId);
    }
  }
};
</script>