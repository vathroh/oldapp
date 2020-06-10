<template>
  <div>
    <form @submit.prevent="handleSubmit">
      <div class="form-group">
        <label for="kabupaten">Tahun Kegiatan</label>
        <select name="tahunBKM" id="tahunBKM" class="form-control input-lg dynamic" ref="tahunBKM">
          <option value>TAHUN</option>
          <option v-for="year in years" :value="year.tahun">{{ year.tahun}}</option>
        </select>
      </div>
      <div>
        <div class="form-group">
          <label for="kabupaten">Pilih Kabupaten</label>
          <select
            name="kabupaten"
            id="kabupaten"
            class="form-control input-lg dynamic"
            ref="kabupaten"
          >
            <option value>KABUPATEN</option>
            <option v-for="regency in regencies" :value="regency.kode_kab">{{regency.nama_kab}}</option>
          </select>
        </div>
      </div>
      <div>
        <div class="form-group">
          <label for="kelurahan">Pilih Kelurahan</label>
          <select
            name="kelurahan"
            id="kelurahan"
            class="form-control input-lg dynamic"
            ref="kelurahan"
          >
            <option value>KELURAHAN</option>
          </select>
        </div>
      </div>
      <div>
        <div class="form-group">
          <label for="jenisDokumen">Pilih Dokumen</label>
          <select
            name="jenisDokumen"
            id="jenisDokumen"
            class="form-control input-lg dynamic"
            ref="jenisDokumen"
          >
            <option value>PILIH DOKUMEN YANG AKAN DIUPLOAD</option>
            <option value="PRA DESAIN">PRA DESAIN</option>
            <option value="BERITA ACARA PEMAKETAN">BERITA ACARA PEMAKETAN</option>
            <option value="PEMBENTUKAN KPP">PEMBENTUKAN KPP</option>
            <option value="RENCANA KERJA KPP">RENCANA KERJA KPP</option>
            <option value="PENCAIRAN TAHAP 1">PENCAIRAN TAHAP 1</option>
            <option value="PENCAIRAN TAHAP 2">PENCAIRAN TAHAP 2</option>
            <option value="LPJ BKM">LPJ BKM</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <Fileinput v-on:file-change="setFiles"></Fileinput>
      </div>
      <div class="form-group">
        <button class="btn btn-success" type="submit">Upload</button>
      </div>
    </form>
    <Progressbar :progress="progress"></Progressbar>
  </div>
</template>

<script>
import Fileinput from "./Fileinput";
import Progressbar from "./ProgressBar";
export default {
  methods: {
    getYears() {
      axios
        .get("/tahun")
        .then(response => (this.years = response.data))
        .catch(error => console.log(error));
    },
    getRegencies() {
      axios
        .get("/kabupaten")
        .then(response => (this.regencies = response.data))
        .catch(error => console.log(error));
    },
    handleSubmit() {
      let formData = new FormData();
      for (let file of this.files) {
        formData.append("file_name[]", file, file.name);
      }
      formData.append("tahunBKM", this.$refs.tahunBKM.value);
      formData.append("kabupaten", this.$refs.kabupaten.value);
      formData.append("kelurahan", this.$refs.kelurahan.value);
      formData.append("jenisDokumen", this.$refs.jenisDokumen.value);

      axios
        .post("/uploaddoc", formData, {
          onUploadProgress: e => {
            if (e.lengthComputable) {
              this.progress = (e.loaded / e.total) * 100;
              console.log(this.progress);
            }
          }
        })
        .then(res => {
          console.log("upload selesai");
        })
        .catch(err => {
          console.log("upload gagal");
        });
    },
    setFiles(files) {
      if (files != undefined) {
        this.files = files;
      }
    }
  },
  components: {
    Fileinput,
    Progressbar
  },
  data() {
    return {
      years: [],
      regencies: [],
      villages: [],
      doc_items: [],
      files: "",
      progress: 0
    };
  },
  mounted() {
    this.getYears();
    this.getRegencies();
  }
};
</script>