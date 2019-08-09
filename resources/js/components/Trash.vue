<style scoped>
.new {
  padding-top: 20px;
}

.new button {
  float: right;
  margin-bottom: 24px;
  margin-left: 12px;
}

.name h2 {
  font-size: 24px;
  margin-bottom: 12px;
}

.account .card-footer button {
  float: right;
  margin-left: 12px;
}
</style>

<template>
  <div class="container">
    <div class="row">
      <div class="col-md-4 mt-3" v-for="trash in alltrash" :key="trash.id">
        <div class="card">
          <div class="card-body">
            <p v-if="trash.game_id === null">Account: {{ trash.socmed.name }}</p>
            <p v-else>Account: {{ trash.game.name }}</p>
            <p v-if="trash.username != null">Username: {{ trash.username }}</p>
            <p v-if="trash.email != null">Email: {{ trash.email }}</p>
            <p>Password: {{ trash.password }}</p>
            <p v-if="trash.description != null">Password: {{ trash.description }}</p>
          </div>
          <div class="card-footer">
            <button class="btn btn-danger" @click="deleteTrash(trash.id)">
              <i class="fas fa-trash"></i> Hapus
            </button>
            <button class="btn btn-success" @click="restoreTrash(trash.id)">
              <i class="fas fa-sync-alt"></i> Restore
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    this.allTrash();
    Fire.$on("refresh", () => {
      this.allTrash();
    });
  },

  data() {
    return {
      alltrash: []
    };
  },
  methods: {
    allTrash() {
      axios
        .get("/api/trash")
        .then(res => {
          this.alltrash = res.data;
        })
        .catch(err => {
          console.log(err);
        });
    },

    restoreTrash(id) {
      axios
        .put(`/api/trash/${id}`)
        .then(res => {
          if (res.status === 200) {
            swal.fire({
              type: "success",
              text: "Akun telah kembalikan",
              showConfirmButton: false,
              timer: 3000
            });

            Fire.$emit("refresh");
          }
        })
        .catch(err => {
          console.log(err);
        });
    },

    deleteTrash(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "Yakin untuk menghapus permanen akun ini?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Ya, Hapus!",
          cancelButtonText: "Batal"
        })
        .then(result => {
          if (result.value) {
            axios
              .delete(`/api/trash/${id}`)
              .then(() => {
                swal.fire({
                  type: "success",
                  title: "Deleted !",
                  text: "Akun Telah Dihapus !",
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
