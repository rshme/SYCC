<style scoped>
h1.name-game {
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
        <button class="btn btn-primary mt-3 mb-3" @click="createGame()">
          <i class="fas fa-plus"></i> Tambah Game
        </button>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 mb-2" v-for="game in games" :key="game.id">
        <div class="card">
          <div class="card-body text-center">
            <h1 class="name-game">{{ game.name }}</h1>
          </div>
          <div class="card-footer">
            <div class="row justify-content-center">
              <button class="btn btn-success" @click="editGame(game)">
                <i class="fas fa-pen"></i> Edit
              </button>
              <button class="btn btn-danger" @click="deleteGame(game.id)">
                <i class="fas fa-trash"></i> Hapus
              </button>
            </div>
          </div>
        </div>
      </div>

      <div
        class="modal fade"
        id="modalGame"
        tabindex="-1"
        role="dialog"
        aria-labelledby="modalGameTitle"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalGameTitle"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="edit ? updateGame() : storeGame()" class="form-horizontal">
                <div class="form-group">
                  <label for="name">Nama Game</label>
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
    this.allGame();

    Fire.$on("refresh", () => {
      this.allGame();
    });
  },

  data() {
    return {
      games: [],
      form: new Form({
        id: "",
        name: ""
      }),
      edit: false
    };
  },
  methods: {
    allGame() {
      axios
        .get("/api/game")
        .then(res => {
          this.games = res.data;
        })
        .catch(err => {
          console.log(err);
        });
    },

    createGame() {
      this.edit = false;
      this.form.reset();
      $("#modalGameTitle").text("Tambah Game");
      $("#modalGame").modal("show");
    },

    editGame(game) {
      this.edit = true;
      this.form.reset();
      $("#modalGame").modal("show");
      this.form.fill(game);
    },

    storeGame() {
      this.form
        .post("/api/game")
        .then(res => {
          if (res.status === 201) {
            $("#modalGame").modal("hide");
            swal.fire({
              type: "success",
              text: "Berhasil Menambahkan Game !",
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

    updateGame() {
      this.form
        .put("/api/game/" + this.form.id)
        .then(res => {
          if (res.status === 200) {
            $("#modalGame").modal("hide");
            swal.fire({
              type: "success",
              text: "Game berhasil di edit !",
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

    deleteGame(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "Yakin akan menghapus Game ini?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Ya, Hapus!",
          cancelButtonText: "Batal"
        })
        .then(result => {
          if (result.value) {
            axios
              .delete(`/api/game/${id}`)
              .then(() => {
                swal.fire({
                  type: "success",
                  title: "Deleted !",
                  text: "Game Telah Dihapus !",
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
