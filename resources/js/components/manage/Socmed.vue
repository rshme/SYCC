<style scoped>
h1.name-socmed {
  font-size: 24px;
}
.card-footer button {
  float: right;
  margin-left: 12px;
}

.new button {
  float: right;
}
</style>


<template>
  <div class="container">
    <div class="row new">
      <div class="col-12">
        <button class="btn btn-primary mt-3 mb-3" @click="createSocmed()">
          <i class="fas fa-plus"></i> Tambah Sosial Media
        </button>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 mb-2" v-for="socmed in socmeds" :key="socmed.id">
        <div class="card">
          <div class="card-body text-center">
            <h1 class="name-socmed">{{ socmed.name }}</h1>
          </div>
          <div class="card-footer">
            <div class="row justify-content-center">
              <button class="btn btn-success" @click="editSocmed(socmed)">
                <i class="fas fa-pen"></i> Edit
              </button>
              <button class="btn btn-danger" @click="deleteSocmed(socmed.id)">
                <i class="fas fa-trash"></i> Hapus
              </button>
            </div>
          </div>
        </div>
      </div>

      <div
        class="modal fade"
        id="modalSocmed"
        tabindex="-1"
        role="dialog"
        aria-labelledby="modalSocmedTitle"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalSocmedTitle"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="edit ? updateSocmed() : storeSocmed()" class="form-horizontal">
                <div class="form-group">
                  <label for="name">Nama Sosial Media</label>
                  <input
                    v-model="form.name"
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('name') }"
                  />
                  <has-error :form="form" field="name"></has-error>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" v-show="!edit">Create</button>
                <button type="submit" class="btn btn-primary" v-show="edit">Edit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    this.allSocmed();

    Fire.$on("refresh", () => {
      this.allSocmed();
    });
  },

  data() {
    return {
      socmeds: [],
      form: new Form({
        id: "",
        name: ""
      }),
      edit: false
    };
  },
  methods: {
    allSocmed() {
      axios
        .get("/api/socmed")
        .then(res => {
          this.socmeds = res.data;
        })
        .catch(err => {
          console.log(err);
        });
    },

    createSocmed() {
      this.edit = false;
      this.form.reset();
      $("#modalSocmedTitle").text("Tambah Sosial Media");
      $("#modalSocmed").modal("show");
    },

    editSocmed(socmed) {
      this.edit = true;
      this.form.reset();
      $("#modalSocmed").modal("show");
      this.form.fill(socmed);
    },

    storeSocmed() {
      this.form
        .post("/api/socmed")
        .then(res => {
          if (res.status === 201) {
            $("#modalSocmed").modal("hide");
            swal.fire({
              type: "success",
              text: "Berhasil Menambahkan Sosial Media",
              showConfirmButton: false,
              timer: 3000
            });
            Fire.$emit("refresh");
          }
        })
        .catch(err => {
          swal.fire("Oops!", "Something went wrong", "error");
        });
    },

    updateSocmed() {
      this.form
        .put("/api/socmed/" + this.form.id)
        .then(res => {
          if (res.status === 200) {
            $("#modalSocmed").modal("hide");
            swal.fire({
              type: "success",
              text: "Sosial media berhasil di edit !",
              showConfirmButton: false,
              timer: 3000
            });
            this.form.reset();
            Fire.$emit("refresh");
          }
        })
        .catch(err => {
          console.log(err);
        });
    },

    deleteSocmed(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "Yakin akan menghapus sosial media ini?",
          type: "warning",
          showCancelButton: true,
          cancelButtonColor: "#3085d6",
          confirmButtonColor: "#d33",
          confirmButtonText: "Ya, Hapus!",
          cancelButtonText: "Batal"
        })
        .then(result => {
          if (result.value) {
            axios
              .delete(`/api/socmed/${id}`)
              .then(() => {
                swal.fire({
                  type: "success",
                  title: "Deleted !",
                  text: "Sosial media Telah Dihapus !",
                  showConfirmButton: false,
                  timer: 3000
                });
                Fire.$emit("refresh");
              })
              .catch(err => {
                console.log(err);
              });
          }
        });
    }
  }
};
</script>
