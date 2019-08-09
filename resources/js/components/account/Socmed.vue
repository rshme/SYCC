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
    <div class="row new">
      <div class="col-12 col-new">
        <button class="btn btn-primary" @click="createAccount()">
          <i class="fas fa-plus"></i> Add Account
        </button>
      </div>
    </div>
    <div v-for="socmed in accounts" :key="socmed.id">
      <div class="row name">
        <div class="col-12">
          <h2>{{ socmed.name }}</h2>
        </div>
      </div>
      <div class="row account" v-if="socmed.account.length > 0">
        <div class="col-md-4 mb-3" v-for="account in socmed.account" :key="account.id">
          <div class="card">
            <div class="card-body">
              <p v-if="account.username != null">Username: {{ account.username }}</p>
              <p v-if="account.email != null">Email: {{ account.email }}</p>
              <p>Password: {{ account.password }}</p>
              <p v-if="account.description != null">Deskripsi: {{ account.description }}</p>
            </div>
            <div class="card-footer">
              <button class="btn btn-danger" @click="deleteAccount(account.id)">
                <i class="fas fa-trash"></i> Hapus
              </button>
              <button class="btn btn-success" @click="editAccount(account)">
                <i class="fas fa-pen"></i> Edit
              </button>
            </div>
          </div>
        </div>
      </div>
      <div v-else>
        <div class="row">
          <div class="col-12 mb-3">
            <div class="alert alert-danger">
              <p>Belum ada akun untuk sosial media {{ socmed.name }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      class="modal fade"
      id="modal-account"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modal-accountTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5
              class="modal-title"
              id="modal-accountTitle"
            >{{ edit ? 'Edit Account' : 'Create Account' }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form
              @submit.prevent="edit ? updateAccount() : storeAccount()"
              class="form-horizontal"
              id="form-account"
            >
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="socmed_id">socmed</label>
                </div>
                <select
                  class="custom-select"
                  :class="{ 'is-invalid' : form.errors.has('socmed_id')}"
                  id="socmed_id"
                  name="socmed_id"
                  v-model="form.socmed_id"
                >
                  <option
                    v-for="option in options"
                    :key="option.id"
                    :value="option.id"
                  >{{ option.name }}</option>
                </select>
                <has-error :form="form" field="socmed_id"></has-error>
              </div>
              <div class="form-group">
                <label for="username">Username</label>
                <input
                  v-model="form.username"
                  type="text"
                  id="username"
                  name="username"
                  placeholder="Kosongkan bila tidak ada"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('username') }"
                />
                <has-error :form="form" field="username"></has-error>
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input
                  v-model="form.email"
                  type="email"
                  id="email"
                  name="email"
                  placeholder="Kosongkan bila tidak ada"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('email') }"
                />
                <has-error :form="form" field="email"></has-error>
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input
                  v-model="form.password"
                  type="password"
                  id="password"
                  name="password"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('password') }"
                />
                <has-error :form="form" field="password"></has-error>
              </div>

              <div class="form-group">
                <label for="description">Keterangan</label>
                <textarea
                  v-model="form.description"
                  name="description"
                  id="description"
                  class="form-control"
                  placeholder="Tambahkan keterangan tentang akun, biarkan kosong jika tidak ada"
                  :class="{ 'is-invalid': form.errors.has('description') }"
                ></textarea>
                <has-error :form="form" field="description"></has-error>
              </div>
              <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" v-show="!edit">Create</button>
              <button type="submit" class="btn btn-primary" v-show="edit">Edit</button>
            </form>
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
      accounts: [],
      options: [],
      form: new Form({
        id: "",
        socmed_id: "",
        username: "",
        email: "",
        description: "",
        password: ""
      }),
      edit: false
    };
  },
  methods: {
    allSocmed() {
      axios
        .get("/api/accountsm")
        .then(res => {
          this.accounts = res.data;
          this.options = res.data;
          // console.log(res.data);
        })
        .catch(err => {
          console.log(err);
        });
    },

    createAccount() {
      this.edit = false;
      this.form.reset();
      $("#modal-accountTitle").text("Tambah Account");
      $("#modal-account").modal("show");
    },

    editAccount(account) {
      this.edit = true;
      this.form.reset();
      $("#modal-account").modal("show");
      this.form.fill(account);
    },

    storeAccount() {
      this.form
        .post("/api/accountsm")
        .then(res => {
          if (res.status === 201) {
            $("#modal-account").modal("hide");
            swal.fire({
              type: "success",
              text: "Berhasil Menambahkan Akun !",
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

    updateAccount() {
      this.form
        .put("/api/accountsm/" + this.form.id)
        .then(res => {
          if (res.status === 200) {
            $("#modal-account").modal("hide");
            swal.fire({
              type: "success",
              text: "Akun berhasil di edit !",
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

    deleteAccount(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "Yakin untuk menghapus akun ini?",
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
              .delete(`/api/accountsm/${id}`)
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

